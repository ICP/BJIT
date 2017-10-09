<?php

abstract class Subscription {

	public static function addContact($app, $type) {
		$o = new stdClass();
		$o->created = date('Y-m-d H:i:s', time());
		$o->id = '';
		$o->email = $app->request->post('email');
		$o->name = $app->request->post('name');
		$o->type = isset($type) ? $type : 'newsletter';
		
		if (self::checkDuplicate($app, $o, $o->type)) {
			$app->render(400, array('msg' => 'Subscribed before'));
				return false;
		}
		
		if ($o->email && filter_var($o->email, FILTER_VALIDATE_EMAIL)) {
			
			$results = $app->_db->insertObject('#__subscriptions', $o);
			$app->render(200, array('db' => $results, 'item' => $o, 'msg' => 'Success'));
		} else {
			$app->render(400, array('msg' => 'Bad request'));
		}
	}
	
	public static function checkDuplicate($app, $data, $type) {
		$query = $app->_db->getQuery(true);
			$query->select('s.email')
					->from($app->_db->quoteName('#__subscriptions') . ' AS s')
					->where($app->_db->quoteName('s.email') . ' = ' . $app->_db->quote($data->email), ' AND')
					->where($app->_db->quoteName('s.type') . ' = ' . $app->_db->quote($type));
//			echo $query; die;
			$app->_db->setQuery($query, 0, 1);
			$app->_db->execute();
			$items = $app->_db->loadObject();
			
			// Record exists
			if (count($items)) {
				return true;
			}
			return false;
	}

	public static function render($app, $items, $type = 'items') {
		$app->render(200, array($type => $items,));
		return true;
	}

}
