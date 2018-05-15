<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;
?>


	<?php echo $this->loadTemplate('sku'); ?>

	<?php echo $this->loadTemplate('price'); ?>

	<?php if(J2Store::product()->managing_stock($this->product->variant)): ?>
		<?php echo $this->loadTemplate('stock'); ?>
	<?php endif; ?>
<?php if($this->params->get('catalog_mode', 0) == 0): ?>
	<form action="<?php echo $this->product->cart_form_action; ?>"
		method="post" class="j2store-addtocart-form"
		id="j2store-addtocart-form-<?php echo $this->product->j2store_product_id; ?>"
		name="j2store-addtocart-form-<?php echo $this->product->j2store_product_id; ?>"
		data-product_id="<?php echo $this->product->j2store_product_id; ?>"
		data-product_type="<?php echo $this->product->product_type; ?>"
		enctype="multipart/form-data">

		<?php echo $this->loadTemplate('cart'); ?>
		<div class="j2store-notifications"></div>
	</form>
<?php endif;?>
