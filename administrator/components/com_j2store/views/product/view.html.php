<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
require_once JPATH_ADMINISTRATOR.'/components/com_j2store/helpers/j2html.php';
class J2StoreViewProduct extends F0FViewHtml
{
	public function preRender() {
		$view = $this->input->getCmd('view', 'cpanel');
		$task = $this->getModel()->getState('task', 'browse');

		$renderer = $this->getRenderer();
		$renderer->preRender($view, $task, $this->input, $this->config);

	}

	protected function onEdit($tpl = null) {
		return $this->onAdd($tpl);
	}


	protected function onAdd($tpl = null) {
		$app=JFactory::getApplication();
		JRequest::setVar('hidemainmenu', true);
		$model = $this->getModel();
		$this->item = $model->runMyBehaviorFlag(true)->getItem();
		$this->currency = J2Store::currency();
		$this->form_prefix = $this->input->getString('form_prefix', '' );
		$this->product_source_view  = $this->input->getString('product_source_view', 'article' );
		$this->product_types = JHtml::_('select.genericlist', $model->getProductTypes(), $this->form_prefix.'[product_type]', array(), 'value', 'text', $this->item->product_type);

		if($this->item->j2store_product_id) {

			//manufacturers
			$this->manufacturers = J2Html::select()->clearState()
						->type('genericlist')
						->name($this->form_prefix.'[manufacturer_id]')
						->value($this->item->manufacturer_id)
						->setPlaceHolders(
								array(''=>JText::_('J2STORE_SELECT_OPTION'))
						)
						->hasOne('Manufacturers')
						->setRelations( array(
										'fields' => array (
												'key' => 'j2store_manufacturer_id',
												'name' => array('company')
										)
									)
						)->getHtml();


			//vendor
			$this->vendors = J2Html::select()->clearState()
												->type('genericlist')
												->name($this->form_prefix.'[vendor_id]')
												->value($this->item->vendor_id)
												->setPlaceHolders(array(''=>JText::_('J2STORE_SELECT_OPTION')))
												->hasOne('Vendors')
												->setRelations(
																array (
																	'fields' => array
																		 		(
																					'key'=>'j2store_vendor_id',
																					'name'=>array('first_name','last_name')
																				)
																		)
													)->getHtml();

			//tax profiles
			$this->taxprofiles = J2Html::select()->clearState()
														->type('genericlist')
														->name($this->form_prefix.'[taxprofile_id]')
														->value($this->item->taxprofile_id)
														->setPlaceHolders(array(''=>JText::_('J2STORE_NOT_TAXABLE')))
														->hasOne('Taxprofiles')
														->setRelations(
																array (
																		'fields' => array (
																				'key'=>'j2store_taxprofile_id',
																				'name'=>'taxprofile_name'
																		)
																)
														)->getHtml();

		}
		if($this->item->j2store_product_id > 0) {
			$this->product_filters = F0FTable::getAnInstance('ProductFilter', 'J2StoreTable')->getFiltersByProduct($this->item->j2store_product_id);
		}else {
			$this->product_filters = array();
		}	
		return true;
	}
}
