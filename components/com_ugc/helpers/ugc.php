<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Ugc
 * @author     Farid <faridv@gmail.com>
 * @copyright  2016 Farid
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class UgcFrontendHelper
 *
 * @since  1.6
 */
class UgcHelpersUgc
{
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_ugc/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_ugc/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'UgcModel');
		}

		return $model;
	}
}
