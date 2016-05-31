<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_users/helpers/route.php';
?>
<form action="<?php echo JRoute::_(htmlspecialchars(JUri::getInstance()->toString()), true, $params->get('usesecure')); ?>" method="post" class="login-form">
	<div class="form-group">
		<input type="text" name="username" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
	</div>
	<div class="form-group">
		<input type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
	</div>
	<?php if (JPluginHelper::isEnabled('system', 'remember')) { ?>
		<div class="form-group">
			<label for="remember" class="control-label checkbox"><input id="remember" type="checkbox" name="remember" class="" value="yes"/> <?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?> </label>
		</div>
	<?php } ?>
	<div class="form-group">
		<div class="controls">
			<button type="submit" tabindex="0" name="Submit" class="btn btn-default"><?php echo JText::_('JLOGIN') ?></button>
		</div>
	</div>
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
