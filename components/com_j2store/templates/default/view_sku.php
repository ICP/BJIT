<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;
?>
<?php if($this->params->get('item_show_product_sku', 1) && !empty($this->product->variant->sku)) : ?>
	<div class="product-sku">
		<span class="sku-text"><?php echo JText::_('J2STORE_SKU')?> :</span>
		<span itemprop="sku" class="sku"> <?php echo $this->product->variant->sku; ?> </span>
	</div>
<?php endif; ?>