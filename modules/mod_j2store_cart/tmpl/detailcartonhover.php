<?php
/*------------------------------------------------------------------------
# mod_j2store_cart - J2 Store Cart
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/helpers/j2store.php');
J2Store::utilities()->nocache();
$ajax = $app->getUserState('mod_j2store_mini_cart.isAjax');
$hide = false;
if($params->get('check_empty',0) && $list['product_count'] < 1) {
$hide = true;
}


?>

	<?php if(!$ajax): ?>
		<div class="j2store_cart_module_<?php echo $module->id; ?>">
	<?php endif; ?>
	<?php if(!$hide): ?>
	
			<div class="j2store-minicart-button">
				<div class="j2store-cart-info">
					<div class="j2store-cart-info-link"   data-hover="dropdown" data-toggle="dropdown">
						<?php if($list['product_count'] > 0): ?>
								<span>
									<?php echo JText::sprintf('J2STORE_CART_TOTAL', $list['product_count'], $currency->format($list['total'])); ?>
								</span>
								<a class="link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=carts');?>">
									<?php echo JText::_('J2STORE_VIEW_CART');?>
								</a>
							<?php else:?>
								<?php echo JText::_('J2STORE_NO_ITEMS_IN_CART'); ?>
							<?php endif;?>
					</div>
				</div>
				<div class="j2store-cart-item-box" id="j2store_cart_item_<?php echo $module->id; ?>"  style="display:none;">
					<div class="j2store-cart-header-block">
						<div class="top-subtotal">
							<?php if($list['product_count'] > 0): ?>
								<span>
									<?php echo JText::sprintf('J2STORE_CART_TOTAL', $list['product_count'], $currency->format($list['total'])); ?>
								</span>
							<?php else:?>
								<?php echo JText::_('J2STORE_NO_ITEMS_IN_CART'); ?>
							<?php endif;?>
						</div>
						<div class="pull-right">
							<a href="<?php echo JRoute::_('index.php?option=com_j2store&view=carts');?>">								
								<?php echo JText::_('J2STORE_VIEW_CART');?>								
							</a>
						</div>
					</div>
					<?php if($list['product_count'] > 0): ?>
					<ul class="j2store-cart-list">
								<?php foreach($advanced_list as $item):
										$registry = new JRegistry;
										$registry->loadString($item->orderitem_params);
										$item->params = $registry;
										$thumb_image = $item->params->get('thumb_image', '');
										$product = J2Store::product()->setId($item->product_id)->getProduct();
									?>
									<li class="cartitems">
										<div class="item-info">

											<?php if($params->get('show_thumbimage') && !empty($thumb_image)):?>
													<span class="cart-thumb-image">
														<img  alt="<?php echo $item->orderitem_name; ?>" src="<?php echo JUri::root(true).'/'.$thumb_image; ?>" />
													</span>
											<?php endif;?>

											<div class="item-product-details">
												<?php if($params->get('show_cart_remove')):?>
													<div class="access">
														<a class="cart-remove text-error" href="<?php echo JRoute::_('index.php?option=com_j2store&view=carts&task=remove&cartitem_id='.$item->cartitem_id); ?>" > <i class="fa fa-remove"></i></a>
													</div>
												<?php endif;?>
											</div>
											<?php if($params->get('show_product_qty')):?>
												<span class="cart-item-qty"> <?php echo $item->orderitem_quantity; ?> </span> x
											<?php endif;?>
											<?php echo $currency->format($order->get_formatted_lineitem_price($item, $params->get('checkout_price_display_options', 1))); ?>
											<p class="j2store-product-name"> 
												<strong><?php echo $item->orderitem_name;?></strong>
											</p>
											<br />
											<?php if(isset($item->orderitemattributes) && $item->orderitemattributes): ?>
												<span class="cart-item-options">
												<?php foreach ($item->orderitemattributes as $attribute): ?>
													<small>
													- <?php echo JText::_($attribute->orderitemattribute_name); ?> : <?php echo $attribute->orderitemattribute_value; ?>
													</small>
													<br />
												<?php endforeach;?>
												</span>
											<?php endif; ?>
										</div>
									</li>
								<?php endforeach;?>
							</ul>
						
						<?php if( $params->get('enable_checkout') ||  $params->get('enable_view_cart') ):?>
							<div class="j2store-cart-nav">
								<?php if($params->get('enable_checkout')):?>
									<a class="btn btn-success btn-large"  href="<?php echo $checkout_url;?>">
										<?php echo JText::_('J2STORE_CHECKOUT'); ?>
									</a>
								<?php endif;?>

								<?php if($params->get('enable_view_cart')):?>
									<a class="btn btn-default btn-large" href="<?php echo JRoute::_('index.php?option=com_j2store&view=carts');?>">
										<?php echo JText::_('J2STORE_VIEW_CART');?>
									</a>
								<?php endif;?>
							</div>
						<?php endif;?>
					<?php endif; ?>
					<div class="pull-right">
						<button type="button" class="btn btn-default" onclick="jQuery('#j2store_cart_item_<?php echo $module->id; ?>').hide('fast');" ><?php echo JText::_ ( 'J2STORE_CLOSE' )?></button>
					</div>
				</div>
		</div>



<?php endif; ?>
<?php if(!$ajax):?>
	</div>
<?php else: ?>
		<?php $app->setUserState('mod_j2store_mini_cart.isAjax', 0); ?>
<?php endif; ?>

<script type="text/javascript">

	jQuery(document).ready(function(){

		jQuery('.j2store-minicart-button').hover(

			function() {
				jQuery('#j2store_cart_item_<?php echo $module->id; ?>').stop(true,true).slideDown('fast');

			},

			function() {
				jQuery('#j2store_cart_item_<?php echo $module->id; ?>').hide('fast');
			}
		);
	});
</script>