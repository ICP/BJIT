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

?>
<div class="schedules-edit front-end-edit">
    <h3>ویرایش <?php echo $this->item->date; ?></h3>
	
    <form id="form-schedules" action="<?php echo JRoute::_('index.php?option=com_schedules&task=schedules.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
		<div class="schedule-buttons">
			<button type="submit" class="validate"><span>ثبت</span></button>
			یا
			<a href="<?php echo JRoute::_('index.php?option=com_schedules&task=schedules.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
		</div>
        <ul>
			<li>
				<label for="jform_id">شناسه</label>
				<?php echo $this->form->getInput('id'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?>
			</li>
			<li>
				<label for="jform_date">تاریخ</label>
				<?php echo $this->form->getInput('date'); ?>
			</li>
			<li>
				<label for="jform_occassion">مناسبت</label>
				<?php echo $this->form->getInput('occassion'); ?>
			</li>
			<li>
				<label for="jform_programs">برنامه ها</label>
				<?php echo $this->form->getInput('programs'); ?>
				<a class="addField">Add Field</a>
				<input type="text" class="inputbox required" id="jform_farid" name="jform[farid]" />

			</li>

        </ul>
		<div>
			<button type="submit" ><span>ثبت</span></button>
			یا
			<a href="<?php echo JRoute::_('index.php?option=com_schedules'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>

			<input type="hidden" name="option" value="com_schedules" />
			<input type="hidden" name="task" value="schedules.save" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>
