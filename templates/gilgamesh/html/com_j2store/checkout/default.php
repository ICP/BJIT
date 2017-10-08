<?php
/*
 * --------------------------------------------------------------------------------
  Weblogicx India  - J2Store
 * --------------------------------------------------------------------------------
 * @package		Joomla! 2.5x
 * @subpackage	J2Store
 * @author    	Weblogicx India http://www.weblogicxindia.com
 * @copyright	Copyright (c) 2010 - 2015 Weblogicx India Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link		http://weblogicxindia.com
 * --------------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$action = JRoute::_('index.php?option=com_j2store&view=checkout');
$ajax_base_url = JRoute::_('index.php');
?>
<?php echo J2Store::modules()->loadposition('j2store-checkout-top'); ?>
<div id="j2store-checkout" class="j2store checkout">
	<div id="j2store-checkout-content">
		<h2><?php echo JText::_('J2STORE_CHECKOUT'); ?></h2>
		<div id="checkout">
			<div class="checkout-heading"><?php echo JText::_('J2STORE_CHECKOUT_OPTIONS'); ?></div>
			<div class="checkout-content"></div>
		</div>
		<?php if (!$this->logged) { ?>
			<div id="billing-address">
				<div class="checkout-heading"><span><?php echo JText::_('J2STORE_CHECKOUT_ACCOUNT'); ?></span></div>
				<div class="checkout-content"></div>
			</div>
		<?php } else { ?>
			<div id="billing-address">
				<div class="checkout-heading"><span><?php
						echo JText::_('J2STORE_CHECKOUT_BILLING_ADDRESS');
						;
						?></span></div>
				<div class="checkout-content"></div>
			</div>
		<?php } ?>
		<?php if ($this->showShipping) { ?>
			<div id="shipping-address">
				<div class="checkout-heading"><?php echo JText::_('J2STORE_CHECKOUT_SHIPPING_ADDRESS'); ?></div>
				<div class="checkout-content"></div>
			</div>
		<?php } ?>
		<div id="shipping-payment-method">
			<div class="checkout-heading">
				<?php if ($this->showShipping) : ?>
					<?php echo JText::_('J2STORE_CHECKOUT_SHIPPING_PAYMENT_METHOD'); ?>
				<?php else: ?>
					<?php echo JText::_('J2STORE_CHECKOUT_PAYMENT_METHOD'); ?>
				<?php endif; ?>
			</div>
			<div class="checkout-content"></div>
		</div>
		<div id="confirm">
			<div class="checkout-heading"><?php
				echo JText::_('J2STORE_CHECKOUT_CONFIRM');
				;
				?></div>
			<div class="checkout-content"></div>
		</div>
	</div>
</div>
<?php echo J2Store::modules()->loadposition('j2store-checkout-bottom'); ?>
<script type="text/javascript">

    var query = {};
    query['option'] = 'com_j2store';
    query['view'] = 'checkout';
//force utf

    var Checkout = {
        account: '<?php echo JText::_('J2STORE_CHECKOUT_ACCOUNT'); ?>'
        , address: '<?php echo JText::_('J2STORE_CHECKOUT_BILLING_ADDRESS'); ?>'
        , base: '<?php echo $ajax_base_url; ?>'
        , modify: '<?php echo JText::_('J2STORE_CHECKOUT_MODIFY'); ?>'
        , guestAllowed: <?php echo (!$this->logged && $this->params->get('allow_guest_checkout')) && (!$this->params->get('show_login_form', 1) && !$this->params->get('allow_registration', 1)) ? 1 : 0; ?>
        , notLoggedIn: <?php echo (!$this->logged) ? 1 : 0; ?>
        , showShipping: <?php echo $this->showShipping; ?>
    };

</script>