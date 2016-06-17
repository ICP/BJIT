<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_syndicate
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class ModScheduleHelper {

	public static function getItems(&$params, $date = null) {

		$date = ($date) ? $date : date('Y-m-d', time());

		// Load and prepare items
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('s.id, s.state, s.revision, s.title, s.subtitle, s.program_id, s.episode, s.start, s.created, s.duration, u.name as created_by, u.id as owner_id, p.alias as program_alias, p.image as program_image, IF (s.episode <> 0, e.title, "") as episode_title, IF (s.episode <> 0, e.alias, "") as episode_alias, IF (s.episode <> 0, e.introtext, "") as introtext')
				->from($db->quoteName('#__schedules') . ' s')
				->join('LEFT', $db->quoteName('#__k2_categories') . 'AS p ON s.program_id = p.id')
				->join('LEFT', $db->quoteName('#__k2_items') . 'AS e on s.episode = e.id')
				->join('LEFT', $db->quoteName('#__users') . 'AS u on s.created_by = u.id')
				->where('date(s.' . $db->quoteName('start') . ') = ' . $db->quote($date))
//				->where('e.catid = p.id')
				->order('s.start ASC');
		$db->setQuery($query);
		$db->execute();
		$items = self::findCurrent(self::prepareItems($db->loadObjectList(), $params));
		return $items;
	}

	public static function prepareItems($items, $params) {
		if (!count($items))
			return [];
		foreach ($items as $key => $item) {
			$item->link = '';
			$item->image = '';
			$item->thumb = '';
			$item->start_small = date('H:i', strtotime($item->start));
			if ($item->episode != 0 || $item->program_id) {
				if ($item->program_id) {
					$item->link = Route::category($item->program_id, $item->program_alias);
					$item->image = JURI::root() . 'media/k2/categories/' . $item->program_id . '.jpg';
					$item->thumb = JURI::root() . 'media/k2/categories/' . $item->program_id . '.jpg';
				}
				if ($item->episode != 0) {
					$item->link = Route::item($item->episode, $item->episode_alias, $item->program_id, $item->program_alias);
					$item->image = Route::image($item->episode);
					$item->thumb = Route::image($item->episode, true);
				}
			} else {
				if ($params->get('width_data_only', 0) == 1) {
					unset($items[$key]);
				}
			}
		}
		return $items;
	}

	public static function fillItems($items, $params) {
		$items_count = count($items);
		$items = array_values($items);

		$requested_count = $params->get('count');
		$bias = (int) $requested_count - $items_count;
		for ($i = 0; $i < count($items); $i++) {
			$ids[] = $items[$i]->id;
		}

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('i.id as episode, i.published, i.catid as program_id, i.created, i.alias as episode_alias, c.alias as program_alias, i.title as title, i.title as episode_title, i.introtext')
				->from($db->quoteName('#__k2_items') . ' i')
				->where('i.catid in (select cc.id from #__k2_categories cc where cc.parent = 2)', ' AND')
				->where('i.published = 1 AND c.published = 1', ' AND');
		if (isset($ids) && count($ids)) {
			$query->where('i.id not in (' . rtrim(implode(',', $ids), ',') . ')');
		}
		$query->join('LEFT', $db->quoteName('#__k2_categories') . 'AS c ON i.catid = c.id')
				->join('LEFT', $db->quoteName('#__users') . 'AS u on i.created_by = u.id')
				->order('i.created DESC');
		$db->setQuery($query, 0, $bias);
		$db->execute();
		$new_items = $db->loadObjectList();
		if (count($new_items)) {
			foreach ($new_items as $item) {
				$item->link = Route::item($item->episode, $item->episode_alias, $item->program_id, $item->program_alias);
				$item->image = Route::image($item->episode);
				$item->thumb = Route::image($item->episode, true);
			}
		}

		return array_merge($items, $new_items);
	}

	public static function findCurrent($items) {
		$time = time();
		foreach ($items as $key => $item) {
			sscanf($item->duration, "%d:%d:%d", $hours, $minutes, $seconds);
			$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
			$end = strtotime($item->start) + $time_seconds;
			if ($time > $end) {
				unset($items[$key]);
			}
		}
		return $items;
	}

}

if (!class_exists('Route')) {

	abstract class Route {

		public static function video($path) {
			$base = VIDEO_BASE;
			$url = str_replace('$old|', '', str_replace('{/mp4}', '', str_replace('{mp4}', '', $path)));
			return $base . $url;
		}

		public static function image($id, $thumb = false) {
			$path = JURI::root() . 'media/k2/items/cache/' . md5('Image' . $id);
			$path .= $thumb ? '_XS.jpg' : '_S.jpg';
			return str_replace('/api', '', $path);
		}

		public static function item($id, $alias, $catid, $catalias) {
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($id . ':' . urlencode($alias), $catid . ':' . urlencode($catalias))));
			return str_replace('/api', '', $link);
		}

		public static function category($id, $alias) {
			$link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($id . ':' . urlencode($alias))));
			return str_replace('/api', '', $link);
		}

	}

}