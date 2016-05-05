<?php
if (!class_exists('templateHelper'))
	require_once (dirname(dirname(__FILE__)) . '/helper.php');
$helper = new TemplateHelper($this); // Creatig an instance of helper class
$device = $helper->device_array; // Get User Device platform and settings
echo $helper->doctype . "\n"; // Doctype based on users platform (only differs in mobile devices)

$app = JFactory::getApplication();
$url = JURI::base(); // Root URL
$turl = rtrim($url, "/"); // Root URL without tailing slash

$isFrontpage = $helper->isFrontpage($app->getMenu());

$this->setGenerator(''); // Remove Joomla generator tag
$sitename = $app->getCfg('sitename');

$pageSuffix = JFactory::getApplication()->getMenu()->getActive()->params["pageclass_sfx"];
$theme = (isset($pageSuffix) && $pageSuffix !== null) ? $pageSuffix : 'dark';
?><html class="no-js<?php echo $helper->getBaseClasses($app->getMenu()); ?>">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width">
		<meta name="google-site-verification" content="hNVmYmqorsHWellD3gmvYGlezOzxor8dcs2JHUDMdnY" />
		<?php
		$JHeader = $this->getHeadData(); // Get Joomla Native Head tags
		$this->setHeadData($helper->cleanHead($JHeader)); // Removing unwanted tags from Joomla native head
		unset($this->_styleSheets);
		unset($this->_scripts); //unset($this->_style); // Unsetting default stylesheets and script even after helpers try and adding my own files
		foreach ($this->_style as $style)
			unset($style);
		// Adding stylesheets and scripts to joomla head to prevent core to face an empty array
		$this->_styleSheets[JURI::base() . 'assets/css/style.css'] = array('mime' => "text/css", 'media' => 'all', 'attribs' => array(), 'defer' => '', 'async' => '');
		$this->_scripts[JURI::base() . 'assets/js/modernizr-2.6.2.min.js'] = array('mime' => "text/javascript", 'media' => 'all', 'attribs' => array(), 'defer' => '', 'async' => '');
//		$this->_scripts[JURI::base() . 'assets/js/jquery-1.11.1.min.js'] = array('mime' => "text/javascript", 'media' => 'all', 'attribs' => array(), 'defer' => '', 'async' => '');
		$this->_scripts[JURI::base() . 'assets/js/jwplayer.js'] = array('mime' => "text/javascript", 'media' => 'all', 'attribs' => array(), 'defer' => '', 'async' => '');
		JFactory::getDocument()->addScriptDeclaration('var base = "' . JURI::base() . '";');
		?><jdoc:include type="head" />
</head>