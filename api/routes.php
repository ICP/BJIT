<?php

// Main entry
$app->get('/', function () use ($app) {
	$user = JFactory::getUser();
	$name = !$user->guest ? $user->name : 'guest';
	$app->render(200, array('msg' => 'Welcome' . ' ' . $name));
});

// Converts
$app->map('/convert/:type(/)', function ($type) use ($app) {
	include 'classes/convert.php';
	new Convert($app, $type);
})->via('GET');

// Programs & Episodes
$app->map('/programepisodes(/)', function () use ($app) {
	Items::getProgramsList($app);
})->via('GET')->via('POST');
$app->map('/programepisodes(/)(:catid(/))', function ($catid) use ($app) {
	if ($catid) {
		Items::getEpisodesList($app, $catid);
	} else {
		$app->render(404, array('msg' => 'No items found for category with id =' . ' ' . $catid, 'error' => true));
	}
})->via('GET');

// Content
$app->map('/homepage(/)', function () use ($app) {
	Items::getItems($app, 'homepage');
})->via('GET');
$app->map('/items(/)(:id(/))', function ($id = null) use ($app) {
	if (!$id) {
		$query = $app->request->get('q', null);
		if ($query) {
			Items::getItems($app, 'search', null, $query);
		} else {
			Items::getItems($app, 'items');
		}
	} else {
		Items::getItem($app, $id);
	}
})->via('GET');
$app->map('/categories(/)(:id(/))', function ($id = null) use ($app) {
	Items::getCategoriesByParent($app, $id);
})->via('GET');
$app->map('/categoryitems(/)(:id(/))', function ($id = null) use ($app) {
	if (isset($id))
		Items::getItems($app, 'bycategory', $id);
})->via('GET');
$app->map('/parentcategoryitems(/)(:id(/))', function ($id = null) use ($app) {
	if (isset($id))
		Items::getItems($app, 'byparentcategory', $id);
})->via('GET');

// Comments
$app->map('/comments(/)(:id(/))', function ($id = null) use ($app) {
	if (isset($id)) {
		Comments::getItemComments($app, $id);
	}
})->via('GET');
$app->map('/comments(/)(:id(/))', function ($id = null) use ($app) {
	if (isset($id)) {
		Comments::addComment($app, $id);
	}
})->via('POST');

// Subsctiptions
$app->map('/subscribe(/)(:type(/))', function ($type = null) use ($app) {
	Subscription::addContact($app, $type);
})->via('POST');

// Schedules
$app->map('/schedules(/)(:date(/))', function ($date = null) use ($app) {
	$date = (!$date) ? date('Y-m-d', time()) : $date;
	Schedule::getItems($app, $date);
})->via('GET');
$app->map('/schedules(/)(:date(/))', function ($date = null) use ($app) {
	$user = JFactory::getUser();
	if ($user->authorise('core.edit', 'com_content')) {
		$date = (!$date) ? date('Y-m-d', time()) : $date;
		Schedule::add($app, $date);
	}
	$app->render(403, array('msg' => 'Not authorized', 'error' => true));
})->via('POST');
$app->map('/schedules(/)(:id(/))', function ($id = null) use ($app) {
	if (!$id) {
		$app->render(404, array('msg' => 'Item not found id =' . ' ' . $id, 'error' => true));
	}
})->via('PUT');
$app->map('/schedules(/)(:id(/))', function ($id = null) use ($app) {
	if (!$id) {
		$app->render(404, array('msg' => 'Item not found id =' . ' ' . $id, 'error' => true));
	} else {
		$user = JFactory::getUser();
		if ($user->authorise('core.edit', 'com_content')) {
			Schedule::delete($app, $id);
		}
	}
	$app->render(403, array('msg' => 'Not authorized', 'error' => true));
})->via('DELETE');

// Users
$app->map('/user(/)', function () use ($app) {
	jimport('joomla.user.helper');
	$user = JFactory::getUser();
	$session = JFactory::getSession();
	$table = JTable::getInstance('session');
	$table->load($session->getId());

	if ($session->get('admin_user') == 1) {
		echo "Access granted admin"; // for testing purposes
	} else if ($session->get('admin_user') == 0) {
		echo "Access granted site"; // for testing purposes
	} else {
		echo "Access denied"; // for testing purposes
	}

	$app->render(403, array('msg' => 'Not authorized', 'error' => true));
})->via('GET');
$app->map('/ugc(/)(:type(/))', function ($type = null) use ($app) {
	include 'classes/ugc.php';
	new UGC($type, $app, 'post');
})->via('POST');


// External
$app->map('/tourism(/)(:id(/))', function ($id = null) use ($app) {
	include 'classes/tourism.php';
	new Tourism($id, $app);
})->via('GET');