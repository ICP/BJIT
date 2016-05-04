<?php
defined('_JEXEC') or die('Restricted access');

if (!JFactory::getApplication()->getMenu()->getActive()) {
	header('Location: ' . JURI::base(), true, 303);
	exit();
}

include 'blocks/header.php';
include 'blocks/mainbody.php';
?>
</html>