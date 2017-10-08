<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined('_JEXEC') or die;
JHTML::_('behavior.modal');
$version = 'old';
$document = JFactory::getDocument();
if(version_compare(JVERSION,'3.6.1','ge')){
	$version = 'new';
	$user_modal_url = "index.php?option=com_users&amp;view=users&amp;layout=modal&amp;tmpl=component&amp;required=0&amp;field={field-user-id}&amp;ismoo=0&amp;excluded=WyIiXQ==";
}elseif(version_compare(JVERSION,'3.5.0','ge')){
	$user_modal_url = "index.php?option=com_users&amp;view=users&amp;layout=modal&amp;tmpl=component&amp;required=0&amp;field={field-user-id}&amp;excluded=WyIiXQ==";
	$version = 'new';
}
if($version == 'new'){
	$document->addScript(JUri::root(true).'/media/jui/js/fielduser.min.js');
}
?>
<?php
if(($this->state->since) || ($this->state->until) || ($this->state->paykey) ||  ($this->state->moneysum) || ($this->state->toinvoice) || ($this->state->coupon_code) || ($this->state->user_id)) :?>
<div class="row-fluid" id="advanced-search-controls">
<?php else:?>
<div class="row-fluid hide" id="advanced-search-controls">
<?php endif;?>
			<div class="span6">
				<table class="adminlist table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th></th>
							<th><?php echo JText::_('J2STORE_FROM');?></th>
							<th><?php echo JText::_('J2STORE_TO');?></th>
						</tr>
					</thead>
					<tr>
						<td><?php echo JText::_('J2STORE_ORDER_DATE');?></td>
						<td><?php echo J2Html::calendar('since',$this->state->since,array('class'=>'input-small j2store-order-filters'));?></td>
						<td><?php echo J2Html::calendar('until',$this->state->until,array('class'=>'input-small j2store-order-filters'));?>	</td>
					<tr/>
					<tr>
						<td><?php echo JText::_('J2STORE_INVOICE_NO');?></td>
						<td><?php echo J2Html::text('frominvoice',$this->state->frominvoice,array('class'=>'input-small j2store-order-filters'));?></td>
						<td><?php echo J2Html::text('toinvoice',$this->state->toinvoice,array('class'=>'input-small j2store-order-filters'));?></td>
					</tr>
				</table>
			</div>
			<div class="span6">
					<table class="adminlist table table-striped table-bordered table-condensed">
					<tr>
						<td>
							<?php echo JText::_( 'J2STORE_ORDER_AMOUNT' ); ?>:
							<?php echo J2Html::text('moneysum',$this->state->moneysum,array('class'=>'input j2store-order-filters'));?>
						</td>
						<td>
							<?php echo JText::_( 'J2STORE_FILTER_COUPON_CODE' ); ?>:
							<?php echo J2Html::text('coupon_code',$this->state->coupon_code,array('class'=>'input j2store-order-filters'));?>
						</td>
					</tr>
					<tr>
						<td>
						<?php echo JText::_( 'J2STORE_FILTER_USER' ); ?>:
						<div class="controls">
							<?php
									$user_name = '';
									if($this->state->user_id){
										$user_name=J2Html::getUserNameById($this->state->user_id);
									}
							?>
							<div class="input-append">
								<?php if($version == 'old'): ?>
									<input type="text"  class="input-small"  name="user_name" value="<?php echo $user_name;?>" id="jform_user_id_name" readonly="true" aria-invalid="false" />
									<input type="hidden" onchange="j2storeGetAddress()" name="user_id" value="<?php echo $this->state->user_id;?>" id="jform_user_id" class="j2store-order-filters"  readonly="true"/>
									<?php $url ='index.php?option=com_users&view=users&layout=modal&tmpl=component&field=jform_user_id';?>
									<?php echo J2StorePopup::popup($user_modal_url,'<i class="icon icon-user"></i>', array('class'=>'btn btn-primary modal_jform_created_by'));?>
								<?php elseif($version == 'new'): ?>

									<div data-button-select=".button-select" data-input-name=".field-user-input-name" data-input=".field-user-input" data-modal-height="400px" data-modal-width="100%" data-modal=".modal" data-url="<?php echo $user_modal_url;?>" class="field-user-wrapper">
										<div class="input-append">
											<input type="text" class="field-user-input-name " name="user_name" readonly="" placeholder="Select a User." value="<?php echo $user_name;?>" id="jform_created_by">
											<a title="Select User" class="btn btn-primary button-select"><span class="icon-user"></span></a>
											<div class="modal hide fade" tabindex="-1" id="userModal_jform_created_by">
												<div class="modal-header">
													<button data-dismiss="modal" class="close" type="button">×</button>
													<h3>Select User</h3>
												</div>
												<div class="modal-body">
												</div>
												<div class="modal-footer">
													<button data-dismiss="modal" class="btn">Cancel</button></div>
											</div>
										</div>
										<input type="hidden" data-onchange="" class="field-user-input " value="<?php echo $this->state->user_id;?>" name="user_id" id="jform_created_by_id">
									</div>

								<?php endif;?>

							</div>
						</div>
						<td>
						<?php echo JText::_( 'J2STORE_FILTER_PAYMENTS' ); ?>:
							<?php
									echo J2Html::select()->clearState()
									->type('genericlist')
									->name('paykey')
									->value($this->state->paykey)
									->attribs(array('onchange'=>'this.form.submit' ,'class'=>'j2store-order-filters'))
									->setPlaceHolders(array(''=>JText::_('J2STORE_SELECT_OPTION')))
									->hasOne('Payments')
									->setRelations(
											array (
													'fields' => array
													(
															'key'=>'element',
															'name'=>'element'
													)
											)
									)->getHtml();
						?>
						</td>
						</tr>
						<tr>
						<td colspan="2">
							<?php echo J2Html::button('advanced_search',JText::_('J2STORE_APPLY_FILTER'),array('class'=>'btn btn-success' ,'onclick'=>'this.form.submit();'));?>
							<?php echo J2Html::button('reset_advanced_filters',JText::_('J2STORE_FILTER_RESET'),array('class'=>'btn btn-inverse' ,'onclick'=>'resetAdvancedFilters()'));?>
						</td>
					</tr>
				</table>
			</div>

		</div>