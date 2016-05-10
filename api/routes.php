<?php

// Main entry
$app->get('/', function () use ($app) {
	$user = JFactory::getUser();
	$name = !$user->guest ? $user->name : 'guest';
	$app->render(200, array('msg' => 'Welcome' . ' ' . $name));
});

// Convert
$app->map('/convert/:type(/)', function ($type) use ($app) {
	include 'classes/convert.php';
	new Convert($app, $type);
})->via('GET');

// Content
$app->map('/programepisodes(/)', function () use ($app) {
	Items::getProgramsList($app);
})->via('GET')->via('POST');
$app->map('/programepisodes(/)(:catid(/))', function ($catid) use ($app) {
	if ($catid) {
		Items::getEpisodesList($app, $catid);
	} else {
		$app->render(404, array('msg' => 'No items found for category with id =' . ' ' . $catid));
	}
})->via('GET');

$app->map('/homepage(/)', function () use ($app) {
	Items::getItems($app, 'homepage');
})->via('GET');

$app->map('/items(/)(:id(/))', function ($id = null) use ($app) {
	if (!$id) {
		Items::getItems($app, 'items');
	} else {
		Items::getItem($app, $id);
	}
})->via('GET');

$app->map('/schedules(/)(:date(/))', function ($date = null) use ($app) {
	$date = (!$date) ? date('Y-m-d', time()) : $date;
	Schedule::getItems($app, $date);
})->via('GET');

$app->map('/user(/)', function () use ($app) {
	jimport('joomla.user.helper');
	$user = JFactory::getUser();
	$session = JFactory::getSession();
	$table =  JTable::getInstance('session');
	$table->load( $session->getId() );

//	if( $table->client_id == 1) {
//	   echo 'admin_user';
//	} else {
//	   echo 'site_user';
//	}
	if ($session->get('admin_user') == 1) {
   echo "Access granted admin";// for testing purposes
} else if ($session->get('admin_user') == 0) {
   echo "Access granted site";// for testing purposes
} else {
   echo "Access denied"; // for testing purposes
}

	$app->render(403, array('msg' => 'Not authorized','user'=>$user, 'session' => $session, 'table' => $table));
})->via('GET');

$app->map('/schedules(/)(:date(/))', function ($date = null) use ($app) {
	$user = JFactory::getUser();
	if ($user->authorise('core.edit', 'com_content')) {
		$date = (!$date) ? date('Y-m-d', time()) : $date;
		Schedule::add($app, $date);
	}
	$app->render(403, array('msg' => 'Not authorized','user'=>$user));
})->via('POST');

$app->map('/schedules(/)', function ($id = null) use ($app) {
	if (!$id) {
		$app->render(404, array('msg' => 'Item not found id =' . ' ' . $id));
	}
//	include 'classes/schedule.php';
//	$date = (!$date) ? date('Y-m-d', time()) : $date;
//	Schedule::getItems($app, $date);
})->via('PUT');



// Misc
//$app->map('/content/', function () use ($app) {
//	$user = JFactory::getUser();
//	if (count($user->getAuthorisedCategories('com_content', 'core.create')) > 0) {
//		$row = new stdClass();
//		$row->title = $app->_input->get('title');
//		$row->introtext = $app->_input->get('introtext');
//		$row->created_by = $user->id;
//		$row->state = '1';
//
//		$app->_db->insertObject('#__content', $row);
//
//		$app->render(200, array(
//			'msg' => $row->title . ' created!',
//				)
//		);
//	}
//
//	$app->render(403, array(
//		'msg' => 'Not authorized',
//			)
//	);
//}
//)->via('POST');
//
//$app->map('/content/:id', function ($id) use ($app) {
//
//	$user = JFactory::getUser();
//	if ($user->authorise('core.edit', 'com_content.article.' . $id) || $user->authorise('core.edit.own', 'com_content.article.' . $id)) {
//		$row = new stdClass();
//		$row->id = $id;
//		$row->title = $app->_input->get('title');
//		$row->introtext = $app->_input->get('introtext');
//		$row->state = '1';
//
//		$result = $app->_db->updateObject('#__content', $row, 'id');
//
//		$app->render(200, array(
//			'msg' => $result,
//				)
//		);
//	}
//
//	$app->render(403, array(
//		'msg' => 'Not authorized',
//			)
//	);
//}
//)->via('PUT');
//
//$app->map('/content/:id', function ($id) use ($app) {
//	$query = $app->_db->getQuery(true);
//	$query->delete($app->_db->quoteName('#__content'))
//			->where('id = ' . $app->_db->quote($id));
//	$app->_db->setQuery($query);
//
//	$app->render(200, array(
//		'msg' => $app->_db->query(),
//			)
//	);
//}
//)->via('DELETE');
