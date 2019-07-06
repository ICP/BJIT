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
<div id="j2store-cart-modules">
	<?php if ($this->params->get('show_tax_calculator', 1)): ?>
		<label>
			<input type="radio" name="next" value="shipping" id="shipping_estimate" />
			<?php echo JText::_('J2STORE_CART_TAX_SHIPPING_CALCULATOR_HEADING'); ?>
		</label>
		<div id="shipping" class="content" style="display:none;">
			<form action="<?php echo JRoute::_('index.php'); ?>" method="post" id="shipping-estimate-form" onsubmit="return false;">
				<table>
					<tr>
						<td><span class="required">*</span> <?php echo JText::_('J2STORE_SELECT_A_COUNTRY'); ?></td>
						<td><?php
							$countryList = J2Html::select()->clearState()
											->type('genericlist')
											->name('country_id')
											->idTag('estimate_country_id')
											->value($this->country_id)
											->setPlaceHolders(array('' => JText::_('J2STORE_SELECT_OPTION')))
											->hasOne('Countries')
											->setRelations(
													array(
														'fields' => array(
															'key' => 'j2store_country_id',
															'name' => 'country_name'
														)
													)
											)->getHtml();
							echo $countryList;
							?>
						</td>
					</tr>
					<tr>
						<td><span class="required">*</span> <?php echo JText::_('J2STORE_STATE_PROVINCE'); ?></td>
						<td><select id="estimate_zone_id" name="zone_id">
							</select></td>
					</tr>
					<tr>
						<td>
							<?php if ($this->params->get('postalcode_required', 1)): ?>
								<span class="required">*</span>
							<?php endif; ?>
							<?php echo JText::_('J2STORE_POSTCODE'); ?>
						</td>
						<td><input type="text" id="estimate_postcode" name="postcode" value="<?php echo $this->postcode; ?>" /></td>
					</tr>
				</table>
				<input type="button" value="<?php echo JText::_('J2STORE_CART_CALCULATE_TAX_SHIPPING'); ?>" id="button-quote" class="btn btn-primary" />

				<input type="hidden" name="option" value="com_j2store" />
				<input type="hidden" name="view" value="carts" />
				<input type="hidden" name="task" value="estimate" />
			</form>
		</div>
		<?php
		if (!isset($this->zone_id)) {
			$zone_id = '';
		} else {
			$zone_id = $this->zone_id;
		}
		?>
		<script type="text/javascript">
	        var shopCountry = {
	            defaultVal: "<?php echo JText::_('J2STORE_SELECT_OPTION'); ?>"
	            , zone_id: "<?php echo JText::_('J2STORE_SELECT_OPTION'); ?>"
	            , noneChecked: "<?php echo JText::_('J2STORE_CHECKOUT_ZONE_NONE'); ?>"
	        };
		</script>
	<?php endif; ?>
</div>