<?php
/**
 * @package   OSMap
 * @copyright 2007-2014 XMap - Joomla! Vargas - Guillermo Vargas. All rights reserved.
 * @copyright 2016 Open Source Training, LLC. All rights reserved.
 * @contact   www.alledia.com, support@alledia.com
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

use Alledia\OSMap;

defined('_JEXEC') or die();

OSMap\Factory::getApplication()->input->set('tmpl', 'component');

JHtml::stylesheet('media/com_osmap/css/admin.min.css');

if (empty($this->message)) {
    echo $this->loadTemplate('items');
}

jexit();
