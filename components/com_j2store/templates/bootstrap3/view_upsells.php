<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 *
 * Bootstrap 2 layout of product detail
 */
// No direct access
defined('_JEXEC') or die;
$columns = $this->params->get('item_related_product_columns', 3);
$total = count($this->up_sells); $counter = 0;
$upsell_image_width = $this->params->get('item_product_upsell_image_width', '100');
?>

<div class="row product-upsells-container">
	<div class="col-sm-12">
		<h3><?php echo JText::_('J2STORE_RELATED_PRODUCTS_UPSELLS'); ?></h3>
				<?php foreach($this->up_sells as $upsell_product):?>
					<?php
						$upsell_product->product_link = JRoute::_('index.php?option=com_j2store&view=products&task=view&id='.$upsell_product->j2store_product_id);
						if(!empty($upsell_product->addtocart_text)) {
							$cart_text = JText::_($upsell_product->addtocart_text);
						} else {
							$cart_text = JText::_('J2STORE_ADD_TO_CART');
						}
					
					?>
					
					<?php $rowcount = ((int) $counter % (int) $columns) + 1; ?>
					<?php if ($rowcount == 1) : ?>
						<?php $row = $counter / $columns; ?>
					
					<div class="upsell-product-row <?php echo 'row-'.$row; ?> row">
					<?php endif;?>
					<div class="col-sm-<?php echo round((12 / $columns));?> upsell-product product-<?php echo $upsell_product->j2store_product_id;?> <?php echo $upsell_product->params->get('product_css_class','');?>">
							<span class="upsell-product-image">
							<?php
								$thumb_image = '';
								if(isset($upsell_product->thumb_image) && $upsell_product->thumb_image){
		      					$thumb_image = $upsell_product->thumb_image;
		      					}
	
		      				?>
			   				<?php if(isset($thumb_image) &&  JFile::exists(JPATH::clean(JPATH_SITE.'/'.$thumb_image))):?>
			   					<img title="<?php echo $upsell_product->product_name ;?>" alt="<?php echo $upsell_product->product_name ;?>" class="j2store-product-thumb-image-<?php echo $upsell_product->j2store_product_id; ?>"  src="<?php echo JUri::root().JPath::clean($thumb_image);?>" width="<?php echo intval($upsell_image_width);?>"/>
						   	<?php endif; ?>
	
							</span>
							<h3 class="upsell-product-title">
								<a href="<?php echo $upsell_product->product_link; ?>">
									<?php echo $upsell_product->product_name; ?>
								</a>
							</h3>
	
							<?php
							$this->singleton_product = $upsell_product;
							$this->singleton_params = $this->params;
							echo $this->loadAnyTemplate('site:com_j2store/products/price');
							?>
						<?php if(J2Store::config ()->get('catalog_mode',0) == 0): ?>
							<?php if(count($upsell_product->options) || $upsell_product->product_type == 'variable'): ?>
								<a class="<?php echo $this->params->get('choosebtn_class', 'btn btn-success'); ?>"
									href="<?php echo $upsell_product->product_link; ?>">
									<?php echo JText::_('J2STORE_CART_CHOOSE_OPTIONS'); ?>
								</a>
							<?php else: ?>
							<?php
								$this->singleton_product = $upsell_product;
								$this->singleton_params = $this->params;
								$this->singleton_cartext = $cart_text;
								echo $this->loadAnyTemplate('site:com_j2store/products/cart');
							?>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php $counter++; ?>
				<?php if (($rowcount == $columns) or ($counter == $total)) : ?>
					</div>
				<?php endif; ?>
			<?php endforeach;?>
	</div>
</div>