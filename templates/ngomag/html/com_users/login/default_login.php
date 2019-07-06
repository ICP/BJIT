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
<div class="page user login<?php echo $this->pageclass_sfx ?>">
	<?php
	$usersConfig = JComponentHelper::getParams('com_users');
	if ($usersConfig->get('allowUserRegistration')) {
		?>
		<div class="page-tools">
			<a class="btn btn-warning" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
				<i class="icon-user-add"></i> <?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?>
			</a>
		</div>
	<?php } ?>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-horizontal">
		<?php foreach ($this->form->getFieldset('credentials') as $field) { ?>
			<?php if (!$field->hidden) { ?>
				<div class="form-group">
					<div class="control-label col-sm-2">
						<?php echo $field->label; ?>
					</div>
					<div class="col-sm-6">
						<?php echo $field->input; ?>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<?php if (JPluginHelper::isEnabled('system', 'remember')) { ?>
			<div class="form-group">
				<div class="col-md-2">&nbsp;</div>
				<div class="col-sm-10">
					<div class="checkbox">
						<label>
							<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"/> <?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME') ?>
						</label>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="form-group">
			<div class="col-md-2">&nbsp;</div>
			<div class="col-sm-10">
				<button type="submit" class="btn btn-warning"><?php echo JText::_('JLOGIN'); ?></button>
			</div>
		</div>
		<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
	<!--div class="user-links">
		<ul class="">
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
					<?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
			</li>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
					<?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
			</li>
			<?php
			$usersConfig = JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) :
				?>
				<li>
					<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
						<?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
				</li>
			<?php endif; ?>
		</ul>
	</div-->
</div>