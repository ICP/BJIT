<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Ugc
 * @author     Farid <faridv@gmail.com>
 * @copyright  2016 Farid
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Ugc helper.
 *
 * @since  1.6
 */
class UgcHelpersUgc
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_UGC_TITLE_ITEMS'),
			'index.php?option=com_ugc&view=items',
			$vName == 'items'
		);

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_ugc';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}


class UgcHelper extends UgcHelpersUgc
{

}
