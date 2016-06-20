<?php

abstract class Comments {

	public static function getItemComments($app, $id = null) {
		$o = 0;
		$l = 50;
		$offset = $app->request->get('offset', null);
		if (!empty($offset)) {
			list($o, $l) = explode(',', $offset);
		}
		$query = $app->_db->getQuery(true);
		$query->select('c.id, c.userName, c.commentDate, c.commentText, c.commentEmail')
				->from($app->_db->quoteName('#__k2_comments') . ' AS c')
				->where($app->_db->quoteName('c.itemID') . ' = ' . $id, 'AND')
				->where($app->_db->quoteName('c.published') . ' = 1')
				->order('c.commentDate DESC');
		$app->_db->setQuery($query, $o, $l);
		$app->_db->execute();
		$items = self::assignRef($app->_db->loadObjectList());
		self::render($app, $items);
	}

	public static function addComment($app, $id) {
		$user = JFactory::getUser();
		$o = new stdClass();
		$o->itemID = $id;
		$o->userID = $user->id;
		$o->userName = $app->request->post('username');
		$o->commentDate = date('Y-m-d H:i:s', time());
		$o->commentText = $app->request->post('text');
		$o->commentEmail = $app->request->post('email');
		$o->published = 0;

		if ($o->userName && $o->commentText && $o->commentEmail && filter_var($o->commentEmail, FILTER_VALIDATE_EMAIL)) {
			$results = $app->_db->insertObject('#__k2_comments', $o);
			$id = $app->_db->insertid();
			$app->render(200, array('db' => $results, 'item' => $o, 'msg' => 'Record inserted!'));
		} else {
			$app->render(400, array('msg' => 'Bad request'));
		}
	}

	public static function render($app, $items, $type = 'items') {
		$app->render(200, array($type => $items,));
		return true;
	}

	public static function assignRef($items) {
		$output = [];
		foreach ($items as $item) {
			$o = new stdClass();
			$o->id = $item->id;
			$o->username = $item->userName;
			$o->date = $item->commentDate;
			$o->text = $item->commentText;
			$o->email = $item->commentEmail;

			$output[] = $o;
		}
		return $output;
	}

}
