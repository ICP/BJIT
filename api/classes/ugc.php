<?php

Class UGC {

	// Constructor
	function UGC($type = null, $app, $method) {
		switch ($type) {
			case 'requesttitle':
				if ($method == "post")
					self::requestTitle($app);
				break;
			case 'upload':
			case 'add':
				if ($method == "post")
					self::add($app);
				break;
			case 'file':
				self::file($app);
				break;
			case 'binaryfile':
				self::binaryFile($app);
				break;
		}
	}

	public static function add($app) {
		$user = JFactory::getUser();
		$mobile_app = $app->request->post('mobileapp', null);
		if ($user->guest || !$mobile_app) {
			$app->render(403, array('error' => true, 'msg' => 'Not authorized', 'status' => 403));
		}
		$o = new stdClass();
		$o->created = date('Y-m-d H:i:s', time());
		$o->created_by = ($user->id ? $user->id : 0);
		$o->ordering = $app->_db->quote(0);
		$o->state = $app->_db->quote(0);
		$o->title = $app->request->post('title', "");
		$o->description = $app->request->post('description', "");
		$o->file = $app->request->post('file', "");
		$o->params = ($mobile_app) ? "mobile" : "";
		
		$app->_db->getQuery(true);
		try {
			$results = $app->_db->insertObject('#__ugc_items', $o);
			$id = $app->_db->insertid(); // TODO
		} catch (Exception $ex) {
			$app->render(500, array('error' => true, 'msg' => 'خطایی رخ داده است'));
		}
		$app->render(200, array('db' => $results, 'item' => $o, 'msg' => 'اثر شما با موفقیت ثبت و پس از بررسی روی سایت منتشر خواهد شد'));
	}

	public static function file($app) {
		include dirname(dirname(__FILE__)) . DS . 'helpers' . DS . 'uploader' . DS . 'endpoint.php';
		die();
	}
	
	public static function binaryFile ($app) {
		include dirname(dirname(__FILE__)) . DS . 'helpers' . DS . 'uploader' . DS . 'binary.php';
		die();
	}

	public static function requestTitle($app) {
		$id = $app->request->post('item_id', null);
		$user = JFactory::getUser();
		if ($id) {
			$o = new stdClass();
			$o->created = date('Y-m-d H:i:s', time());
			$o->created_by = $app->_db->quote(($user->id ? $user->id : 0));
			$o->item_id = $app->_db->quote($id);

			$app->_db->getQuery(true);
			try {
				$results = $app->_db->insertObject('#__ugc_requesttitles', $o);
				$id = $app->_db->insertid();
			} catch (Exception $ex) {
				$app->render(500, array('error' => true, 'msg' => 'به نظر می‌رسد شما قبلاً این برنامه را معرفی کرده‌اید'));
			}
			$app->render(200, array('db' => $results, 'item' => $o, 'msg' => 'درخواست شما با موفقیت ثبت شد'));
		} else {
			$app->render(500, array('error' => true, 'msg' => 'Wrong item id', 'status' => 500));
		}
	}

}
