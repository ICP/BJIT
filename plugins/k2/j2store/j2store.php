<?php

// no direct access
defined('_JEXEC') or die ('Restricted access');
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}

if (!defined('F0F_INCLUDED'))
{
	include_once JPATH_LIBRARIES . '/f0f/include.php';
}
require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/helpers/j2store.php');
JLoader::register('K2Plugin', JPATH_ADMINISTRATOR.'/components/com_k2/lib/k2plugin.php');
JLoader::register('K2Parameter', JPATH_ADMINISTRATOR.'/components/com_k2/lib/k2parameter.php');
class plgK2J2Store extends K2Plugin {

	// Some params
	var $pluginName = 'j2store';
	var $pluginNameHumanReadable = 'J2 Store';

	function __construct( & $subject, $params) {

		parent::__construct($subject, $params);
		//$this->loadLanguage( '', JPATH_ADMINISTRATOR );
		$lang = JFactory::getLanguage();
		$lang->load('com_j2store');
	}

	public function onK2PrepareContent($item, $params, $page = 0)
	{

		$app = JFactory::getApplication();
		// Bail out if the page is not HTML
		if ($app->input->getCmd('format') != 'html' && $app->input->getCmd('format') != '') return;

		//running from the backend
		if (JFactory::getApplication()->isAdmin()) {
			return false;
		}

		$j2params = J2Store::config();
		if ($j2params->get('addtocart_placement', 'default') == 'default') {
			return false;
		}

		// simple performance check to determine whether bot should process further
		if (strpos($item->text, '{j2store}') === false) {
			return true;
		}

		$regex = '/{j2store}(.*?){\/j2store}/';
		preg_match_all($regex, $item->text, $newmatches, PREG_SET_ORDER);
		if (isset($newmatches[0]) && count($newmatches[0])) {
			foreach ($newmatches as $newmatch) {
				if (empty($newmatch[1])) {
					break;
				}
				$values = explode('|', $newmatch[1]);
				//first value should always be the ID.
				if ($values[0]) {

					$product = F0FTable::getAnInstance('Product', 'J2StoreTable')->getClone();
					if ($product->get_product_by_id($values[0])) {
						$html = $product->get_product_html();
					}
					if ($html === false) {
						$html = '';
					}

					$item->text = str_replace($newmatch[0], $html, $item->text);
				}

			}
		}
	}

	function onK2AfterDisplay( & $item, & $params, $limitstart) {

		$app = JFactory::getApplication();
		$html = '';
		if($app->isSite()){
			
			$j2params = J2Store::config();
			if($j2params->get('addtocart_placement', 'default') == 'tag') {
				return '';
			}
			$cache = JFactory::getCache();
			$cache->clean('com_j2store');
			
			if($item->id) {
				$product = F0FTable::getAnInstance('Product', 'J2StoreTable')->getClone();
				if($product->get_product_by_source('com_k2', $item->id)) {
					$html = $product->get_product_html();
				}
				if($html === false) {
					$html = '';
				}
			}
			
		}

		return $html;

	}

	function onAfterK2Save($row, $isNew) {

		if (!defined('F0F_INCLUDED')){
			include_once JPATH_LIBRARIES . '/f0f/include.php';
		}
		if($row->id) {
			$app = JFactory::getApplication();
			$plugins = $this->_getPluginData($row);
			$data = $plugins->get('j2data');
			$data->product_source = 'com_k2';
			$data->product_source_id = $row->id;
			F0FModel::getTmpInstance('Products', 'J2StoreModel')->save($data);
		}	
	}

	 function onRenderAdminForm( & $item, $type, $tab='') {

	 	$app = JFactory::getApplication();

		if($type == 'item' && $tab == 'content') {

			//if(!$app->isSite()) {

				//render the form
				if ( !empty ($tab)) {
					$path = $type.'-'.$tab;
				}
				else {
					$path = $type;
				}
				if (!isset($item->plugins))
				{
					$item->plugins = NULL;
				}

				$xml_file = JPATH_SITE.'/plugins/k2/'.$this->pluginName.'/'.$this->pluginName.'.xml';

				if (version_compare(JVERSION, '3.0', 'ge')) {

					jimport('joomla.form.form');
					$form = JForm::getInstance('plg_k2_'.$this->pluginName.'_'.$path, $xml_file, array(), true, 'fields[@group="'.$path.'"]');
					//print_r($form);
					$values = array();
					if ($item->plugins)
					{
						foreach (json_decode($item->plugins) as $name => $value)
						{
							$count = 1;
							$values[str_replace($this->pluginName, '', $name, $count)] = $value;
						}
						$form->bind($values);
					}
					$fields = '';
					foreach ($form->getFieldset() as $field)
					{
						$search = 'name="'.$field->name.'"';
						$replace = 'name="plugins['.$this->pluginName.$field->name.']"';
						$input = JString::str_ireplace($search, $replace, $field->__get('input'));
						$fields .= $field->__get('label').' '.$input;
					}
				} else {
					$form = new K2Parameter($item->plugins, $xml_file, $this->pluginName);
				    $fields = $form->render('plugins', $path);
				}

				if ($fields){
					$plugin = new JObject;
					$plugin->set('name', JText::_( 'J2Store' ));
					$plugin->set('fields', $fields);
					return $plugin;
				}

			//}

		}

	}

	//function to get plugin data

	protected function _getPluginData($row) {

		$pluginName = 'j2store';

		if(JVERSION==1.7) {
			// Get the output of the K2 plugin fields (the data entered by your site maintainers)
			$plugins = new JParameter($row->plugins, '', $pluginName);
		} else {
			$plugins = new K2Parameter($row->plugins, '', $pluginName);
		}

		return $plugins;
	}
	
	
	function onJ2StoreAfterGetProduct($product) {

		if(isset($product->product_source) && $product->product_source == 'com_k2' ) {
			
				$content = $this->getK2Item($product->product_source_id);
				if($content->id) {
					//assign
					$product->source = $content;
					$product->product_name = $content->title;
					$product->product_edit_url = JRoute::_('index.php?option=com_k2&view=item&task=edit&cid='.$product->product_source_id);
					
					require_once (JPATH_SITE.'/components/com_k2/helpers/route.php');
					require_once (JPATH_SITE.'/components/com_k2/helpers/utilities.php');
					$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($content->id.':'.urlencode($content->alias), $content->catid.':'.urlencode($content->categoryalias))));
				
					$product->product_view_url = JRoute::_($link);

					if($content->published == 1 ) {
						$product->exists = 1;
					} else {
						$product->exists = 0;
					}					
				} else {
					$product->exists = 0;
				}

		}
	}
	
	function getK2Item($content_id) {
		
			static $sets;

		if (! is_array ( $sets )) {
			$sets = array ();
		}
		if (! isset ( $sets [$content_id] )) {
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true )->select ( 'i.*' )->from ( '#__k2_items as i' )->where ( 'i.id=' . $db->q ($content_id) );
			$query->select('c.id AS categoryid, c.alias AS categoryalias');
			$query->leftJoin('#__k2_categories c ON c.id = i.catid');			
			$db->setQuery ( $query );
			$sets [$content_id] = $db->loadObject ();
		}
		return $sets [$content_id];
		
	}


} // END CLASS
