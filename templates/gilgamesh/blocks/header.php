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
$isProgram = false;
$this->setGenerator(''); // Remove Joomla generator tag
$sitename = $app->getCfg('sitename');
$lang = JLanguageHelper::getLanguages('lang_code')[JFactory::getLanguage()->getTag()]->sef;
$pageSuffix = JFactory::getApplication()->getMenu()->getActive()->params["pageclass_sfx"];

?><html class="no-js<?php echo $helper->getBaseClasses($app->getMenu()); ?>" lang="<?php echo $lang; ?>">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
		<meta name="google-site-verification" content="hNVmYmqorsHWellD3gmvYGlezOzxor8dcs2JHUDMdnY" />
		<?php if ($isFrontpage) { ?><meta property="og:image" content="<?php echo JURI::base() . 'assets/data/placeholder_gilgamesh.jpg'; ?>">
<?php } ?>
		<?php
		$JHeader = $this->getHeadData(); // Get Joomla Native Head tags
		$this->setHeadData($helper->cleanHead($JHeader)); // Removing unwanted tags from Joomla native head
		unset($this->_styleSheets);
		unset($this->_scripts); //unset($this->_style); // Unsetting default stylesheets and script even after helpers try and adding my own files
		foreach ($this->_style as $style)
			unset($style);
		// Adding stylesheets and scripts to joomla head to prevent core to face an empty array
		$this->_styleSheets[JURI::base() . 'assets/css/gilgamesh.css'] = array('mime' => "text/css");
		$this->_scripts[JURI::base() . 'assets/js/modernizr-2.6.2.min.js'] = array('mime' => "text/javascript");
		if (!$isFrontpage) {
			$this->_scripts[JURI::base() . 'assets/js/jwplayer.js'] = array('mime' => "text/javascript");
			$this->_scripts['https://www.google.com/recaptcha/api.js?hl=fa'] = array('mime' => "text/javascript");
		}
		JFactory::getDocument()->addScriptDeclaration(';var Config = { base: "' . JURI::base() . '" }');
		?><jdoc:include type="head" />
</head>