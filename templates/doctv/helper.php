<?php

if (!class_exists('Browser')) {
    require_once ('libs/browser.php');
}
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!class_exists('K2ModelItem')) {
    if (file_exists(JPATH_BASE . DS . 'components' . DS . 'com_k2' . DS . 'models' . DS . 'item.php')) {
        require_once (JPATH_BASE . DS . 'components' . DS . 'com_k2' . DS . 'models' . DS . 'item.php');
    }
}

class TemplateHelper {

    public $status = array();
    public $tpl = null;
    public $acceptedPlatforms = array("desktop", "mobile", "iphone", "ipad");
    public $desktopBlocks = array("login", "panel", "header", "drawer", "main", "footer");
    public $iphoneBlocks = array("login", "panel", "header", "main", "footer");
    public $mobileBlocks = array("login", "panel", "header", "main", "footer");
    public $device_array = array();
    public $device;
    public $platform; //strtolower($this->device);
    public $Browser; //Browser class instance
    public $browser;
    public $version;
    public $width;
    public $gridCount;
    public $doctype;
    public $uiRequest;
    public $cookie;
	public $frontpage;

    /*
     * Constructor method to catch data and store in templateHelper attributes.
     */
    public function templateHelper(&$templateObject) {
        $this->Browser = new Browser;
        $this->browser = $this->Browser->getBrowser();
        $this->version = $this->Browser->getVersion();
        $this->tpl = &$templateObject;
        $this->device_array = $this->checkPlatform(true);
        $this->device = $this->checkPlatform();

        $this->uiRequest = JRequest::getVar('ui', null, 'GET');
        $this->cookie = $this->checkCookie('ui');
        if ($this->cookie) {
            $this->device = $this->cookie;
            $this->device_array['platform'] = $this->cookie;
        }
        if ((in_array(strtolower($this->uiRequest), $this->acceptedPlatforms)) && (strtolower($this->uiRequest) != $this->device)) {
            $this->device = $this->uiRequest;
            $this->device_array['platform'] = $this->uiRequest;
            $this->setMyCookie('ui', strtolower($this->device), 604800);
        }
        $this->doctype = $this->createDoctype($this->device);
        $this->platform = strtolower($this->device);
        $this->width = $this->setTemplateWidth();
        $this->gridCount = $this->setTemplteGridCount();
		$this->frontpage = $this->isFrontpage(JFactory::getApplication()->getMenu());
    }

    public function getBaseClasses($currentMenu) {
        $browser = $this->browser;
        $version = $this->version;
        
        if (trim($browser) == 'Internet Explorer') { // HTML tag classes based on users browser (for Modernizr.js)
            if (intval($version) < 7)
                $baseClasses = ' lt-ie9 lt-ie8 lt-ie7';
            if (intval($version) == 7)
                $baseClasses = ' lt-ie9 lt-ie8';
            if (intval($version) == 8)
                $baseClasses = ' lt-ie9';
            if (intval($version) > 8)
                $baseClasses = '';
        } else
            $baseClasses = ''; // Other standard browsers
		$frontpage = ($this->checkDefaultMenu($currentMenu)) ? ' frontpage' : '';
        return $baseClasses . $frontpage;
    }
	
	public function isFrontpage($currentMenu) {
		return ($this->checkDefaultMenu($currentMenu)) ? true : false;
	}
	
	public function countMessages($messagesQueue) {
		return (is_array($messagesQueue) && count($messagesQueue) > 1) ? true : false;
	}

    /*
     * Public method to load template blocks.
     * 
     * @param   $blocks_array   Array   Name of blocks to load in an array. Block names are the same as their PHP files.
     * @param   $ignore		 Array   Name of blocks that doesn't need to have a wrapper div tag.
     */
    public function loadBlocks($blocks_array) {

        reset($blocks_array);
        foreach ($blocks_array as $block) {
            echo '<section id="' . $block . '">';
            if ($this->platform != 'mobile') {
                require_once ('blocks/' . $this->platform . '/' . $block . '.php');
            } else {
                require_once ('blocks/' . 'iphone' . '/' . $block . '.php');
            }
            echo '</section>';
        }
    }

    /*
     * Public method to load body data based on user device platform.
     */
    public function loadBody() {

        switch ($this->platform) {
            case ('mobile'):
                $this->loadBlocks($this->iphoneBlocks);
                //$this->loadBlocks($this->mobileBlocks);
                break;
            case ('iphone'):
                $this->loadBlocks($this->iphoneBlocks);
                break;
            default:
                $this->loadBlocks($this->desktopBlocks);
                break;
        }
    }

    /*
     * Private method to create doctype tag based on user device platform.
     * 
     * @param	   $platform	   String	  User platform
     * 
     * @return	  String		  Suitable doctype bases on given platform
     */
    private function createDoctype($platform) {

        $platform = strtolower($platform);
        switch ($platform) {
            case 'desktop':
            case 'iphone':
            case 'ipad':
                $doctype = '<!DOCTYPE html>'; //HTML5 doctype
                break;
            case 'mobile':
                $doctype = '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">'; //Mobile and WAP devices doctype
                break;
            default:
                $doctype = '<!DOCTYPE html>';
                break;
        }

        return $doctype;
    }

    /*
     * public method to clean Joomla! native output head.
     * 
     * @param   $joomlaHead	 Object	  Joomla's default head.
     * @param   $fp			 Boolean	 Boolean value to check if the $joomlaHead belongs to frontpage or not.
     * 
     * @return  $joomlaHead	 Object	  Joomla's edited head.
     */
    public function cleanHead($joomlaHead, $fp = true) {

        reset($joomlaHead['scripts']);
        $user = JFactory::getUser();
        foreach ($joomlaHead['scripts'] as $script => $mime) {
            if (strpos($script, 'mootools-core.js') ||
                    strpos($script, 'mootools-more.js') ||
                    strpos($script, 'modal.js') ||
                    strpos($script, 'caption.js') ||
                    strpos($script, 'core.js') ||
                    strpos($script, 'k2.noconflict.js') ||
                    strpos($script, 'k2.js')
            ) {
                unset($joomlaHead['scripts'][$script]);
            }
        }
        foreach ($joomlaHead['styleSheets'] as $style => $mime) {
            if (strpos($style, 'modal.css') ||
                    strpos($style, 'captchaStyle.css')
            ) {
                unset($joomlaHead['styleSheets'][$style]);
            }
        }
        if (!empty($joomlaHead['script']['text/javascript'])) {
            // JCaption cleanup
            $joomlaHead['script']['text/javascript'] = preg_replace('%window\.addEvent\(\'load\',\s*function\(\)\s*{\s*new\s*JCaption\(\'img.caption\'\);\s*}\);\s*%', '', $joomlaHead['script']['text/javascript']);
            $joomlaHead['script']['text/javascript'] = preg_replace('"%^jQuery\\S*\\s*.+%ms"', '', $joomlaHead['script']['text/javascript']);
            // SqueezeBox cleanup
            $joomlaHead['script']['text/javascript'] = preg_replace('%window\.addEvent\(\'domready\', \s*function\(\)\s*{\s*SqueezeBox\.initialize\(\s*{\s*}\);\s*SqueezeBox\.assign\(\$\$\(\'a\.modal\'\),\s*{\s*parse\:\s*\'rel\'\s*}\);\s*}\);\s*%', '', $joomlaHead['script']['text/javascript']);
        } else {
            $joomlaHead['scripts'] = array();
            unset($joomlaHead['script']['text/javascript']);
        }
        unset($joomlaHead['metaTags']['standard']['rights']);
        unset($joomlaHead['metaTags']['standard']['author']);
        return $joomlaHead;
    }

    /*
     * Public method to check if there are any modules in given position or not.
     * 
     * @param	   $position   String	  Name of position to check
     * 
     * @return	  Boolean
     */
    public function countModules($position = null) {

        if ($position) {
            if ($this->tpl->countModules($position)) {
                return true;
            }
        }

        return false;
    }

    /*
     * Private method to set template width based on user device platform.
     * 
     * @return	  Int	 Template width
     */
    private function setTemplateWidth() {

        switch ($this->platform) {
            case 'desktop':
                $width = 960;
                break;
            case 'mobile':
                $width = 200;
                break;
            case 'iphone':
                //temporary
                $width = 960;
                break;
            default:
                $width = 960;
                break;
        }
        return $width;
    }

    /*
     * Private method to set template grid count.
     * 
     * @return	  Int	 Grid count
     */
    private function setTemplteGridCount() {

        $width = $this->width;
        $count = 12;

        if ($width < 320) {
            $count = 4;
        } else if (320 < $width && $width < 940) {
            $count = 6;
        } else if ($width > 940) {
            $count = 12;
        }

        return $count;
    }

    /*
     * Public method to check if current viewer is Facebook.
     * 
     * @return	  Boolean
     */
    public function isFacebook() {

        $agent = $this->device_array['agent'];
        if (!stristr($agent, 'facebook')) {
            //if (stristr($_SERVER["HTTP_USER_AGENT"], 'facebook') !== false) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Public method to create date string
     * 
     * @param	   $format	 String	  Date format. If no format is mentioned, will use language file.
     * 
     * @return	  Date in given format
     */
    public function createDate($format = null) {

        jimport('joomla.html.html');
        if (!$format) {
            return JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC1'));
        } else {
            return JHTML::_('date', 'now', $format);
        }
    }

    /*
     * Public method to check if current menu is default menu (frontpage).
     * 
     * @param	   $currentMenu	JMenuSite Object
     * 
     * @return	  $frontpage	  Boolean
     */
    public function checkDefaultMenu(&$currentMenu) {

        $frontpage = false;

        $frontpage = ($currentMenu->getActive() == $currentMenu->getDefault()) ? true : false;
        return $frontpage;
    }

    /*
     * Public method to load head tag based on user platform and language direction.
     * 
     * @param	   $browser		String	  User brwoser name
     * @param	   $version		Int		 Browser version. Currently only effective for IE
     */
    public function loadHead($browser, $version = null, $direction = 'ltr') {

        $rtlStylesheet = $this->tpl->baseurl . '/templates/' . $this->tpl->template . '/css/' . $direction . '.css';
        switch ($browser) {
            case "Internet Explorer":
                if ($version > 8) {
                    //require_once ('blocks/head/css3.php');
                } else if ($version < 8) {
                    require_once ('blocks/head/ie7lte.php');
                }
                require_once ('blocks/head/ie.php');
                break;
            /*
              case 'Chrome':
              case 'Firefox':
              case 'Opera':
              case 'Safari':
              require_once ('blocks/head/css3.php');
              break;
             */
            default:
                if ($this->platform != 'mobile') {
                    //require_once ('blocks/head/css3.php');
                }
                break;
        }
        if ($direction == 'rtl') { //RTL CSS
            $document = JFactory::getDocument();
            $document->addStyleSheet($rtlStylesheet);
        }
    }

    /*
     * Public method to check user's device platform using Browser class.
     * 
     * @param	   $array_response	 Boolean	 Changing method's output to an array.
     * 
     * @return	  Platform or an array about users device data.
     */
    public function checkPlatform($arary_response = false) {

        $browser = $this->Browser;

        $platform = $browser->getPlatform();
        $user_agent = $browser->getUserAgent();
        $user_browser = $browser->getBrowser();
        $browser_version = $browser->getVersion();
        $is_mobile = $browser->isMobile();
        $device = array(
            "platform" => $platform,
            "agent" => $user_agent,
            "browser" => $user_browser,
            "version" => $browser_version,
            "mobile" => $is_mobile,
        );

        if ($arary_response == true) {
            if ($device["platform"] != "iPhone" &&
                    $device["platform"] != "iPod" &&
                    $device["platform"] != "iPad" &&
                    $device["platform"] != "Android" &&
                    $device["platform"] != "BlackBerry" &&
                    $device["platform"] != "Nokia") {
                $device['platform'] = "Desktop"; //Changing platform to Desktop to make things easier
            } else if ($device["platform"] == "iPhone" ||
                    $device["platform"] == "iPod") {
                $device['platform'] = "iPhone";
            } else if ($device["platform"] == "BlackBerry" ||
                    $device["platform"] == "Nokia" ||
                    $device["platform"] == "Windows CE") {
                $device['platform'] = "Mobile";
            }
            return $device;
        }
        if ($device["browser"] == "iPhone" ||
                $device["browser"] == "iPod" ||
                $device["browser"] == "Android" ||
                $device["platform"] == "iPhone" ||
                $device["platform"] == "iPod" ||
                $device["platform"] == "Android") {
            return "iPhone";
        } else if ($device["browser"] == "iPad" || $device["platform"] == "iPad") {
            return "iPad";
        } else if ($device["browser"] == "Opera Mini" ||
                $device["browser"] == "Pocket Internet Explorer" ||
                $device["browser"] == "BlackBerry" ||
                $device["browser"] == "Nokia S60 OSS Browser" ||
                $device["browser"] == "Nokia Browser" ||
                $device["platform"] == "BlackBerry" ||
                $device["platform"] == "Windows CE" ||
                $device["platform"] == "Nokia") {
            return "Mobile";
        } else {
            return "Desktop";
        }
    }

    /*
     * Public method to check if template cookie is available in user browser
     * or not. If it's not available try to set it
     */
    public function checkCookie($key = null, $value = null) {

        $n = JRequest::getVar($key, '', 'cookie');
        if ($n) {
            if (isset($value)) {
                $this->setMyCookie($key, $value, $time);
            }
            return $n;
        } else {
            return false;
        }
    }

    /*
     * Private method to set template cookie.
     * 
     * @param	   $value	  string	  device name that will be used in cookie
     * @param	   $time	   int		 cookie time in seconds
     * 
     * @return	  boolean	 this method returns true on success and false in unsuccessful action.
     */
    private function setMyCookie($key, $value, $time = 86400) {

        if (setcookie($key, $value, time() + $time)) {

            return true;
        }
        return false;
    }

    /*
     * Public method to remove template cookie.
     */
    public function removeMyCookie($key = null) {
        if (isset($key)) {
            unset($_COOKIE[$key]);
            return setcookie($key, NULL, -1);
        }
        return false;
    }
}