<?php
/**
 * @version    2.7.x
 * @package    K2
 * @author     JoomlaWorks http://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2016 JoomlaWorks Ltd. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
?>
<div class="page user registration edit<?php echo $this->pageclass_sfx ?>">

	<form action="<?php echo JURI::root(true); ?>/index.php" enctype="multipart/form-data" method="post" name="userform" autocomplete="off" class="form-horizontal">

		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="namemsg" for="name"><?php echo JText::_('K2_NAME'); ?></label>
			</div>
			<div class="col-sm-6">
				<input type="text" disabled value="<?php echo $this->user->get('username'); ?>" class="disabled form-control" />
			</div>
		</div>
		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="namemsg" for="name"><?php echo JText::_('K2_NAME'); ?><span class="star">&#160;*</span></label>
			</div>
			<div class="col-sm-6">
				<input type="text" name="<?php echo $this->nameFieldName; ?>" id="name" size="40" value="<?php echo $this->escape($this->user->get('name')); ?>" class="inputbox required" maxlength="50" required />
			</div>
		</div>
		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="namemsg" for="email"><?php echo JText::_('K2_EMAIL'); ?><span class="star">&#160;*</span></label>
			</div>
			<div class="col-sm-6">
				<input type="text" id="email" name="<?php echo $this->emailFieldName; ?>" size="40" value="<?php echo $this->escape($this->user->get('email')); ?>" class="inputbox required validate-email" maxlength="100" required />
			</div>
		</div>
		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="namemsg" for="email2"><?php echo JText::_('K2_CONFIRM_EMAIL'); ?><span class="star">&#160;*</span></label>
			</div>
			<div class="col-sm-6">
				<input type="text" id="email2" name="jform[email2]" size="40" value="<?php echo $this->escape($this->user->get('email')); ?>" class="inputbox required validate-email" maxlength="100" required />
			</div>
		</div>
		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="namemsg" for="password"><?php echo JText::_('K2_PASSWORD'); ?><span class="star">&#160;*</span></label>
			</div>
			<div class="col-sm-6">
				<input class="inputbox required validate-password" type="password" id="password" name="<?php echo $this->passwordFieldName; ?>" size="40" value="" required />
			</div>
		</div>
		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="namemsg" for="password2"><?php echo JText::_('K2_VERIFY_PASSWORD'); ?><span class="star">&#160;*</span></label>
			</div>
			<div class="col-sm-6">
				<input class="inputbox required validate-passverify" type="password" id="password2" name="<?php echo $this->passwordVerifyFieldName; ?>" size="40" value="" required="" />
			</div>
		</div>

		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="namemsg" for="gender"><?php echo JText::_('K2_GENDER'); ?></label>
			</div>
			<div class="col-sm-6">
				<?php echo $this->lists['gender']; ?>
			</div>
		</div>
		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="imagemsg" for="image"><?php echo JText::_('K2_USER_IMAGE_AVATAR'); ?></label>
			</div>
			<div class="col-sm-6">
				<input type="file" id="image" name="image" />
				<?php if ($this->K2User->image) { ?>
					<img class="k2AdminImage" src="<?php echo JURI::root() . 'media/k2/users/' . $this->K2User->image; ?>" alt="<?php echo $this->user->name; ?>" />
					<div class="clearfix"></div>
					<input type="checkbox" name="del_image" id="del_image" />
					<label for="del_image"><?php echo JText::_('K2_CHECK_THIS_BOX_TO_DELETE_CURRENT_IMAGE_OR_JUST_UPLOAD_A_NEW_IMAGE_TO_REPLACE_THE_EXISTING_ONE'); ?></label>
				<?php } ?>
			</div>
		</div>	
		<div class="form-group">
			<div class="control-label col-sm-2">
				<label id="urlmsg" for="url"><?php echo JText::_('K2_URL'); ?></label>
			</div>
			<div class="col-sm-6">
				<input type="text" size="50" value="<?php echo $this->K2User->url; ?>" name="url" id="url" />
			</div>
		</div>
		<?php if (count(array_filter($this->K2Plugins))) { ?>
			<!-- K2 Plugin attached fields -->
			<?php foreach ($this->K2Plugins as $K2Plugin) { ?>
				<?php if (!is_null($K2Plugin)) { ?>
					<div class="form-group"><div class="col-sm-2"></div><div class="col-sm-6"><?php echo $K2Plugin->fields; ?></div></div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		<div class="hide"><?php echo $this->editor; ?></div>

		<!-- Joomla! 1.6+ JForm implementation -->
		<?php if (isset($this->form)): ?>
			<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one. ?>
				<?php if ($fieldset->name != 'core'): ?>
					<?php $fields = $this->form->getFieldset($fieldset->name); ?>
					<?php if (count($fields)): ?>
						<?php foreach ($fields as $field):// Iterate through the fields in the set and display them. ?>
							<?php if ($field->hidden):// If the field is hidden, just display the input. ?>
								<?php echo $field->input; ?>
							<?php else: ?>
								<div class="form-group">
									<div class="control-label col-sm-2">
										<?php echo $field->label; ?>
										<?php if (!$field->required && $field->type != 'Spacer'): ?>
											<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
										<?php endif; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $field->input; ?>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<div class="form-group">
			<div class="control-label col-sm-2"></div>
			<div class="col-sm-6">
				<button class="btn btn-default validate" type="submit" onclick="submitbutton(this.form);
                        return false;">
						<?php echo JText::_('K2_SAVE'); ?>
				</button>
			</div>
		</div>

		<input type="hidden" name="<?php echo $this->usernameFieldName; ?>" value="<?php echo $this->user->get('username'); ?>" />
		<input type="hidden" name="<?php echo $this->idFieldName; ?>" value="<?php echo $this->user->get('id'); ?>" />
		<input type="hidden" name="gid" value="<?php echo $this->user->get('gid'); ?>" />
		<input type="hidden" name="option" value="<?php echo $this->optionValue; ?>" />
		<input type="hidden" name="task" value="<?php echo $this->taskValue; ?>" />
		<input type="hidden" name="K2UserForm" value="1" />
		<?php echo JHTML::_('form.token'); ?>
	</form>
</div>