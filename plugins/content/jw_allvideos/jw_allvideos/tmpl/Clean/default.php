<?php
/**
 * @version		4.6.1
 * @package		AllVideos (plugin)
 * @author    	JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
if ($app->isAdmin()) {
	?>
	<video width="<?php echo $output->playerWidth; ?>" controls>
		<source src="<?php echo trim(str_replace('"', '', $output->player)); ?>">
	</video>
	<?php
} else {
//	var_dump($output); die();
	echo $output->player;
}