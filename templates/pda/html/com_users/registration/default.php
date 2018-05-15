<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="page user registration<?php echo $this->pageclass_sfx ?>">
	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
		<?php foreach ($this->form->getFieldsets() as $fieldset) { ?>
			<?php $fields = $this->form->getFieldset($fieldset->name); ?>
			<?php if (count($fields)) { ?>
				<?php // Iterate through the fields in the set and display them. ?>
				<?php foreach ($fields as $field) { ?>
					<?php // If the field is hidden, just display the input. ?>
					<?php if ($field->hidden) { ?>
						<?php echo $field->input; ?>
					<?php } ?>
					<div class="form-group">
						<div class="control-label col-sm-2">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') { ?>
								<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
							<?php } ?>
						</div>
						<div class="col-sm-6">
							<?php echo $field->input; ?>
						</div>
					</div>
				<?php } ?>
			<?php } // foreach ?>
		<?php } ?>
		<div class="form-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER'); ?></button>
				<!--<a class="btn" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>-->
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="registration.register" />
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
