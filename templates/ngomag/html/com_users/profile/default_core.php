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
<table class="table table-bordered _margin-top">
	<tbody>
		<tr>
			<td class="title col-xs-2"><?php echo JText::_('COM_USERS_PROFILE_NAME_LABEL'); ?></td>
			<td><?php echo $this->data->name; ?></td>
		</tr>
		<tr>
			<td class="title col-xs-2"><?php echo JText::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?></td>
			<td><?php echo htmlspecialchars($this->data->username); ?></td>
		</tr>
		<tr>
			<td class="title col-xs-2"><?php echo JText::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?></td>
			<td><?php echo JHtml::_('date', $this->data->registerDate); ?></td>
		</tr>
		<tr>
			<td class="title col-xs-2"><?php echo JText::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?></td>
			<td><?php echo JHtml::_('date', $this->data->lastvisitDate); ?></td>
		</tr>
	</tbody>
</table>