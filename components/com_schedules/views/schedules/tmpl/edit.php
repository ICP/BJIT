<?php
/**
 * @version     1.0.0
 * @package     com_schedules
 * @copyright   Copyright (C) 2012,  Pooya TV. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid Roshan <faridv@gmail.com> - http://www.faridr.ir
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
//JHtml::_('behavior.tooltip');
//JHtml::_('behavior.formvalidation');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_schedules', JPATH_ADMINISTRATOR);

include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';
//var_dump(JRequest::getVar('id'));
?>
<div class="schedules-edit front-end-edit">
	<?php
	if (isset($this->item->date)) {
		list($y, $m, $d) = explode('-', $this->item->date);
		$jalaliDate = gregorian_to_jalali($y, $m, $d, '-');
	?>
	<h3>ویرایش کنداکتور روز <?php echo $jalaliDate; ?></h3>
	<?php } else { ?>
	<h3>کنداکتور جدید</h3>
	<?php } ?>
	<?php 
	if (isset($this->item->id)) {
		require_once JPATH_COMPONENT_SITE . '/views/schedules/tmpl/forms/edit.php';
	} else {	
		require_once JPATH_COMPONENT_SITE . '/views/schedules/tmpl/forms/add.php';
	}
	?>
</div>
