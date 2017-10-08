<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// No direct access
defined ( '_JEXEC' ) or die ();

/**
 * J2Html class provides Form Inputs
 */

class J2Html {

	/**
	 * Create a label for an input
	 * @param string type $text
	 * * @param string type $label_for
	 * @params string type attributes
	 * @result return html
	 */
	public static function label($text, $name='', $options=array()){
		$options['class'] = isset($options['label_class']) ? $options['label_class'] : isset($options['class']) ? $options['class'] : "" ;
		$options['for'] = isset($options['for']) ? $options['for'] : $name;
		$attribs = JArrayHelper::toString($options);
		$html ='<label '.$attribs .'>'. $text.'</label>';
		return $html;
	}

	/**
	 * Create a text input field.
	 *
	 * @param  string  $name
	 * @param  string  $value
	 * @param  array   $options
	 * @return string
	 */
	public static function text($name, $value = null, $options = array())
	{
		return self::input('text', $name, $value, $options);
	}


	/**
	 * Create a price input field.
	 *
	 * @param  string  $name
	 * @param  string  $currency symbol
	 * @param  string  $value
	 * @param  array   $options
	 * @return string
	 */
	public static function price($name, $value = null, $options = array())
	{
		$optionvalue = JArrayHelper::toString($options);
		$symbol = J2Store::currency()->getSymbol();
		// return price input
		$html = '';
		$html .= '<div class="input-prepend">';
		if(!empty($symbol)) {
			$html .='<span class="add-on">'.$symbol.'</span>';
		}
		$html .='<input type="text" name="'.$name.'" value="'.$value.'"  '.$optionvalue.'    />';
		$html .='</div>';
		J2Store::plugin()->event('PriceInput', array($name, $value, $options, &$html));
		return $html;
	}


	/**
	 * Create a price input field with dynamic data
	 *
	 * @param  string  $name
	 * @param  string  $currency symbol
	 * @param  string  $value
	 * @param  array   $options
	 * @param object   A table record
	 * @return string
	 */
	public static function price_with_data($prefix, $primary_key, $name, $value = null, $options = array(), $data)
	{
		$optionvalue = JArrayHelper::toString($options);
		$symbol = J2Store::currency()->getSymbol();
		// return price input
		$html = '';
		$html .= '<div class="input-prepend">';
		if(!empty($symbol)) {
			$html .='<span class="add-on">'.$symbol.'</span>';
		}
		$html .='<input type="text" name="'.$prefix.$name.'" value="'.$value.'"  '.$optionvalue.'    />';
		$html .='</div>';
		J2Store::plugin()->event('PriceInputWithData', array($prefix, $primary_key, $name, $value, $options, &$html, $data));
		return $html;
	}


	/**
	 * Creates Checkbox list field
	 * @param string $value
	 * @param array $data
	 * @param array $options
	 * @result html with list of checkbox
	 */
	/* public static function checkboxList($value,$data,$options=array()){
		$html ='';
		$html .= '<div class="controls">';
		foreach($data as $key =>$value){
			$options['id'] = isset($options['id']) ? $options['id'].'_'.$key : $key;
			$optionvalue = self::attributes($options);
			$html .= '<label class="control-label" for="j2store_input-'.$key.'">';
			$html .='<input type="checkbox" '.$optionvalue.'  value="'.$value.'"     />';
			$html .= $value;
			$html .='</label>';
		}
		$html .='</div>';
	return $html;
	} */

	/**
	 * Creates a single checkbox element
	 * @param stringe $name
	 * @param unknown_type $value
	 * @param array $options
	 * @result html
	 */
	public static function checkbox($name, $value = null, $options = array()){
		return self::input('checkbox', $name, $value, $options);
	}

	/**
	 * Create a textarea  field.
	 * @param  string  $name
	 * @param  string   $value
	 * @param  array   $options
	 * @return string
	 */
	public static function textarea($name,$value,$options=array()){
		return self::input('textarea', $name, $value, $options);
	}

	/**
	 * Create a File Field
	 * @param string $name
	 * @param string $value
	 * @param arrat() $options
	 */
	public static function file($name,$value,$options=array()){
		return self::input('file', $name, $value, $options);
	}
	/**
	 * Creates a email field
	 * @param string $name
	 * @param unknown_type $value
	 * @param array $options
	 * @result options
	 */
	public static function email($name,$value,$options=array()){
		return self::input('email', $name, $value, $options);
	}

	/**
	 * Create a select box field.
	 *
	 * @param  string  $type The type of the select field
	 * @param  string  $name
	 * @param  array   $list
	 * @param  string  $selected
	 * @param  array   $options
	 * @return string
	 */
	/* public static function select($type, $name , $value, $id='', $options=array(), $relations=array(), $placeholder=array()){
		return J2Select::select($type, $name, $value, $id='', $options, $relations, $placeholder);
	} */


	public static function select(){
		return new J2Select();
	}



	/**
	 * Creates a radio field
	 * @param string $name
	 * @param string $value
	 * @param array $options
	 * @result html
	 */
	public static function radio($name,$value,$options=array()){
		return self::input('radio', $name, $value, $options);
	}


	/**
	 * Creates a radio boolean  field
	 * @param string $name
	 * @param string $value
	 * @param array $options
	 * @result html
	 */
	public static function radioBooleanList($name , $value='' ,$options=array()){

		$html ='';
		$id = isset($options['id']) && !empty($options['id']) ?  $options['id'] : $name;
		if(!isset($options['hide_label'] ) && empty($options['hide_label'])){

			$html .='<div class="control-group">';
			$label_text = isset($options['label_text']) ?  $options['label_text'] : "test";
			$html .= self::label($label_text, $options=array());
		}
		$html .= JHtmlSelect::booleanlist($name, $attribs = array(), $value, $yes = 'JYES', $no = 'JNO',$id);
		if(!isset($options['hide_label'] ) && empty($options['hide_label'])){
			$html .='</div>';
		}

		return $html;

	}

	/**
	 * Create a hidden field
	 * @param string $name
	 * @param string $value
	 * @param array $options
	 */
	public static function hidden($name,$value,$options=array()){
		return self::input('hidden',$name,$value, $options);
	}

	/**
	 * Create a button field
	 * @param string $name
	 * @param string $value
	 * @param array $options
	 */
	public static function button($name,$value,$options=array()){
		return self::input('button',$name,$value, $options);
	}



	/**
	 * Creates Media field
	 * TODO need to update
	 * @param string $name
	 * @param string $value
	 * @param array $options
	 */
	public static function media($name ,$value='' ,$options=array() ){
		$config = JFactory::getConfig();
		$asset_id = $config->get('asset_id');
		//to overcome Permission access Issues to media
		//@front end
		if(JFactory::getApplication()->isSite()){
			$asset_id = JFactory::getConfig('com_content')->get('asset_id');
		}

		$id = isset($options['id']) ? $options['id'] : $name;
		$hide_class = isset( $options['no_hide'] ) ? $options['no_hide'] : 'hide';
		$image_id =isset($options['image_id']) ? $options['image_id'] : 'img'.$id;
		$class = isset($options['class']) ? $options['class'] : '';
		$empty_image = JUri::root().'media/j2store/images/common/no_image-100x100.jpg';
		$image = JUri::root();
		jimport('joomla.filesystem.file');
		$imgvalue = (isset($value) && !empty($value)) ? $value : 'media/j2store/images/common/no_image-100x100.jpg';

		if ($value && file_exists(JPATH_ROOT . '/' . $value))
		{
			$folder = explode('/', $value);
			$folder = array_diff_assoc($folder, explode('/', JComponentHelper::getParams('com_media')->get('image_path', 'images')));
			array_pop($folder);
			$folder = implode('/', $folder);
		}

		else
		{
			$folder = '';
		}


		if(JFile::exists(JPATH_SITE .'/'.$imgvalue)){
			$image.= (isset($value) && !empty($value)) ? $imgvalue : $imgvalue;
		}
		$route = JUri::root();
		$script ="
	  function removeImage(element){
	  		var ParentDiv = jQuery(element).closest('.input-group');
	  		var InputBox = ParentDiv.find(':input') ;
			var InputImage =ParentDiv.find('img');

			var no_preview ='JUri::root().media/j2store/images/common/no_image-100x100.jpg';

			jQuery(InputBox).attr('value','');
	  		jQuery(InputImage).attr('src','$empty_image') ;
			jQuery('html, body').animate({
				scrollTop: jQuery(ParentDiv).offset().top
		     });
		}
	function previewImage(element,id){
		var value='$route'+jQuery('#'+element.id).attr('value');
		var ParentDiv = jQuery(element).closest('.input-group');
		var inputBox = ParentDiv.find(':input') ;
  		jQuery(inputBox).attr('');
		var InputImage =ParentDiv.find('img') ;
		jQuery(InputImage).attr('src',value);
	}

	function jInsertFieldValue(value, id) {
	    var old_id = document.id(id).value;
		if (old_id != id) {
			var elem = document.id(id)
			elem.value = value;
			elem.fireEvent('change');
			previewImage(elem,id);
		}
	}
	";
		$script_popup = "
	window.addEvent('domready', function() {
		SqueezeBox.initialize({});
		SqueezeBox.assign($('a.modal-button'), {
			parse: 'rel'
		});
	});";
		$style="
		.j2store-media-slider-image-preview{
			width:50px;

		}";
		JFactory::getDocument()->addStyleDeclaration($style);
		JFactory::getDocument()->addScriptDeclaration($script);
		$version =  substr(JVERSION, 0,5);
		if (version_compare($version, '3.5.0', 'ge') && version_compare($version, '3.6.3', 'lt')){
			$html ='';
			$html ='<div class="form-inline">';
			$html .= '<div data-preview-height="200" data-preview-width="200" data-preview-container=".field-media-preview" data-preview="false" data-button-save-selected=".button-save-selected" data-button-clear=".button-clear" data-button-cancel=".button-cancel" data-button-select=".button-select" data-input=".field-media-input" data-modal-height="400px" data-modal-width="100%" data-modal=".modal" data-url="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset='.$asset_id.'&amp;author='.JFactory::getUser()->id.'&amp;fieldid={field-media-id}&amp;folder=" data-basepath="'.JURI::root().'" class="field-media-wrapper">';
			$html .= '<div class="modal fade j2store-media-model-popup '.$hide_class.'" tabindex="-1" id="imageModal_jform_image_'.$id.'" >';
			$html .= '<div class="modal-header">';
			$html .= '	<button data-dismiss="modal" class="close" type="button">×</button>';
			$html .=	'	<h3>Change Image</h3>';
			$html .= '</div>';
			$html .= '<div class="modal-body">';
			$html .= '</div>';
			$html .= '<div class="modal-footer">';
			$html .='<button data-dismiss="modal" class="btn">';
			$html .= JText::_('J2STORE_CANCEL');
			$html .='</button></div>';
			$html .='</div>';
			$html .='<div class="input-group">';
			$html .='<img class="j2store-media-slider-image-preview"  id="'.$image_id.'"	src="'.$image.'" alt="" />';
			$html .='<input onchange="previewImage(this,jform_image_'. $id .')" image_id="'.$image_id.'" id="jform_image_'.$id.'" class="input-small hasTooltip field-media-input '.$class.'" value="'.htmlspecialchars($value, ENT_COMPAT, 'UTF-8').'" type="text" readonly="readonly"   name="'.$name.'" /> ';
			$html .='<span class="input-group-btn">';
			$html .='<a id="media-browse" style="display:inline;position:relative;" class="btn btn-success button-select" >';
			$html .= JText::_('J2STORE_IMAGE_SELECT');
			$html .='</a>';
			$html .='<a id="media-cancel" class="btn hasTooltip btn-inverse" onclick="removeImage(this)"  href="#" title=""><i class="icon-remove"></i></a>';
			$html .='</span>';
			$html .='</div>';
			$html .='</div>';
			$html .='</div>';
		}else{
			JFactory::getDocument()->addScriptDeclaration($script_popup);
			$html ='';
			$html ='<div class="form-inline">';
			$html .='<div class="input-group">';
			$html .='<img class="j2store-media-slider-image-preview"  id="'.$image_id.'"	src="'.$image.'" alt="" />';
			$html .='<input onchange="previewImage(this,'. $id .')" image_id="'.$image_id.'" id="jform_image_'.$id.'" class="input-mini '.$class.'" value="'.htmlspecialchars($value, ENT_COMPAT, 'UTF-8').'" type="text" readonly="readonly"   name="'.$name.'" /> ';
			$html .='<span class="input-group-btn">';
			$html .='<a id="media-browse" style="display:inline;position:relative;" class="modal btn btn-success" rel="{handler:\'iframe\', size: {x: 800, y: 500}}" href="index.php?option=com_media&view=images&tmpl=component&asset='.$asset_id.'&author='.JFactory::getUser()->id.'&fieldid=jform_image_'.$id.'&folder='.$folder.'" title="'.JText::_('PLG_J2STORE_EXTRAIMAGES_SELECT') .'">';
			$html .= JText::_('J2STORE_IMAGE_SELECT');
			$html .='</a>';
			$html .='<a id="media-cancel" class="btn hasTooltip btn-inverse" onclick="removeImage(this)"  href="#" title=""><i class="icon-remove"></i></a>';
			$html .='</span>';
			$html .='</div>';
			$html .='</div>';
		}
		
		return $html;
	}









	public static function calendar($name,$value,$options=array()){
		$id = isset($options['id']) ? $options['id']: self::clean($name);
		$nullDate = JFactory::getDbo()->getNullDate();
		if($value == $nullDate || empty($value)) {
			$value = $nullDate;
		}
		return JHtml::_('calendar', $value,$name,$id, $format = '%d-%m-%Y',$options);
	}



	/**
	 * Creates Link field
	 * TODO need to update
	 * @param unknown_type $href
	 * @param unknown_type $text
	 * @param unknown_type $options
	 */
	public static function link($href='',$text,$options=array()){

		$href = isset($href) && !empty($href) ? $href : 'javascript:void(0)';
		$icon = isset($options['icon']) && !empty($options['icon']) ? '<i class="'.$options['icon'].'"></i>' : '';
		$class = isset($options['class']) && !empty($options['class']) ? $options['class'] : '';
		$id = isset($options['id']) && !empty($options['id']) ? $options['id'] : '';
		$onclick= isset($options['onclick']) && !empty($options['onclick']) ? $options['onclick'] : '';
		$html ='<a id="'.$id.'"  href="'.$href.'" class="'.$class.'"';
			if(isset($options['onclick']) && !empty($options['onclick'])){
		$html .= 'onclick="'.$onclick.'"';
			}

		$html .='>'.$icon . $text .'</a>';
		 return $html;
	}
	/**
	 * Create a form input field.
	 *
	 * @param  string  $type
	 * @param  string  $name
	 * @param  string  $value
	 * @param  array   $options
	 * @return string
	 */
	public static function input($type, $name, $value = null, $options = array())
	{
		//will implode all the options value and return as element attributes
		//$optionvalue = self::attributes($options);
		$optionvalue = JArrayHelper::toString($options);

		//assign the html
		$html = '' ;
		//swtich the type of input
		switch($type){

			// return text input
			case 'text':
					$html .='<input type="text" name="'.$name.'" value="'.$value.'"  '.$optionvalue.'    />';
				break;

			//return email input
			case 'email':
					$html .='<input type="email" name="'.$name.'"  value="'.$value.'"  '.$optionvalue.'    />';
				break ;

			//return password input
			case 'password':
					$html .='<input type="password"  name="'.$name.'" '.$optionvalue.'  value="'.$value.'"     />';
				break;

			//return textarea input element
			case 'textarea':
					$html .='<textarea '.$optionvalue.' name="'.$name.'"  value="'.$value.'"     >'. $value .'</textarea>';
				break;

			//return file input element
			case 'file':
					$html .='<input type="file" name="'.$name.'" '.$optionvalue.'  value="'.$value.'"     />';
				break;

			//return radio input element
			case 'radio':
				$id = isset($options['id']) && !empty($options['id']) ? $options['id'] : '';
				$html .= J2Html::booleanlist($name, $options, $value, $yes = 'JYES', $no = 'JNO', $id);
				break;

			//return checkbox element
			case 'checkbox':
				$html .='<input type="checkbox" '.$optionvalue.'  value="'.$value.'"     />';
				break;

			case 'editor':
				break;

			case 'button':
					$html .='<input type="button" name="'.$name.'"  '.$optionvalue .'    value ="'.$value.'"';
					if(isset($options['onclick']) && !empty($options['onclick'])){
						$html .='   onclick ="'.$options['onclick'].'"';
					}
					$html .='  />';
				break;

			case 'submit':
				$html .='<input type="submit" name="'.$name.'"  '.$optionvalue .'value ="'.$value.'" />';
				break;

			case 'hidden':
				$html .='<input type="hidden" name="'.$name.'" '.$optionvalue .' value ="'.$value.'" />';
				break;

			case 'file' :
				$html .='<input type="file" name="'.$name.'" value="'.$value.'" />';
			 break;


		}

		return $html;
	}

	public static function getOrderStatusHtml($id){
		$html ='';
		$item = F0FModel::getTmpInstance('OrderStatuses','J2StoreModel')->getItem($id);
		if($id){
			$html .='<label class="label '.$item->orderstatus_cssclass .'">'.JText::_($item->orderstatus_name).'</label>';
		}
		return $html;
	}

	public static function getUserNameById($id){
		$html ='';
		$user = JFactory::getUser($id);
		return $user->name;
	}

	/**
	 * Build an HTML attribute string from an array.
	 *
	 * @param  array  $attributes
	 * @return string
	 */
	public static function attributes($attributes)
	{
		$html = array();

		// For numeric keys we will assume that the key and the value are the same
		// as this will convert HTML attributes such as "required" to a correct
		// form like required="required" instead of using incorrect numerics.
		foreach ((array) $attributes as $key => $value)
		{

			$element = self::attributeElement($key, $value);

			if ( ! is_null($element)) $html[] = $element;
		}
		return count($html) > 0 ? ' '.implode(' ', $html) : '';
	}

	/**
	 * Build a single attribute element.
	 *
	 * @param  string  $key
	 * @param  string  $value
	 * @return string
	 */
	protected static function attributeElement($key, $value)
	{
		if (is_numeric($key)) $key = $value;

		if ( ! is_null($value))

			return $key.'="'.($value).'"';
	}



	public static function booleanlist($name, $attribs = array(), $selected = null, $yes = 'JYES', $no = 'JNO', $id = false)
	{
		$arr = array(JHtml::_('select.option', '0', JText::_($no)), JHtml::_('select.option', '1', JText::_($yes)));

		return J2Html::radiolist($arr, $name, $attribs, 'value', 'text', (int) $selected, $id);
	}


	public static function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}


	/**
	 * Generates an HTML radio list.
	 *
	 * @param   array    $data       An array of objects
	 * @param   string   $name       The value of the HTML name attribute
	 * @param   string   $attribs    Additional HTML attributes for the <select> tag
	 * @param   mixed    $optKey     The key that is selected
	 * @param   string   $optText    The name of the object variable for the option value
	 * @param   string   $selected   The name of the object variable for the option text
	 * @param   boolean  $idtag      Value of the field id or null by default
	 * @param   boolean  $translate  True if options will be translated
	 *
	 * @return  string  HTML for the select list
	 *
	 * @since   1.5
	 */
	public static function radiolist($data, $name, $attribs = null, $optKey = 'value', $optText = 'text', $selected = null, $idtag = false,
			$translate = false)
	{
		reset($data);

		$id = isset($attribs['id']) && !empty($attribs['id']) ? $attribs['id'] :'';

		if (is_array($attribs))
		{
			$attribs = JArrayHelper::toString($attribs);
		}

		$id_text = $idtag ? $idtag : self::clean($name) ;

		$html = '<div class="radio">';

		foreach ($data as $obj)
		{
			$k = $obj->$optKey;
			$t = $translate ? JText::_($obj->$optText) : $obj->$optText;
			$id = (isset($obj->id) ? $obj->id : null);

			$extra = '';
			$id .= $id ? $obj->id : $id_text . $k;

			if (is_array($selected))
			{
				foreach ($selected as $val)
				{
					$k2 = is_object($val) ? $val->$optKey : $val;

					if ($k == $k2)
					{
						$extra .= ' selected="selected" ';
						break;
					}
				}
			}
			else
			{
				$extra .= ((string) $k == (string) $selected ? ' checked="checked" ' : '');
			}

			$html .= "\n\t" . '<label for="' . $id . '" id="' . $id . '-lbl" class="radio">';
			$html .= "\n\t\n\t" . '<input type="radio" name="' . $name . '" id="' . $id . '" value="' . $k . '" ' . $extra
			. $attribs . ' />' . $t;
			$html .= "\n\t" . '</label>';
		}

		$html .= "\n";
		$html .= '</div>';
		$html .= "\n";
		return $html;
	}




	public static function checkboxlist($data, $name, $attribs = null, $optKey = 'value', $optText = 'text', $selected = null, $idtag = false,
			$translate = false)
	{
		reset($data);

		if (is_array($attribs))
		{
			$attribs = JArrayHelper::toString($attribs);
		}

		$id_text = $idtag ? $idtag : $name;

		$html = '<div class="checkbox">';

		foreach ($data as $obj)
		{
			$k = $obj->$optKey;
			$t = $translate ? JText::_($obj->$optText) : $obj->$optText;
			$id = (isset($obj->id) ? $obj->id : null);

			$extra = '';
			$id = $id ? $obj->id : $id_text . $k;

			if (is_array($selected))
			{
				foreach ($selected as $val)
				{
					$k2 = is_object($val) ? $val->$optKey : $val;

					if ($k == $k2)
					{
						$extra .= ' selected="selected" ';
						break;
					}
				}
			}
			else
			{
				$extra .= ((string) $k == (string) $selected ? ' checked="checked" ' : '');
			}

			$html .= "\n\t" . '<label for="' . $id . '" id="' . $id . '-lbl" class="checkbox">';
			$html .= "\n\t\n\t" . '<input type="checkbox" name="' . $name . '" id="' . $id . '" value="' . $k . '" ' . $extra
			. $attribs . ' >' . $t;
			$html .= "\n\t" . '</label>';
		}

		$html .= "\n";
		$html .= '</div>';
		$html .= "\n";

		return $html;
	}

	/**
	 * Method to return PRO feature notice
	 *
	 * @return string
	 */

	public static function pro() {
		if(!class_exists('J2Store')) {
			require_once JPATH_ADMINISTRATOR.'/components/com_j2store/helpers/j2store.php';
		}
		$view = J2Store::view();
		$view->setDefaultViewPath(JPATH_ADMINISTRATOR.'/components/com_j2store/views/eupdates/tmpl');
		$html = $view->getOutput('profeature');
		return $html;
	}

}

class J2Select extends JObject {

	protected $state;

	protected $options;

	public function __construct($properties=null) {

		if(!is_object($this->state)) {
			$this->state = new JObject();
		}
		$this->options = array();
		parent::__construct($properties);

	}

	/**
	 * Magic getter; allows to use the name of model state keys as properties
	 *
	 * @param   string  $name  The name of the variable to get
	 *
	 * @return  mixed  The value of the variable
	 */
	public function __get($name)
	{
		return $this->getState($name);
	}

	/**
	 * Magic setter; allows to use the name of model state keys as properties
	 *
	 * @param   string  $name   The name of the variable
	 * @param   mixed   $value  The value to set the variable to
	 *
	 * @return  void
	 */
	public function __set($name, $value)
	{
		return $this->setState($name, $value);
	}

	/*
	* Magic caller; allows to use the name of model state keys as methods to
	* set their values.
	*
	* @param   string  $name       The name of the state variable to set
	* @param   mixed   $arguments  The value to set the state variable to
	*
	* @return  J2Select  Reference to self
	*/
	public function __call($name, $arguments)
	{
		$arg1 = array_shift($arguments);
		$this->setState($name, $arg1);

		return $this;
	}


	/**
	 * Method to set model state variables
	 *
	 * @param   string  $property  The name of the property.
	 * @param   mixed   $value     The value of the property to set or null.
	 *
	 * @return  mixed  The previous value of the property or null if not set.
	 */
	public function setState($property, $value = null)
	{
		return $this->state->set($property, $value);
	}

	/**
	 * Method to set model state variables
	 *
	 * @param   string  $property  The name of the property.
	 * @param   mixed   $value     The value of the property to set or null.
	 *
	 * @return  mixed  The previous value of the property or null if not set.
	 */
	public function getState($property=null, $default=null)
	{
		return $property === null ? $this->state : $this->state->get($property, $default);
	}

	public function clearState()
	{
		$this->state = new JObject();
		return $this;
	}

	/*
	* Method to return a select list. Allows mapping table relations
	* Example for relations
	* array (
			'hasone' => array (
					'Vendors' => array (
							'fields' => array (
									'key'=>'j2store_vendor_id',
									'name'=>array('company')
							)
					)
			)
	);
	*
	*/

	public function getHtml() {

		$html = '';

		$state = $this->getState();

		$value = isset($state->value) ? $state->value : '';
		$attribs = isset($state->attribs) ? $state->attribs: array();

		$placeholder = isset($state->placeholder) ? $state->placeholder: array();

		if(isset($state->hasOne)) {
			$modelName = $state->hasOne;
			$model = F0FModel::getTmpInstance($modelName, 'J2StoreModel');

			//check relations
			if(isset($state->primaryKey) && isset($state->displayName)) {
				$primary_key = $state->primaryKey;
				$displayName = $state->displayName;

			}else {
					$primary_key = $model->getTable()->getKeyName();
					$knownFields = $model->getTable()->getKnownFields();
					$displayName = $knownFields[1];
			}

			if(isset($state->ordering) && !empty($state->ordering)) {
				$model->setState('filter_order', $state->ordering);
			}

			$items = $model->enabled(1)->getList();

			if(count($items)) {
				foreach ($items as $item) {
					if(is_array($displayName)) {
						$text = '';
						foreach($displayName as $n) {
							if(isset($item->$n)) $text .= JText::_($item->$n).' ';
						}
					} else {
						$text = JText::_($item->$displayName);
					}
					$this->options[] = JHtml::_ ( 'select.option', $item->$primary_key, $text );
				}
			}

		}


		$idTag = isset($state->idTag) ? $state->idTag: 'j2store_'.F0FInflector::underscore($state->name);

		return JHtml::_ ( 'select.'.$state->type, $this->options, $state->name, $attribs, 'value', 'text', $value, $idTag );
	}


	public function setRelations($relations=array()) {

		$state = $this->getState();

		if(is_array($relations) && isset($relations['fields']) && count($relations['fields'])) {
			$primary_key = $relations['fields']['key'];
			$displayName = $relations['fields']['name'];
		}
		$this->setState('primaryKey', $primary_key);
		$this->setState('displayName', $displayName);
		return $this;
	}

	public function setPlaceholders($placeholders=array()) {

		//placeholder
		if(is_array($placeholders) && count($placeholders)) {
			foreach ($placeholders as $k=>$v) {
			 $this->options[] = JHtml::_ ( 'select.option', $k, $v);
			}
		} else {
			$this->options[] = JHtml::_ ( 'select.option', '', JText::_('J2STORE_SELECT_OPTION'));
		}

		return $this;
	}


}
