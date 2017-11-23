<?php
/* ------------------------------------------------------------------------
  # com_j2store - J2Store
  # ------------------------------------------------------------------------
  # author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
  # copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://j2store.org
  # Technical Support:  Forum - http://j2store.org/forum/index.html
  ------------------------------------------------------------------------- */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<?php if ($this->params->get('show_tax_calculator', 1) && isset($this->shipping_methods) && count($this->shipping_methods)): ?>
	<form action="<?php echo JRoute::_('index.php'); ?>"
		  name="j2store-cart-shipping-form"
		  id="j2store-cart-shipping-form"
		  enctype="multipart/form-data"
		  >
		<div id="j2store-cart-shipping" class="j2store-cart-shipping">
			<h3><?php echo JText::_('J2STORE_CHECKOUT_SELECT_A_SHIPPING_METHOD'); ?></h3>
			<?php foreach ($this->shipping_methods as $method): ?>
				<?php
				$checked = '';
				if (isset($this->shipping_values['shipping_name']) && $this->shipping_values['shipping_name'] == $method['name']) {
					$checked = 'checked';
				}
				?>
				<input type="radio" id="shipping_<?php echo $method['element']; ?>_<?php echo str_replace(' ', '', $method['name']); ?>" rel="<?php echo addslashes($method['name']) ?>" name="shipping_method" <?php echo $checked; ?> onClick="j2storeUpdateShipping('<?php echo addslashes($method['name']); ?>', '<?php echo $method['price']; ?>',<?php echo $method['tax']; ?>,<?php echo $method['extra']; ?>, '<?php echo $method['code']; ?>', true);" />
				<label for="shipping_<?php echo $method['element']; ?>_<?php echo str_replace(' ', '', $method['name']); ?>" onClick="j2storeUpdateShipping('<?php echo addslashes($method['name']); ?>', '<?php echo $method['price']; ?>',<?php echo $method['tax']; ?>,<?php echo $method['extra']; ?>, '<?php echo $method['code']; ?>', true);">
					<?php echo stripslashes(JText::_($method['name'])); ?> ( <?php echo $this->currency->format($method['total']); ?> )
				</label>

			<?php endforeach; ?>

		</div>

		<?php $setval = false; ?>
		<input type="hidden" name="shipping_price" id="shipping_price" value="<?php echo $setval ? $this->shipping_methods['0']['price'] : ""; ?>" />
		<input type="hidden" name="shipping_tax" id="shipping_tax" value="<?php echo $setval ? $this->shipping_methods['0']['tax'] : ""; ?>" />
		<input type="hidden" name="shipping_name" id="shipping_name" value="<?php echo $setval ? $this->shipping_methods['0']['name'] : ""; ?>" />
		<input type="hidden" name="shipping_code" id="shipping_code" value="<?php echo $setval ? $this->shipping_methods['0']['code'] : ""; ?>" />
		<input type="hidden" name="shipping_extra" id="shipping_extra" value="<?php echo $setval ? $this->shipping_methods['0']['extra'] : ""; ?>" />
	</form>

<?php endif; ?>