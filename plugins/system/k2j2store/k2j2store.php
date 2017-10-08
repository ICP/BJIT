<?php
/**
 * @package J2Store
 * @author Gokila Priya
 * @copyright Copyright (c)2014-17 J2Store.org
 * @license GNU GPL v3 or later
 */
defined( '_JEXEC' ) or die();
class plgSystemk2j2store extends JPlugin
{

	function onBeforeCompileHead(){
		$app = JFactory::getApplication();
		$view = $app->input->get('view','');
		$option = $app->input->get('option','');
		if($option == 'com_k2'  && JPluginHelper::isEnabled ( 'k2' , 'j2store' ) ){
			$doc = JFactory::getDocument();
			$headData = $doc->getHeadData();
			$styles = $headData['styleSheets'];
			unset($styles[JUri::root(true) . '/media/j2store/css/jquery-ui-custom.css']);
			$headData['styleSheets'] = $styles;
			$doc->setHeadData( $headData );
		}

	}

	function onJ2StoreAfterGetProduct($product) {

		if(isset($product->product_source) && $product->product_source == 'com_k2' ) {
			static $sets;
			if(!is_array($sets)) {
				$sets = array();
			}
			$content = $this->getK2Item($product->product_source_id);
			if(isset($content->id)) {
				//assign
				$product->source = $content;
				$product->product_name = $content->title;
				$product->product_edit_url = JRoute::_('index.php?option=com_k2&view=item&task=edit&cid='.$product->product_source_id);
				require_once (JPATH_SITE.'/components/com_k2/helpers/route.php');
				require_once (JPATH_SITE.'/components/com_k2/helpers/utilities.php');
				$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($content->id.':'.urlencode($content->alias), $content->catid.':'.urlencode($content->categoryalias))));
				$product->product_view_url = JRoute::_($link);
				if($content->published == 1 ) {
					$product->exists = 1;
				} else {
					$product->exists = 0;
				}
				$sets[$product->product_source][$product->product_source_id] = $content;
			} else {
				$product->exists = 0;
			}

		}

	}

	function getK2Item($content_id) {
		static $sets;
		if (! is_array ( $sets )) {
			$sets = array ();
		}
		if (! isset ( $sets [$content_id] )) {
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true )->select ( 'i.*' )->from ( '#__k2_items as i' )->where ( 'i.id=' . $db->q ($content_id) );
			$query->select('c.id AS categoryid, c.alias AS categoryalias');
			$query->leftJoin('#__k2_categories c ON c.id = i.catid');
			$db->setQuery ( $query );
			$sets [$content_id] = $db->loadObject ();
		}
		return $sets [$content_id];
	}

	/**
	 * Method to delete K2Item when removed from k2 Items view
	 * @param string $context
	 * @param object $row
	 * @throws Exception
	 */
	public function	onFinderAfterDelete($context, $row){
		if(strpos($context, 'com_k2.item') !== false  && !empty($row->id)){
			if (!defined('F0F_INCLUDED'))
			{
				include_once JPATH_LIBRARIES . '/f0f/include.php';
			}
			$productModel = F0FModel::getTmpInstance('Products', 'J2StoreModel');

			$itemlist  = $this->getProductsBySource('com_k2',$row->id);
			foreach($itemlist as $item) {
				try {
					$productModel->setId($item->j2store_product_id)->delete();
				}catch (Exception $e) {
					throw new Exception($e->getMessage());
				}
			}
		}
		return true;
	}


	/**
	 * Method to get List of items based on the product_source and product source id
	 * @param string $source
	 * @param int $source_id
	 * @return  array object
	 */
	public function getProductsBySource($source, $source_id) {
		if (empty ( $source ) || empty ( $source_id ))
			return array ();

		static $source_sets;
		if (! is_array ( $source_sets )) {
			$source_sets = array ();
		}

		if (! isset ( $source_sets [$source] [$source_id] )) {
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true )->select ( '*' )->from ( '#__j2store_products' )->where ( $db->qn ( 'product_source' ) . ' = ' . $db->q ( $source ) )->where ( $db->qn ( 'product_source_id' ) . ' = ' . $db->q ( $source_id ) );
			$db->setQuery ( $query );
			$source_sets [$source] [$source_id] = $db->loadObjectList ();
		}
		return $source_sets [$source] [$source_id];
	}
}