<?php

define('_JEXEC', 1);
define('_API', 1);
define('DS', DIRECTORY_SEPARATOR);
define('K2_JVERSION', '30');
define('JPATH_BASE', dirname(dirname(dirname(__FILE__))));
define('API_BASE', dirname(dirname(__FILE__)));
ini_set('max_execution_time', 30000);

// Include the Joomla framework
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

$application = JFactory::getApplication('site');
$application->initialise();

require JPATH_BASE . '/libraries/vendor/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array('mode' => 'development'));

$app->_db = JFactory::getDbo();
$app->_input = JFactory::getApplication()->input;

require_once JPATH_BASE . '/api/helpers/JsonApiView.php';
require_once JPATH_BASE . '/api/helpers/JsonApiMiddleware.php';
require_once JPATH_BASE . '/api/helpers/jdatetime.class.php';

$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());

define('JPATH_COMPONENT_ADMINISTRATOR', JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . 'com_k2');
require_once (JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'route.php');
require_once (JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'utilities.php');
require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_k2' . DS . 'models' . DS . 'model.php');

include 'classes/route.php';
include 'classes/items.php';
include 'classes/schedule.php';
include 'classes/comments.php';