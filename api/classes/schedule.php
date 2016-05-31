<?php

class Schedule {

	public static $insertRequiredFields = array('title', 'program_id', 'episode', 'start', 'duration', 'state');
	public static $insertOptionalFields = array('uuid', 'subtitle');

	public static function getItems($app, $date = null) {
		$date = self::prepareDate($date);
		$query = $app->_db->getQuery(true);
		$query->select('s.id, s.state, s.revision, s.title, s.subtitle, s.program_id, s.episode, s.start, s.created, s.duration, u.name as created_by, u.id as owner_id, p.alias as program_alias, p.image as program_image, IF (s.episode <> 0, e.title, "") as episode_title, IF (s.episode <> 0, e.alias, "") as episode_alias, IF (s.episode <> 0, e.introtext, "") as introtext')
				->from($app->_db->quoteName('#__schedules') . ' s')
				->join('LEFT', $app->_db->quoteName('#__k2_categories') . 'AS p ON s.program_id = p.id')
				->join('LEFT', $app->_db->quoteName('#__k2_items') . 'AS e on s.episode = e.id')
				->join('LEFT', $app->_db->quoteName('#__users') . 'AS u on s.created_by = u.id')
				->where('date(s.' . $app->_db->quoteName('start') . ') = ' . $app->_db->quote($date))
//				->where('e.catid = p.id')
				->order('s.start ASC');
//		echo str_replace("#__", "dtv_", $query);
		$app->_db->setQuery($query);
		$app->_db->execute();
		$items = self::findCurrent(self::checkAccess($app->_db->loadObjectList()));
		self::render($app, $items, 200, 'items');
	}

	public static function getItem($app, $id) {
		$query = $app->_db->getQuery(true);
		$query->select('s.id, s.state, s.revision, s.title, s.subtitle, s.program_id, s.episode, s.start, s.created, s.duration, u.name as created_by, u.id as owner_id, p.alias as program_alias, p.image as program_image, IF (s.episode <> 0, e.title, "") as episode_title, IF (s.episode <> 0, e.alias, "") as episode_alias, IF (s.episode <> 0, e.introtext, "") as introtext')
				->from($app->_db->quoteName('#__schedules') . ' s')
				->join('LEFT', $app->_db->quoteName('#__k2_categories') . 'AS p ON s.program_id = p.id')
				->join('LEFT', $app->_db->quoteName('#__k2_items') . 'AS e on s.episode = e.id')
				->join('LEFT', $app->_db->quoteName('#__users') . 'AS u on s.created_by = u.id')
				->where('s.id = ' . $app->_db->quote($id));
		$app->_db->setQuery($query);
		$app->_db->execute();
		return $app->_db->loadObject();
//		$items = self::findCurrent(self::checkAccess($app->_db->loadObjectList()));
	}

	public static function findCurrent($items) {
		$time = time();
		foreach ($items as $item) {
			$item->start_time = $start = strtotime($item->start);

			sscanf($item->duration, "%d:%d:%d", $hours, $minutes, $seconds);
			$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

			$item->end_time = $end = strtotime($item->start) + $time_seconds;
			$item->current = ($time > $start && $time < $end) ? true : false;
		}
		return $items;
	}

	static function checkAccess($items) {
		if (empty($items))
			return [];
		$user = JFactory::getUser();
		foreach ($items as $item) {
			if (!count($user->getAuthorisedCategories('com_content', 'core.create')) > 0) {
				$item->revision = "";
				$item->created = "";
				$item->created_by = "";
			}
		}
		return $items;
	}

	function add($app, $date) {
		$date = self::convertDate($date);
		$user = JFactory::getUser();
		$o = new stdClass();
		foreach (self::$insertRequiredFields as $key => $field) {
			$value = $app->request->post($field);
			$o->{$field} = $value;
			if ($value == null)
				self::render($app, 'Field (' . $field . ') cannot be empty.', 500);
		}
		foreach (self::$insertOptionalFields as $key => $field) {
			$value = $app->request->post($field);
			$o->{$field} = $value;
		}

		$o->created = date('Y-m-d H:i:s', time());
		$o->created_by = $user->id;
		$o->modified_by = $user->id;
		$o->kind = ($o->episode) ? 'episode' : 'program';
		$o->modified_by = $user->id;
		$o->start = $date . ' ' . $o->start;

		$results = $app->_db->insertObject('#__schedules', $o);
		$id = $app->_db->insertid();
		$backup = self::getBackUp($app, $id, $o);

		$app->render(200, array('db' => $results, 'item' => $o, 'msg' => 'Record inserted!', 'backup' => $backup));
	}

	function delete($app, $id) {
		// Select item
		$item = self::getItem($app, $id);
		if (!$item) {
			$app->render(404, array('msg' => 'Record not found', 'error' => true));
		}
		// Get a backup width new state (-1)
		$item->state = '-1';
		$item->revision = $item->revision + 1;
		$item->modified = date('Y-m-d H:i:s', time());
		$item->modified_by = JFactory::getUser()->id;
		
		$item->uid = '';
		$item->subtitle = $item->episode_title;
		$item->created_by = $item->owner_id;
		unset($item->owner_id);
		unset($item->episode_title);
		unset($item->episode_alias);
		unset($item->introtext);
		unset($item->program_alias);
		unset($item->program_image);
		
//		var_dump($item); die();
		$backup = self::getBackUp($app, $id, $item);
		// Delete item
		$query = $app->_db->getQuery(true);
		$query->delete($app->_db->quoteName('#__schedules'))
				->where('id = ' . $id);
		$app->_db->setQuery($query);
		$result = $app->_db->execute();
		$app->render(200, array('db' => $result, 'msg' => 'Record deleted!', 'backup' => $backup, 'item' => $item));
	}

	static function getBackUp($app, $id, $data) {
		unset($data->id);
		$data->sid = $id;
		$results = $app->_db->insertObject('#__schedules_versions', $data);
		return $results;
	}

	static function render($app, $items, $code = 200, $title = 'msg') {
		$app->render($code, array($title => $items,));
	}

	static function convertDate($jalali) {
		new jDateTime(false);
		list($j_y, $j_m, $j_d) = explode('-', $jalali);
		$gregorian = jDateTime::toGregorian($j_y, $j_m, $j_d);
		return implode('-', $gregorian);
	}

	static function prepareDate($date) {
		if (!$date)
			return date('Y-m-d', time());
		list($j_y, $j_m, $j_d) = explode('-', $date);
		if ($j_y < 2000) {
			$gregorian = jDateTime::toGregorian($j_y, $j_m, $j_d);
			return implode('-', $gregorian);
		}
		return $date;
	}

}
