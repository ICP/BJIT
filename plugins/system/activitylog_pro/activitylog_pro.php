<?php
/**
 * @package		AdminPraise3
 * @author		AdminPraise http://www.adminpraise.com
 * @copyright	Copyright (c) 2008 - 2011 Pixel Praise LLC. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
 
 /**
 *    This file is part of AdminPraise.
 *    
 *    AdminPraise is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with AdminPraise.  If not, see <http://www.gnu.org/licenses/>.
 *
 **/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

function ualog_predict_id($table)
{
	$db = &JFactory::getDBO();

	$query = "SHOW TABLE STATUS LIKE '".$db->replacePrefix($table)."'";
	$db->setQuery($query);
	$result = $db->loadAssocList();

	$id = $result[0]['Auto_increment'];

	return $id;
}


function ualog_get_title($id, $table, $field = 'title', $key = null)
{
	$db = &JFactory::getDBO();

	$where = "id";

	if($table == '#__banner') {
		$where = "bid";
	}

	if($table == '#__bannerclient') {
		$where = "cid";
	}
	
	if ($key == null) {
		$key = 'id';
	}

	$query = "SELECT $field FROM $table WHERE $key = $id";
	$db->setQuery($query);
	$title = $db->loadResult();

	return htmlspecialchars( $title );
}

function ualog_save( $alink, $atitle, $item )
{
	$db      = &JFactory::getDBO();
	$user    = &JFactory::getUser();
	$time    = time();
	$com     = $db->Quote( JRequest::getVar('option') );
	$task    = $db->Quote( JRequest::getVar('task') );
	$user_id = $db->Quote( $user->id );

	$query = "INSERT INTO #__ualog VALUES("
	. "\n NULL,$user_id,$com,$task,$alink,$atitle,$item,$time)";
	$db->setQuery($query);
	$db->query();

	if($db->getErrorMsg()) {
		die($db->getErrorMsg());
	}
}

$user = JFactory::getUser();
$db   = JFactory::getDBO();
/*
// create log table if not exists
$query = "CREATE TABLE IF NOT EXISTS `#__ualog` (
          `id` int(11) NOT NULL auto_increment,
          `user_id` int(11) NOT NULL,
          `option` varchar(255) NOT NULL,
          `task` varchar(255) NOT NULL,
          `action_link` text NOT NULL,
          `action_title` text NOT NULL,
          `item_title` varchar(255) NOT NULL,
          `cdate` int(11) NOT NULL,
          PRIMARY KEY  (`id`))";
$db->setQuery($query);
$db->query();
*/

if($user->id != 0) {
	$com     = JRequest::getVar('option');
	$task    = JRequest::getVar('task');
	$id      = (int) JRequest::getVar('id');
	$user_id = $db->quote( $user->id );
	$time    = $db->quote( time() );
	$cid     = JRequest::getVar('cid', array());
	$scope   = JRequest::getVar('scope');
	$section = JRequest::getVar('section');
	$alink  = $db->quote( "" );
	$atitle = $db->quote( "" );
	$item   = $db->quote( "" );
	$aid    = 0;

	//CTAYLOR 2010-09-29 -- K2
	$view	= JRequest::getVar('view');
	$k2cat	= JRequest::getVar('category');
	$k2comm = JRequest::getVar('commentID');
	$k2grp	= JRequest::getVar('k2group');

	//CTAYLOR 2010-09-30 --Flexi
	$ctrl	= JRequest::getVar('controller');

	switch($com)
	{
		case 'com_content':
			switch($task)
			{
				case 'article.save':
				case 'article.apply':
					$data = JRequest::getVar('jform', array(), 'post', 'array');
					$filter = JFilterInput::getInstance();
					if($id) {
						$alink  = $db->quote( "index.php?option=com_content&task=article.edit&id=$id" );
						$atitle = $db->quote( 'USER_UPDATED_AN_ARTICLE_LINK' );
						$item   = $db->quote( $filter->clean($data['title']) );
						ualog_save( $alink, $atitle, $item );
					}
					else {
						$id = ualog_predict_id("#__content");
						$alink  = $db->quote( "index.php?option=com_content&task=article.edit&id=$id" );
						$atitle = $db->quote( 'USER_CREATED_AN_ARTICLE_LINK' );
						$item   = $db->quote( $filter->clean($data['title']) );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'articles.delete':
				case 'articles.trash':
				case 'articles.publish':
				case 'articles.unpublish':
				case 'articles.archive':
				case 'articles.unarchive':
					switch($task)
					{
						case 'articles.trash':$atitle = $db->quote( 'USER_TRASHED_AN_ARTICLE_LINK' );break;
						case 'articles.delete':$atitle = $db->quote( 'USER_DELETED_AN_ARTICLE_LINK' );break;
						case 'articles.publish':$atitle = $db->quote( 'USER_PUBLISHED_AN_ARTICLE_LINK' );break;
						case 'articles.unpublish':$atitle = $db->quote( 'USER_UNPUBLISHED_AN_ARTICLE_LINK' );break;
						case 'articles.archive':$atitle = $db->quote( 'USER_ARCHIVED_AN_ARTICLE_LINK' );break;
						case 'articles.unarchive':$atitle = $db->quote( 'USER_UNARCHIVED_AN_ARTICLE_LINK' );break;
					}
					foreach($cid AS $id)
					{
						if($task != 'articles.delete') {
							$alink  = $db->quote( "index.php?option=com_content&task=article.edit&id=$id" );
						}
						$item   = $db->quote(ualog_get_title($id, '#__content') );
						ualog_save( $alink, $atitle, $item );
					}
					break;
			}
			break;

		
		case 'com_categories':
			$data = JRequest::getVar('jform', array(), 'post', 'array');
			$filter = JFilterInput::getInstance();
			switch(JRequest::getVar('extension'))
			{
				case 'com_content':
					switch($task)
					{
						case 'category.save':
						case 'category.apply':
							
							if($id) {
								$alink  = $db->quote( "index.php?option=com_categories&task=category.edit&id=$id&extension=com_content" );
								$atitle = $db->quote( 'USER_UPDATED_A_CONTENT_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__categories");
								$alink  = $db->quote( "index.php?option=com_categories&task=category.edit&id=$id&extension=com_content" );
								$atitle = $db->quote( 'USER_CREATED_A_NEW_CONTENT_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							break;

						case 'categories.remove':
						case 'categories.publish':
						case 'categories.unpublish':
							switch($task)
							{
								case 'categories.remove':$atitle = $db->quote( 'USER_DELETED_A_CONTENT_CATEGORY_LINK' );break;
								case 'categories.publish':$atitle = $db->quote( 'USER_PUBLISHED_A_CONTENT_CATEGORY_LINK' );break;
								case 'categories.unpublish':$atitle = $db->quote( 'USER_UNPUBLISHED_A_CONTENT_CATEGORY_LINK' );break;
							}
							foreach($cid AS $id)
							{
								if($task != 'categories.remove' ) {
									$alink  = $db->quote( "index.php?option=com_categories&&task=category.edit&id=$id&extension=com_content" );
								}
								$item   = $db->quote( ualog_get_title($id, '#__categories') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
					}
					break;

				case 'com_banners':

					switch($task)
					{
						case 'category.save':
						case 'category.apply':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_categories&task=category.edit&id[]=$id&extension=com_banners" );
								$atitle = $db->quote( 'USER_UPDATED_A_BANNER_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__categories");
								$alink  = $db->quote( "index.php?option=com_categories&task=category.edit&id[]=$id&extension=com_banners" );
								$atitle = $db->quote( 'USER_CREATED_A_NEW_BANNER_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							break;

						case 'categories.remove':
						case 'categories.publish':
						case 'categories.unpublish':
							switch($task)
							{
								case 'categories.remove':$atitle = $db->quote( 'USER_DELETED_A_BANNER_CATEGORY_LINK' );break;
								case 'categories.publish':$atitle = $db->quote( 'USER_PUBLISHED_A_BANNER_CATEGORY_LINK' );break;
								case 'categories.unpublish':$atitle = $db->quote( 'USER_UNPUBLISHED_A_BANNER_CATEGORY_LINK' );break;
							}
							foreach($cid AS $id)
							{
								if($task != 'remove' && $task != 'archive') {
									$alink  = $db->quote( "index.php?option=com_categories&extension=com_banner&task=category.edit&id=$id" );
								}
								$item   = $db->quote( ualog_get_title($id, '#__categories') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
					}
					break;

				case 'com_contact_details':
					switch($task)
					{
						case 'category.save':
						case 'category.apply':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_categories&extension=com_contact&task=category.edit&id=$id" );
								$atitle = $db->quote( 'USER_UPDATED_A_CONTACT_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__categories");
								$alink  = $db->quote( "index.php?option=com_categories&extension=com_contact&task=category.edit&id=$id" );
								$atitle = $db->quote( 'USER_CREATED_A_NEW_CONTACT_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							break;

						case 'categories.remove':
						case 'categories.publish':
						case 'categories.unpublish':
							switch($task)
							{
								case 'categories.remove':$atitle = $db->quote( 'USER_DELETED_A_CONTACT_CATEGORY_LINK' );break;
								case 'categories.publish':$atitle = $db->quote( 'USER_PUBLISHED_A_CONTACT_CATEGORY_LINK' );break;
								case 'categories.unpublish':$atitle = $db->quote( 'USER_UNPUBLISHED_A_CONTACT_CATEGORY_LINK' );break;
							}
							foreach($cid AS $id)
							{
								if($task != 'remove' && $task != 'archive') {
									$alink  = $db->quote( "index.php?option=com_categories&extension=com_contact&task=category.edit&id=$id" );
								}
								$item   = $db->quote( ualog_get_title($id, '#__categories') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
					}
					break;

				case 'com_newsfeeds':
					switch($task)
					{
						case 'category.save':
						case 'category.apply':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_categories&extension=com_newsfeeds&task=category.edit&id=$id" );
								$atitle = $db->quote( 'USER_UPDATED_A_FEED_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__categories");
								$alink  = $db->quote( "index.php?option=com_categories&extension=com_newsfeeds&task=category.edit&id=$id" );
								$atitle = $db->quote( 'USER_CREATED_A_NEW_FEED_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							break;

						case 'categories.remove':
						case 'categories.publish':
						case 'categories.unpublish':
							switch($task)
							{
								case 'categories.remove':$atitle = $db->quote( 'USER_DELETED_A_FEED_CATEGORY_LINK' );break;
								case 'categories.publish':$atitle = $db->quote( 'USER_PUBLISHED_A_FEED_CATEGORY_LINK' );break;
								case 'categories.unpublish':$atitle = $db->quote( 'USER_UNPUBLISHED_A_FEED_CATEGORY_LINK' );break;
							}
							foreach($cid AS $id)
							{
								if($task != 'remove' && $task != 'archive') {
									$alink  = $db->quote( "index.php?option=com_categories&extension=com_newsfeeds&task=category.edit&id=$id" );
								}
								$item   = $db->quote( ualog_get_title($id, '#__categories') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
					}
					break;

				case 'com_weblinks':
					switch($task)
					{
						case 'category.save':
						case 'category.apply':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_categories&extension=com_weblinks&task=category.edit&id=$id" );
								$atitle = $db->quote( 'USER_UPDATED_A_WEBLINK_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__categories");
								$alink  = $db->quote( "index.php?option=com_categories&extension=com_weblinks&task=category.edit&id[]=$id" );
								$atitle = $db->quote( 'USER_CREATED_A_NEW_WEBLINK_CATEGORY_LINK' );
								$item   = $db->quote($filter->clean($data['title']) );
								ualog_save( $alink, $atitle, $item );
							}
							break;

						case 'categories.remove':
						case 'categories.publish':
						case 'categories.unpublish':
							switch($task)
							{
								case 'categories.remove':$atitle = $db->quote( 'USER_DELETED_A_WEBLINK_CATEGORY_LINK' );break;
								case 'categories.publish':$atitle = $db->quote( 'USER_PUBLISHED_A_WEBLINK_CATEGORY_LINK' );break;
								case 'categories.unpublish':$atitle = $db->quote( 'USER_UNPUBLISHED_A_WEBLINK_CATEGORY_LINK' );break;
							}
							foreach($cid AS $id)
							{
								if($task != 'remove' && $task != 'archive') {
									$alink  = $db->quote( "index.php?option=com_categories&extension=com_weblinks&task=category.edit&id=$id" );
								}
								$item   = $db->quote( ualog_get_title($id, '#__categories') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
					}
					break;
			}
			break;

		case 'com_menus':
			$data = JRequest::getVar('jform', array(), 'post', 'array');
			$filter = JFilterInput::getInstance();
			switch($task)
			{
				case 'menu.save':
				case 'menu.apply':

						if($id) {
							$alink  = $db->quote( "index.php?option=com_menus&task=menu.edit&id=$id" );
							$atitle = $db->quote( 'USER_UPDATED_A_MENU_LINK' );
							$item   = $db->quote( $filter->clean($data['title']) );
							ualog_save( $alink, $atitle, $item );
						}
						else {
							$alink  = $db->quote( "index.php?option=com_menus&task=menu.edit&id=$id" );
							$atitle = $db->quote( 'USER_CREATED_A_NEW_MENU_LINK' );
							$item   = $db->quote( $filter->clean($data['title']) );
							ualog_save( $alink, $atitle, $item );
						}

					break;

				case 'menus.delete':
					$atitle = $db->quote( 'USER_DELETED_A_MENU_LINK' );
					$item   = $db->quote( ualog_get_title($id, '#__menu_types') );
					ualog_save( $alink, $atitle, $item );
					break;

				case 'items.remove':
					foreach($cid AS $id)
					{
						$atitle = $db->quote( 'USER_DELETED_A_MENU_ITEM_LINK' );
						$item   = $db->quote( ualog_get_title($id, '#__menu', 'name') );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'items.publish':
				case 'items.unpublish':
					foreach($cid AS $id)
					{
						if($task == "items.publish") {
							$atitle = $db->quote( 'USER_PUBLISHED_A_MENU_ITEM_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_UNPUBLISHED_A_MENU_ITEM_LINK' );
						}
							
						$alink  = $db->quote( "index.php?option=com_menus&task=item.edit&id=$cid" );
						$item   = $db->quote( ualog_get_title($id, '#__menu', 'name') );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'items.setdefault':


					$atitle = $db->quote( 'USER_SET_THE_DEFAULT_MENU_ITEM_LINK' );
					$alink  = $db->quote( "index.php?option=com_menus&task=item.edit&id=$cid" );
					$item   = $db->quote( ualog_get_title($cid[0], '#__menu', 'name') );

					ualog_save( $alink, $atitle, $item );
					break;
				
				case 'item.save':
				case 'item.apply':
					if($id) {
						$atitle = $db->quote( 'USER_UPDATED_A_MENU_ITEM_LINK' );
					}
					else {
						$atitle = $db->quote( 'USER_CREATED_A_MENU_ITEM_LINK' );
					}
					$menutype = JRequest::getVar('menutype');
					$alink  = $db->quote( "index.php?option=com_menus&task=item.edit&id=$id" );
					$item = $db->quote( $filter->clean($data['title']) );
					//die($item."-".$alink."-".$atitle);
					ualog_save( $alink, $atitle, $item );
					break;
			}
			break;

		case 'com_modules':

			switch($task)
			{
				case 'module.save':
				case 'module.apply':

					$data = JRequest::getVar('jform', array(), 'post', 'array');
					$filter = JFilterInput::getInstance();
					
					$client = (int) JRequest::getVar('client');
					$module = JRequest::getVar('module');
					if($id) {
						$atitle = $db->quote( 'USER_UPDATED_A_MODULE_LINK' );
					}
					else {
						$id = ualog_predict_id('#__modules');
						$atitle = $db->quote( 'USER_CREATED_A_NEW_MODULE_LINK' );
					}
					$alink  = $db->quote( "index.php?option=com_modules&task=module.edit&id=$id" );
					$item   = $db->quote( $filter->clean($data['title']). ' ('.$data['module'].')' );
					ualog_save( $alink, $atitle, $item );
					break;

				case 'modules.publish':
				case 'modules.unpublish':
					foreach($cid AS $id)
					{
						if($task == "modules.publish") {
							$atitle = $db->quote( 'USER_PUBLISHED_A_MODULE_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_UNPUBLISHED_A_MODULE_LINK' );
						}
						$query = "SELECT title, module FROM #__modules WHERE id = '$id'";
						$db->setQuery($query);
						$result = $db->loadObject();

						$alink  = $db->quote( "index.php?option=com_modules&task=module.edit&id=$id" );
						$item   = $db->quote( $result->title." ($result->module)" );
						ualog_save( $alink, $atitle, $item );
					}
					break;
			}
			break;

		case 'com_users':
			switch($task)
			{
				case 'users.remove':
					foreach($cid AS $id)
					{
						$atitle = $db->quote( 'USER_DELETED_A_USER_ACCOUNT_LINK' );
						$query = "SELECT name, username FROM #__users WHERE id = '$id'";
						$db->setQuery($query);
						$result = $db->loadObject();

						$item   = $db->quote( $result->name." ($result->username)" );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'users.block':
				case 'users.unblock':
					foreach($cid AS $id)
					{
						$query = "SELECT name, username FROM #__users WHERE id = '$id'";
						$db->setQuery($query);
						$result = $db->loadObject();

						if($task == "users.unblock") {
							$atitle = $db->quote( 'USER_UNBLOCKED_A_USER_ACCOUNT_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_BLOCKED_A_USER_ACCOUNT_LINK' );
						}
						$item  = $db->quote( $result->name." ($result->username)" );
						$alink = $db->quote( "index.php?option=com_users&task=user.edit&id=$id" );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'user.save':
				case 'user.apply':
					$data = JRequest::getVar('jform', array(), 'post', 'array');
					$filter = JFilterInput::getInstance();
					$name = $filter->clean($data['name']);
					$uname= $filter->clean($data['username']);
					
					if($id) {
						$atitle = $db->quote( 'USER_UPDATED_A_USER_ACCOUNT_LINK' );
					}
					else {
						$id = ualog_predict_id('#__users');
						$atitle = $db->quote( 'USER_CREATED_A_NEW_USER_ACCOUNT_LINK' );
					}
					$alink = $db->quote( "index.php?option=com_users&task=user.edit&id=$id" );
					$item  = $db->quote( $name." ($uname)" );
					ualog_save( $alink, $atitle, $item );
					break;
			}
			break;

		case 'com_config':
			switch($task)
			{
				case 'application.save':
				case 'application.apply':
					$atitle = $db->quote( 'USER_UPDATED_THE_GLOBAL_CONFIGURATION' );
					$item  = $db->quote( "none" );
					ualog_save( $alink, $atitle, $item );
					break;
			}
			break;

		case 'com_plugins':
			switch($task)
			{
				
				case 'plugin.save':
				case 'plugin.apply':
					$id = JRequest::getInt('extension_id');
					$data = JRequest::getVar('jform', array(), 'post', 'array');
					$filter = JFilterInput::getInstance();
					$client = JRequest::getVar('client');
					$atitle = $db->quote( 'USER_UPDATED_A_PLUGIN_LINK' );
					$alink  = $db->quote( "index.php?option=com_plugins&task=plugin.edit&extension_id=$id" );
					$item   = $db->quote( $filter->clean($data['name']) );
					ualog_save( $alink, $atitle, $item );
					break;

				case 'plugins.publish':
				case 'plugins.unpublish':
					$client = JRequest::getVar('client');
					foreach($cid AS $id)
					{
						if($task == "plugins.publish") {
							$atitle = $db->quote( 'USER_PUBLISHED_A_PLUGIN_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_UNPUBLISHED_A_PLUGIN_LINK' );
						}
						$alink  = $db->quote( "index.php?option=com_plugins&task=plugin.edit&extension_id=$id" );
						$item   = $db->quote( ualog_get_title($id, "#__extensions", "name", 'extension_id') );
						ualog_save( $alink, $atitle, $item );
					}
					break;
			}
			break;

		case 'com_templates':
			switch($task)
			{
				case 'style.save':
				case 'style.apply':
					$id = JRequest::getVar('id');
					$client = JRequest::getVar('client');
					$atitle = $db->quote( 'USER_UPDATED_THE_PARAMETERS_OF_A_TEMPLATE_LINK' );
					$alink  = $db->quote( "index.php?option=com_templates&task=style.edit&id=$id" );
					$item   = $db->quote( $id );
					ualog_save( $alink, $atitle, $item );
					break;
			}
			break;

		case 'com_checkin':
			$atitle = $db->quote( 'USER_CHECKED_IN_ALL_ITEMS' );
			$item   = $db->quote( "none" );
			ualog_save( $alink, $atitle, $item );
			break;

		case 'com_cache':
			switch($task)
			{
				case 'delete':
					$atitle = $db->quote( 'USER_CLEANED_PURGED_THE_CACHE' );
					$item   = $db->quote( "none" );
					ualog_save( $alink, $atitle, $item );
					break;
			}
			break;

		case 'com_messages':
			switch($task)
			{
				case 'message.save':
					$user_id_to = (int) JRequest::getVar('user_id_to');
					$query = "SELECT name, username FROM #__users WHERE id = '$user_id_to'";
					$db->setQuery($query);
					$result = $db->loadObject();

					$atitle = $db->quote( 'USER_HAS_SENT_A_PRIVATE_MESSAGE_TO_LINK' );
					$item   = $db->quote( $result->name." ($result->username)" );
					$alink  = $db->quote( "index.php?option=com_users&view=user&task=edit&cid[]=$user_id_to" );
					ualog_save( $alink, $atitle, $item );
					break;

				case 'messages.remove':
					$atitle = $db->quote( 'USER_DELETED_PRIVATE_MESSAGES' );
					$item   = $db->quote( "none" );
					ualog_save( $alink, $atitle, $item );
					break;
			}
			break;

		case 'com_banners':
			switch($task)
			{
				case 'banner.save':
				case 'banner.apply':
					$c = JRequest::getVar('c');

					if($c) {
						if($id) {
							$atitle = $db->quote( 'USER_UPDATED_A_BANNER_CLIENT_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_CREATED_A_BANNER_CLIENT_LINK' );
							$id = ualog_predict_id('#__bannerclient');
						}
						$item = $db->quote( JRequest::getVar('name') );
						$alink  = $db->quote( "index.php?option=com_banners&task=banner.edit&id=$id" );
						ualog_save( $alink, $atitle, $item );
					}
					else {
						if($id) {
							$atitle = $db->quote( 'USER_UPDATED_A_BANNER_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_CREATED_A_BANNER_LINK' );
							$id = ualog_predict_id('#__banner');
						}
						$item = $db->quote( JRequest::getVar('name') );
						$alink  = $db->quote( "index.php?option=com_banners&task=banner.edit&id=$id" );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'banners.delete':
					$c = JRequest::getVar('c');

					if($c) {
						foreach($cid AS $id)
						{
							$item = $db->quote( ualog_get_title($id, '#__bannerclient', 'name') );
							$atitle = $db->quote( 'USER_DELETED_A_BANNER_CLIENT_LINK' );
							ualog_save( $alink, $atitle, $item );
						}
					}
					else {
						foreach($cid AS $id)
						{
							$item = $db->quote( ualog_get_title($id, '#__banner', 'name') );
							$atitle = $db->quote( 'USER_DELETED_A_BANNER_LINK' );
							ualog_save( $alink, $atitle, $item );
						}
					}
					break;

				case 'banners.publish':
				case 'banners.unpublish':
					foreach($cid AS $id)
					{
						if($task == 'banners.publish') {
							$atitle = $db->quote( 'USER_PUBLISHED_A_BANNER_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_UNPUBLISHED_A_BANNER_LINK' );
						}
						$alink  = $db->quote( "index.php?option=com_banners&task=banner.edit&id=$id" );
						$item = $db->quote( ualog_get_title($id, '#__banner', 'name') );
						ualog_save( $alink, $atitle, $item );
					}
					break;
			}
			break;

		case 'com_contact':
			switch($task)
			{
				case 'contact.save':
				case 'contact.apply':
					if($id) {
						$atitle = $db->quote( 'USER_UPDATED_A_CONTACT_LINK' );
					}
					else {
						$atitle = $db->quote( 'USER_CREATED_A_NEW_CONTACT_LINK' );
						$id = ualog_predict_id('#__contact_details');
					}
					$item = $db->quote( JRequest::getVar('name') );
					$alink  = $db->quote( "index.php?option=com_contact&task=contact.edit&id=$id" );
					ualog_save( $alink, $atitle, $item );
					break;

				case 'contacts.publish':
				case 'contacts.unpublish':
					foreach($cid AS $id)
					{
						if($task == 'contacts.publish') {
							$atitle = $db->quote( 'USER_PUBLISHED_A_CONTACT_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_UNPUBLISHED_A_CONTACT_LINK' );
						}
						$alink  = $db->quote( "index.php?option=com_contact&task=contact.edit&id=$id" );
						$item = $db->quote( ualog_get_title($id, '#__contact_details', 'name') );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'contacts.trash':
					foreach($cid AS $id)
					{
						$item = $db->quote( ualog_get_title($id, '#__contact_details', 'name') );
						$atitle = $db->quote( 'USER_DELETED_A_CONTACT_LINK' );
						ualog_save( $alink, $atitle, $item );
					}
					break;
			}
			break;

		case 'com_newsfeed':
			switch($task)
			{
				case 'newsfeed.save':
				case 'newsfeed.apply':
					if($id) {
						$atitle = $db->quote( 'USER_UPDATED_A_NEWS_FEED_LINK' );
					}
					else {
						$atitle = $db->quote( 'USER_CREATED_A_NEWS_FEED_LINK' );
						$id = ualog_predict_id('#__newsfeeds');
					}
					$item = $db->quote( JRequest::getVar('name') );
					$alink  = $db->quote( "index.php?option=com_newsfeeds&task=newsfeed.edit&id=$id" );
					ualog_save( $alink, $atitle, $item );
					break;

				case 'newsfeeds.publish':
				case 'newsfeeds.unpublish':
					foreach($cid AS $id)
					{
						if($task == 'newsfeeds.publish') {
							$atitle = $db->quote( 'USER_PUBLISHED_A_NEWS_FEED_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_UNPUBLISHED_A_NEWS_FEED_LINK' );
						}
						$alink  = $db->quote( "index.php?option=com_newsfeeds&task=newsfeed.edit&id=$id" );
						$item = $db->quote( ualog_get_title($id, '#__newsfeeds', 'name') );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'newsfeeds.trash':
					foreach($cid AS $id)
					{
						$item = $db->quote( ualog_get_title($id, '#__newsfeeds', 'name') );
						$atitle = $db->quote( 'USER_DELETED_A_NEWS_FEED_LINK' );
						ualog_save( $alink, $atitle, $item );
					}
					break;
			}
			break;

		case 'com_weblinks':
			switch($task)
			{
				case 'weblink.save':
				case 'weblink.apply':
					if($id) {
						$atitle = $db->quote( 'USER_UPDATED_A_WEBLINK_LINK' );
					}
					else {
						$atitle = $db->quote( 'USER_CREATED_A_WEBLINK_LINK' );
						$id = ualog_predict_id('#__polls');
					}
					$item = $db->quote( JRequest::getVar('title') );
					$alink  = $db->quote( "index.php?option=com_weblinks&task=weblink.edit&id=$id" );
					ualog_save( $alink, $atitle, $item );
					break;

				case 'weblinks.publish':
				case 'weblinks.unpublish':
					foreach($cid AS $id)
					{
						if($task == 'weblinks.publish') {
							$atitle = $db->quote( 'USER_PUBLISHED_A_WEBLINK_LINK' );
						}
						else {
							$atitle = $db->quote( 'USER_UNPUBLISHED_A_WEBLINK_LINK' );
						}
						$alink  = $db->quote( "index.php?option=com_weblinks&task=weblink.edit&id=$id" );
						$item = $db->quote( ualog_get_title($id, '#__weblinks', 'title') );
						ualog_save( $alink, $atitle, $item );
					}
					break;

				case 'weblinks.trash':
					foreach($cid AS $id)
					{
						$item = $db->quote( ualog_get_title($id, '#__weblinks', 'title') );
						$atitle = $db->quote( 'USER_DELETED_A_WEBLINK_LINK' );
						ualog_save( $alink, $atitle, $item );
					}
					break;
			}
			break;

		case 'com_login':
			switch($task)
			{
				case 'login':
					$item   = $db->quote( "" );
					$alink  = $db->quote( "" );
					$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_LOGGED_IN' );
					ualog_save( $alink, $atitle, $item );
					break;

				case 'logout':
					$item  = $db->quote( "" );
					$alink = $db->quote( "" );
					$atitle = $db->quote( 'USER_LOGGED_OUT' );
					ualog_save( $alink, $atitle, $item );
					break;
			}
			break;

			//K2

		case 'com_k2':
			switch($view)
			{
				case 'item':
				case 'items':
					switch($task)
					{
						case 'save':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_k2&view=item&cid=$id" );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UPDATED_A_K2_ITEM_LINK' );
								$item   = $db->quote( JRequest::getVar('title') );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__k2_items");
								$alink  = $db->quote( "index.php?option=com_k2&view=item&cid=$id" );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_CREATED_A_K2_ITEM_LINK' );
								$item   = $db->quote( JRequest::getVar('title') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
						case 'trash':
						case 'remove':
						case 'publish':
						case 'unpublish':
						case 'featured':
						case 'saveMove':
							switch($task)
							{
								case 'trash':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_TRASHED_A_K2_ITEM_LINK' );break;
								case 'remove':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_DELETED_A_K2_ITEM_LINK' );break;
								case 'publish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_PUBLISHED_A_K2_ITEM_LINK' );break;
								case 'unpublish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UNPUBLISHED_A_K2_ITEM_LINK' );break;
								case 'featured':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_CHANGED_THE_FEATURE_STATUS_OF_A_K2_ITEM_LINK' );break;
								case 'saveMove':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_MOVED_A_K2_ITEM_LINK' );break;
							}

							foreach($cid AS $id)
							{
								$item = $db->quote( ualog_get_title($id, '#__k2_items', 'title') );
								$alink = ($task != 'remove') ? $db->quote( "index.php?option=com_k2&view=items" ) : 0;
								ualog_save( $alink, $atitle, $item );
							}
							break;
					}
					break;
				case 'category':
				case 'categories':
					switch($task)
					{
						case 'save':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_k2&view=category&cid=$id" );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UPDATED_A_K2_CATEGORY_LINK' );
								$item   = $db->quote( JRequest::getVar('name') );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__k2_categories");
								$alink  = $db->quote( "index.php?option=com_k2&view=category&cid=$id" );
								$atitle = $db->quote( "%s created a k2 category: %s" );
								$item   = $db->quote( JRequest::getVar('name') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
						case 'trash':
						case 'remove':
						case 'publish':
						case 'unpublish':
						case 'saveMove':
							switch($task)
							{
								case 'trash':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_TRASHED_A_K2_CATEGORY_LINK' );break;
								case 'remove':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_DELETED_A_K2_CATEGORY_LINK' );break;
								case 'publish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_PUBLISHED_A_K2_CATEGORY_LINK' );break;
								case 'unpublish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UNPUBLISHED_A_K2_CATEGORY_LINK' );break;
								case 'saveMove':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_MOVED_A_K2_CATEGORY_LINK' );break;
							}
							foreach($cid AS $id)
							{
								$item = $db->quote( ualog_get_title($id, '#__k2_categories', 'name') );
								$alink = ($task != 'remove') ? $db->quote( "index.php?option=com_k2&view=categories" ) : 0;
								ualog_save( $alink, $atitle, $item );
							}
					}
					break;
				case 'tag':
				case 'tags':
					switch($task)
					{
						case 'save':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_k2&view=tag&cid=$id" );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UPDATED_A_K2_TAG_LINK' );
								$item   = $db->quote( JRequest::getVar('name') );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__k2_tags");
								$alink  = $db->quote( "index.php?option=com_k2&view=tag&cid=$id" );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_CREATED_A_K2_TAG_LINK' );
								$item   = $db->quote( JRequest::getVar('name') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
						case 'trash':
						case 'remove':
						case 'publish':
						case 'unpublish':
						case 'saveMove':
							switch($task)
							{
								case 'trash':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_TRASHED_A_K2_TAG_LINK' );break;
								case 'remove':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_DELETED_A_K2_TAG_LINK' );break;
								case 'publish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_PUBLISHED_A_K2_TAG_LINK' );break;
								case 'unpublish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UNPUBLISHED_A_K2_TAG_LINK' );break;
							}
							foreach($cid AS $id)
							{
								$item = $db->quote( ualog_get_title($id, '#__k2_tags', 'name') );
								$alink = ($task != 'remove') ? $db->quote( "index.php?option=com_k2&view=tags" ) : 0;
								ualog_save( $alink, $atitle, $item );
							}
							break;
					}
				case 'comments':
					switch($task)
					{
						//case 'save':
						//case 'remove':
						case 'publish':
						case 'unpublish':
						case 'deleteUnpublished':
							switch($task)
							{
								case 'publish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_PUBLISHED_A_K2_COMMENT_LINK' );break;
								case 'unpublish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UNPUBLISHED_A_K2_COMMENT_LINK' );break;
								case 'deleteUnpublished':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_DELETED_ALL_UNPUBLISHED_COMMENTS_LINK');break;
							}
							foreach($cid AS $id)
							{
								$item = $db->quote( ualog_get_title($id, '#__k2_comments', 'commentText') );
								$item = (strlen($item)>30) ? substr($item,0,30)."...'" : $item;
								$alink = $db->quote( "index.php?option=com_k2&view=comments" );
								ualog_save( $alink, $atitle, $item );
							}
							break;
					}
				case 'users':
					break;
				case 'userGroup':
					break;
				case 'userGroups':
					break;
				case 'extraField':
					break;
				case 'extraFields':
					break;
				case 'extraFieldsGroup':
					break;
				case 'extraFieldsGroups':
					break;
			}
			break;

			//FlexiContent
			
		case 'com_flexicontent':

			switch($view)
			{
				case 'category':
				case 'categories':
					switch($task)
					{
						case 'save':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_flexicontent&view=category&cid=$id" );

								$item   = $db->quote( JRequest::getVar('title') );
								$parent_id = JRequest::getVar('parent_id');
								if($parent_id) {
									$query = 'SELECT parent_id FROM #__categories WHERE id="'.$id.'"';
									$db->setQuery($query);
									$parent_id_old = $db->loadResult($query);
									if($parent_id_old!=$parent_id) {
										$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_MOVED_A_FLEXICONTENT_CATEGORY_LINK' );
										ualog_save( $alink, $atitle, $item );
									}

								}
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UPDATED_A_FLEXICONTENT_CATEGORY_LINK' );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__categories");
								$alink  = $db->quote( "index.php?option=com_flexicontent&view=category&cid=$id" );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_CREATED_A_FLEXICONTENT_CATEGORY_LINK' );
								$item   = $db->quote( JRequest::getVar('title') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
						case 'remove':
						case 'publish':
						case 'unpublish':
						case 'saveMove':
							switch($task)
							{
								case 'remove':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_DELETED_A_FLEXICONTENT_CATEGORY_LINK' );break;
								case 'publish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_PUBLISHED_A_FLEXICONTENT_CATEGORY_LINK' );break;
								case 'unpublish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UNPUBLISHED_A_FLEXICONTENT_CATEGORY_LINK' );break;
								case 'saveMove':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_MOVED_A_FLEXICONTENT_CATEGORY_LINK' );break;
							}
							foreach($cid AS $id)
							{
								$item = $db->quote( ualog_get_title($id, '#__categories', 'title') );
								$alink = ($task != 'remove') ? $db->quote( "index.php?option=com_flexicontent&view=categories" ) : 0;
								ualog_save( $alink, $atitle, $item );
							}
					}
					break;

				case 'item':
				case 'items':
					switch($task)
					{
						case 'save':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_flexicontent&controller=items&task=edit&cid[]=$id" );
								$item   = $db->quote( JRequest::getVar('title') );
								$parent_id = JRequest::getVar('parent_id');
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UPDATED_A_FLEXICONTENT_ITEM_LINK' );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__content");
								$alink  = $db->quote( "index.php?option=com_flexicontent&controller=items&task=edit&cid[]=$id" );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_CREATED_A_NEW_FLEXICONTENT_DRAFT_LINK' );
								$item   = $db->quote( JRequest::getVar('title') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
						case 'copymove':
							$method = JRequest::getVar('method');
							$copynr = JRequest::getVar('copynr');
							$prefix = JRequest::getVar('prefix');
							$suffix = JRequest::getVar('suffix');
							switch($method)
							{
								case '1':
								case '3':
									switch($method)
									{
										case '1':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_CREATED_A_COPY_FLEXICONTENT_ITEM_LINK');break;
										case '3':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_CREATED_A_COPY_AND_MOVED_FLEXICONTENT_ITEM_LINK');break;
									}
									foreach($cid as $id) {
										for($i = 1; $i<=$copynr; $i++) {
											$idnew = ualog_predict_id("#__content");
											$alink  = $db->quote( "index.php?option=com_flexicontent&controller=items&task=edit&cid[]=$idnew" );
											$item 	= $db->quote( $prefix.ualog_get_title($id, '#__content', 'title').$suffix );
											ualog_save( $alink, $atitle, $item );
										}
									}
									break;
								case '2':
									$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_MOVED_A_FLEXICONTENT_ITEM_LINK');
									foreach($cid as $id) {
										$link = $db->quote( "index.php?option=com_flexicontent&controller=items&task=edit&cid[]=$id" );
										$item = $db->quote( ualog_get_title($id, '#__content', 'title') );
										ualog_save( $alink, $atitle, $item );
									}
									break;
							}
						case 'remove':
							$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_DELETED_A_FLEXICONTENT_ITEM_LINK');
							foreach($cid as $id) {
								$link = $db->quote( "index.php?option=com_flexicontent&controller=items" );
								$item = $db->quote( ualog_get_title($id, '#__content', 'title') );
								ualog_save( $alink, $atitle, $item );
							}
							break;

					}
					break;

				case 'tags':
				case 'tag':

					switch($task)
					{
							
						case 'save':
							if($id) {
								$alink  = $db->quote( "index.php?option=com_flexicontent&controller=tags&task=edit&cid[]=$id" );
								$item   = $db->quote( JRequest::getVar('name') );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UPDATED_A_FLEXICONTENT_ITEM_LINK' );
								ualog_save( $alink, $atitle, $item );
							}
							else {
								$id = ualog_predict_id("#__flexicontent_tags");
								$alink  = $db->quote( "index.php?option=com_flexicontent&controller=tags&task=edit&cid[]=$id" );
								$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_CREATED_A_FLEXICONTENT_TAG_LINK' );
								$item   = $db->quote( JRequest::getVar('name') );
								ualog_save( $alink, $atitle, $item );
							}
							break;
								
						case 'publish':
						case 'unpublish':
						case 'remove':
								
							switch($task)
							{
								case 'remove':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_DELETED_A_FLEXICONTENT_TAG_LINK' );break;
								case 'publish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_PUBLISHED_A_FLEXICONTENT_TAG_LINK' );break;
								case 'unpublish':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_UNPUBLISHED_A_FLEXICONTENT_ITEM_LINK' );break;
							}
								
							foreach($cid AS $id)
							{
								$item = $db->quote( ualog_get_title($id, '#__flexicontent_tags', 'name') );
								$alink = ($task !== 'remove') ? $db->quote( "index.php?option=com_flexicontent&view=tags" ) : 0;
								ualog_save( $alink, $atitle, $item );
							}
								
							break;
								
						case 'import':
							$taglist = explode("\n",JRequest::getVar('taglist'));
							$count = count($taglist);
							$atitle = $db->quote( "%s imported $count flexicontent tags: %s" );
							$item = $db->quote("View tags");
							$alink = $db->quote( "index.php?option=com_flexicontent&view=tags" );
							ualog_save( $alink, $atitle, $item );
							
							break;
					}
						
					break;

			}

			switch ($ctrl)
			{
				case 'items':
					switch($task)
					{
						case 'setitemstate':
							$state = JRequest::getVar('state');
							switch($state)
							{
								case '1':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_PUBLISHED_A_FLEXICONTENT_ITEM_LINK' );break;
								case '0':$atitle = $db->quote( "MOD_ACTIVITYLOG_USER_UNPUBLISHED_A_FLEXICONTENT_ITEM_LINK" );break;
								case '-1':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_ARCHIVED_A_FLEXICONTENT_ITEM_LINK' );break;
								case '-3':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_SET_A_FLEXICONTENT_ITEM_WAITING_FOR_APPROVAL_LINK' );break;
								case '-4':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_SET_A_FLEXICONTENT_ITEM_TO_DRAFT_LINK' );break;
								case '-5':$atitle = $db->quote( 'MOD_ACTIVITYLOG_USER_SET_A_FLEXICONTENT_ITEM_IN_PROGRESS_LINK' );break;

							}
							$item = $db->quote( ualog_get_title($id, '#__content', 'title') );
							$alink = $db->quote( "index.php?option=com_flexicontent&view=items&task=edit&cid[]=$id" );
							ualog_save( $alink, $atitle, $item );
							
							break;

					}
					
					break;
					
			}

	}
}
?>