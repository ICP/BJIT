<?php
defined('_JEXEC') or die('Restricted access');
$options = JFactory::getApplication()->input->getArray();
if (!JFactory::getApplication()->getMenu()->getActive() && !stristr($options["options"], "user") && !stristr($options["options"], "store")) {
	header('Location: ' . JURI::base(), true, 303);
	exit();
}

include 'blocks/header.php';
include 'blocks/mainbody.php';
?>
</html>