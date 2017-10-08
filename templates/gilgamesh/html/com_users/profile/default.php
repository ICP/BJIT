<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
if (JFactory::getUser()->id == $this->data->id) {
//	header('Location: '. JRoute::_('index.php?option=com_users&view=profile&layout=edit&user_id=' . (int) $this->data->id), true, 303);
}
?>
<div class="page user profile<?php echo $this->pageclass_sfx ?>">
	<?php if (JFactory::getUser()->id == $this->data->id) { ?>
		<div class="page-tools">
			<a class="btn btn-default" href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id); ?>">
				<i class="icon-edit"></i> <?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?></a>
			<a class="btn btn-default" href="<?php echo JRoute::_('index.php?option=com_users&view=logout'); ?>">
				<i class="icon-logout"></i> <?php echo JText::_('JLOGOUT'); ?></a>
		</div>
	<?php } ?>
	<?php echo $this->loadTemplate('core'); ?>
	<?php echo $this->loadTemplate('params'); ?>
	<?php echo $this->loadTemplate('custom'); ?>
</div>
