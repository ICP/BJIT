<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
use Joomla\Registry\Registry;

defined('_JEXEC') or die;
class J2StoreModelProductsBehaviorDownloadable extends F0FModelBehavior {

	private $_rawData = array();

	public function onAfterGetItem(&$model, &$record) {
		//sanity check
		if($record->product_type != 'downloadable') return;
		//we just have the products. Get the variants
		if($record->j2store_product_id) {

			$variantModel = F0FModel::getTmpInstance('Variants', 'J2StoreModel');
			$variantModel->clearState()->setState('product_type', $record->product_type);
			//Its a simple product. So we will have only one variant record
			try {
				$variants = $variantModel->product_id($record->j2store_product_id)->getList();
				$record->variants = $variants[0];
			}catch(Exception $e) {
				echo $e->getMessage();
				$record->variants = F0FTable::getInstance('Variants', 'J2StoreTable');
			}

			try {

				//lets load product options as well
				$record->product_options = F0FModel::getTmpInstance('ProductOptions', 'J2StoreModel')
					->product_id($record->j2store_product_id)
					->limit(0)
					->parent_id(null)
					->limitstart(0)
					->getList();
			}catch (Exception $e) {
				echo $e->getMessage();
			}

			$registry = new JRegistry();
			$registry->loadString($record->params, 'JSON');
			$record->params = $registry;
		}
	}

	public function onBeforeSave(&$model, &$data)
	{
		if(!isset($data['product_type']) || $data['product_type'] != 'downloadable') return;

		$utility_helper = J2Store::utilities();

		if(!isset( $data['visibility'] )){
			$data['visibility'] = 1;
		}
		
		if(isset($data['cross_sells'])) {
			$data['cross_sells'] = $utility_helper->to_csv($data['cross_sells']);
		}else{
			$data['cross_sells'] ='';
		}

		if(isset($data['up_sells'])) {
			$data['up_sells'] = $utility_helper->to_csv($data['up_sells']);
		}else{
			$data['up_sells'] ='';
		}

		if(isset($data['shippingmethods']) && !empty($data['shippingmethods'])){
			$data['shippingmethods'] = implode(',',$data['shippingmethods']);
		}

		if(isset($data['item_options']) && count($data['item_options']) > 0){
			$data['has_options'] = 1;
		}

		//bind existing params
		if($data['j2store_product_id'] ){
			$product = F0FTable::getAnInstance('Product', 'J2StoreTable')->getClone();
			$product->load($data['j2store_product_id']);
			if(isset($product->params)){
				$product->params  = json_decode($product->params);
				if(!isset($data['params']) || empty($data['params'])) {
					$data['params'] = new JRegistry('{}');
				}else {
					$data['params'] = array_merge((array)$product->params,(array)$data['params']);
				}
				//$data['params'] = array_merge((array)$product->params,(array)$data['params']);
			}
		}

		if(isset($data['params']) && !empty($data['params'])){
			$data['params'] = json_encode($data['params']);
		}

		$this->_rawData = $data;
	}

	public function onAfterSave(&$model) {
		if($this->_rawData) {
			$table = $model->getTable();
			if($table->product_type != 'downloadable') return;
			//since post has too much of information, this could do the job
			$variant = F0FTable::getInstance('Variant', 'J2StoreTable');
			$variant->bind($this->_rawData);
			//by default it is treated as master product.
			$variant->is_master = 1;
			$variant->product_id = $table->j2store_product_id;
			$variant->store();
			//get the item options
			if(isset($this->_rawData['item_options'])) {
				foreach($this->_rawData['item_options'] as $item){
					$poption = F0FTable::getInstance('Productoption', 'J2StoreTable')->getClone();
					$item->product_id = $table->j2store_product_id;
					try {
						$poption->save($item);
					}catch (Exception $e) {
						throw new Exception($e->getMessage());
					}
				}
			}
			if(isset($this->_rawData['quantity'] )) {
				$inventory = $this->_rawData['quantity'];
				$productQuantity = F0FTable::getInstance('Productquantity', 'J2StoreTable');
				$productQuantity->load(array('variant_id'=>$variant->j2store_variant_id));
				$productQuantity->variant_id = $variant->j2store_variant_id;
				try {
					$productQuantity->save($inventory);
				}catch (Exception $e) {
					throw new Exception($e->getMessage());
				}
			}


			//save product images
			$images = F0FTable::getInstance('ProductImage', 'J2StoreTable');
			if(isset($this->_rawData['additional_images']) && !empty($this->_rawData['additional_images'] )){
				if(is_object($this->_rawData['additional_images'])){
					$this->_rawData['additional_images'] = json_encode(JArrayHelper::fromObject($this->_rawData['additional_images']));
				}else{
					$this->_rawData['additional_images'] = json_encode($this->_rawData['additional_images']);
				}
			}
			$this->_rawData['product_id'] = $table->j2store_product_id;

			//just make sure that we do not have a double entry there
			$images->load(array('product_id'=>$table->j2store_product_id));
			$images->save($this->_rawData);

			//save product filters
			F0FTable::getAnInstance('ProductFilter', 'J2StoreTable' )->addFilterToProduct ( $this->_rawData ['productfilter_ids'], $table->j2store_product_id );

		}

	}

	public function onBeforeDelete(&$model) {
		$id = $model->getId();
		if(!$id) return;
		$product = F0FTable::getAnInstance('Product', 'J2StoreTable')->getClone();
		if($product->load($id)) {
			if($product->product_type != 'downloadable') return;
			$variantModel = F0FModel::getTmpInstance('Variants', 'J2StoreModel');

			//get variants
			$variants = $variantModel->limit(0)->limitstart(0)->product_id($id)->getItemList();
			foreach($variants as $variant) {
				$variantModel->setIds(array($variant->j2store_variant_id))->delete();
			}
		}
	}

	public function onAfterGetProduct(&$model, &$product) {
		//sanity check
		if(!in_array($product->product_type, array('downloadable'))) return;
		$j2config = J2Store::config ();
		$product_helper = J2Store::product ();
		// links
		$product_helper->getAddtocartAction ( $product );
		$product_helper->getCheckoutLink ( $product );
		$product_helper->getProductLink( $product );

		$variantModel = F0FModel::getTmpInstance ( 'Variants', 'J2StoreModel' );
		$variantModel->clearState ()->setState ( 'product_type', $product->product_type );
		// Its a simple product. So we will have only one variant record
		try {
			$variants = $variantModel->product_id ( $product->j2store_product_id )->getList ();
			$product->variants = $variants [0];
		} catch ( Exception $e ) {
			$model->setError ( $e->getMessage () );
			$product->variants = F0FTable::getInstance ( 'Variants', 'J2StoreTable' );
		}

		$registry = new JRegistry ();
		$registry->loadString ( $product->params, 'JSON' );
		$product->params = $registry;

		// process variant
		$product->variant = $product->variants;

		// get quantity restrictions
		$product_helper->getQuantityRestriction ( $product->variant );

		// now process the quantity

		if ($product->variant->quantity_restriction && $product->variant->min_sale_qty > 0) {
			$product->quantity = $product->variant->min_sale_qty;
		} else {
			$product->quantity = 1;
		}

		// check stock status
		if ($product_helper->check_stock_status ( $product->variant, $product->quantity )) {
			// reset the availability
			$product->variant->availability = 1;
		} else {
			$product->variant->availability = 0;
		}

		// process pricing. returns an object
		$product->pricing = $product_helper->getPrice ( $product->variant, $product->quantity );

		$product->options = array ();
		if ($product->has_options) {

			// load product options

			try {

				// lets load product options as well
				$product->product_options = F0FModel::getTmpInstance ( 'ProductOptions', 'J2StoreModel' )->product_id ( $product->j2store_product_id )->limit ( 0 )->parent_id ( null )->limitstart ( 0 )->getList ();
			} catch ( Exception $e ) {
				$model->setError ( $e->getMessage () );
			}

			try {
				$product->options = $product_helper->getProductOptions ( $product );
				$default_selected_options = $product_helper->getDefaultProductOptions ( $product->options );
				// now get the price
				$product_option_data = $product_helper->getOptionPrice ( $default_selected_options, $product->j2store_product_id );
				$product->pricing->base_price = $product->pricing->base_price + $product_option_data ['option_price'];
				$product->pricing->price = $product->pricing->price + $product_option_data ['option_price'];
			} catch ( Exception $e ) {
				// do nothing
			}
		}
	}

	public function onUpdateProduct(&$model, &$product) {
		if($product->product_type != 'downloadable') return;
		$app = JFactory::getApplication ();
		$params = J2Store::config ();
		$product_helper = J2Store::product ();

		$product_id = $app->input->getInt ( 'product_id', 0 );

		if (! $product_id)
			return false;

		// get variant
		$variants = F0FModel::getTmpInstance ( 'Variants', 'J2StoreModel' )->product_id ( $product->j2store_product_id )->is_master ( 1 )->getList ();
		$product->variants = $variants [0];

		// process variant
		$product->variant = $product->variants;

		// get quantity restrictions
		$product_helper->getQuantityRestriction ( $product->variant );

		// now process the quantity
		$product->quantity = $app->input->getFloat ( 'product_qty', 1 );

		if ($product->variant->quantity_restriction && $product->variant->min_sale_qty > 0) {
			$product->quantity = $product->variant->min_sale_qty;
		}

		// process pricing. returns an object
		$pricing = $product_helper->getPrice ( $product->variant, $product->quantity );

		$selected_product_options = $app->input->get ( 'product_option', array (), 'ARRAY' );

		// get the selected option price
		if (count ( $selected_product_options )) {
			$product_option_data = $product_helper->getOptionPrice ($selected_product_options, $product->j2store_product_id );

			$base_price = $pricing->base_price + $product_option_data ['option_price'];
			$price = $pricing->price + $product_option_data ['option_price'];
		} else {
			$base_price = $pricing->base_price;
			$price = $pricing->price;
		}

		$return = array ();
		$return ['pricing'] = array ();
		$return ['pricing'] ['base_price'] = $product_helper->displayPrice ( $base_price, $product, $params );
		$return ['pricing'] ['price'] = $product_helper->displayPrice ( $price, $product, $params );
		$return ['pricing'] ['orginal'] = array();
		$return ['pricing'] ['orginal']['base_price'] = $base_price;
		$return ['pricing'] ['orginal']['price'] = $price;
		return $return;
	}

}