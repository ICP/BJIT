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

$request = JFactory::getApplication()->input;
//$limitstart = $request->getInt('limitstart', null);
jimport('joomla.application.module.helper');
// this is where you want to load your module position
$modules = JModuleHelper::getModules('multimedia_carousels');
?>
<div class="box-wrapper multimedia">
	<?php
	foreach ($modules as $module) {
		echo JModuleHelper::renderModule($module, array('style' => 'default'));
	}
	?>
</div>