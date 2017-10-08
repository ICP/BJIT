<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

$this->variant = $this->item->variants;

//lengths
$this->lengths = J2Html::select()->clearState()
->type('genericlist')
->name($this->form_prefix.'[length_class_id]')
->value($this->variant->length_class_id)
->setPlaceHolders(array(''=>JText::_('J2STORE_SELECT_OPTION')))
->hasOne('Lengths')
->setRelations(
		array (
				'fields' => array (
						'key'=>'j2store_length_id',
						'name'=>'length_title'
				)
		)
)->getHtml();

//weights

$this->weights = J2Html::select()->clearState()
->type('genericlist')
->name($this->form_prefix.'[weight_class_id]')
->value($this->variant->weight_class_id)
->setPlaceHolders(array(''=>JText::_('J2STORE_SELECT_OPTION')))
->hasOne('Weights')
->setRelations(
		array (
				'fields' => array (
						'key'=>'j2store_weight_id',
						'name'=>'weight_title'
				)
		)
)->getHtml();

//backorder
$this->allow_backorder = J2Html::select()->clearState()
->type('genericlist')
->name($this->form_prefix.'[allow_backorder]')
->value($this->variant->allow_backorder)
->setPlaceHolders(
		array('0' => JText::_('COM_J2STORE_DO_NOT_ALLOW_BACKORDER'),
				'1' => JText::_('COM_J2STORE_DO_ALLOW_BACKORDER'),
				'2' => JText::_('COM_J2STORE_ALLOW_BUT_NOTIFY_CUSTOMER')
		))
		->getHtml();

$this->availability =J2Html::select()->clearState()
->type('genericlist')
->name($this->form_prefix.'[availability]')
->value($this->variant->availability)
->default(1)
->setPlaceHolders(
		array('0' => JText::_('COM_J2STORE_PRODUCT_OUT_OF_STOCK') ,
				'1'=> JText::_('COM_J2STORE_PRODUCT_IN_STOCK') ,
		)
)
->getHtml();
?>

		<div class="row">
		   <div class="span12">
              <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                  <li class="active">
                  	<a href="#generalTab" data-toggle="tab"><i class="fa fa-home"></i>
                  		 <?php echo JText::_('J2STORE_PRODUCT_TAB_GENERAL'); ?>
                  	</a>
                  </li>
                  <li><a href="#pricingTab" data-toggle="tab"><i class="fa fa-dollar"></i> <?php echo JText::_('J2STORE_PRODUCT_TAB_PRICE'); ?></a></li>
                  <li><a href="#inventoryTab" data-toggle="tab"><i class="fa fa-signal"></i> <?php echo JText::_('J2STORE_PRODUCT_TAB_INVENTORY'); ?></a></li>
                  <li><a href="#imagesTab" data-toggle="tab"><i class="fa fa-file-image-o"></i> <?php echo JText::_('J2STORE_PRODUCT_TAB_IMAGES'); ?></a></li>
                  <li><a href="#shippingTab" data-toggle="tab"><i class="fa fa-truck"></i> <?php echo JText::_('J2STORE_PRODUCT_TAB_SHIPPING'); ?></a></li>
                  <li><a href="#optionsTab" data-toggle="tab"><i class="fa fa-sitemap"></i> <?php echo JText::_('J2STORE_PRODUCT_TAB_OPTIONS'); ?></a></li>
                  <li><a href="#filterTab" data-toggle="tab"><i class="fa fa-filter"></i> <?php echo JText::_('J2STORE_PRODUCT_TAB_FILTER'); ?></a></li>
                  <li><a href="#relationsTab" data-toggle="tab"><i class="fa fa-group"></i> <?php echo JText::_('J2STORE_PRODUCT_TAB_RELATIONS'); ?></a></li>
				  <li><a href="#appsTab" data-toggle="tab"><i class="fa fa-group"></i> <?php echo JText::_('J2STORE_PRODUCT_TAB_APPS'); ?></a></li>
                </ul>
				<!-- / Tab content starts -->
                <div class="tab-content">
                  <div class="tab-pane active" id="generalTab">
					<?php $this->variant = $this->item->variants; ?>
					<input type="hidden" name="<?php echo $this->form_prefix.'[j2store_variant_id]'; ?>" value="<?php echo $this->variant->j2store_variant_id; ?>" />
                	<?php echo $this->loadTemplate('general');?>
                  </div>
                  <div class="tab-pane" id="pricingTab">
						<?php echo $this->loadTemplate('pricing');?>
                  </div>
                  <div class="tab-pane" id="inventoryTab">
						<?php echo $this->loadTemplate('inventory');?>
                  </div>

                  <div class="tab-pane" id="imagesTab">
						<?php echo $this->loadTemplate('images');?>
                  </div>
                  <div class="tab-pane" id="shippingTab">
						<?php echo $this->loadTemplate('shipping');?>
                  </div>
                  <div class="tab-pane" id="optionsTab">
						<?php echo $this->loadTemplate('configoptions');?>
                  </div>
                  <div class="tab-pane" id="filterTab">
						<?php echo $this->loadTemplate('filters');?>
                  </div>
                  <div class="tab-pane" id="relationsTab">
						<?php echo $this->loadTemplate('relations');?>
                  </div>
                  <div class="tab-pane" id="appsTab">
						<?php echo $this->loadTemplate('apps');?>
                  </div>
                </div>
                <!-- / Tab content Ends -->
              </div> <!-- /tabbable -->
      		</div>
    	</div>
