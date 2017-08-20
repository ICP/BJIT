<?php

class Tourism {

	public $base = 'http://tourism.doctv.ir';
	public $latest = 'http://tourism.doctv.ir/?format=json';
	public $item = 'http://tourism.doctv.ir/content/%id%?format=json';

	function Tourism($id = null, $app) {
		if (!$id) {
			$this->loadLatest($app);
		} else {
			$this->loadItem($id, $app);
		}
	}

	function loadLatest($app) {
		$content = file_get_contents($this->latest);
		$results = json_decode($content)->items;
		$items = [];
		if (count($results)) {
			foreach ($results as $key => $item) {
				$o = new stdClass();
				$o->id = $item->id;
				$o->title = $item->title;
				$o->link = $this->base . '/content/' . $item->id;
				$o->category = $item->category->name;
				$o->categoryLink = '';
				$o->state = 1;
				$o->introtext = strip_tags($item->introtext);
				$o->video = $item->video;
				$o->created = $item->created;
				$o->img = $this->base . $item->image;
				$o->thumb = $this->base . $item->imageSmall;
				$items[] = $o;
			}
		}

		$app->render(200, array('items' => $items));
	}

	function loadItem($id, $app) {
//		echo str_replace('%id%', $id, $this->item); die;
		$content = file_get_contents(str_replace('%id%', $id, $this->item));
		$item = json_decode($content)->item;
		$items = [];
		if (count($item)) {
			$o = new stdClass();
			$o->id = $item->id;
			$o->title = $item->title;
			$o->link = $this->base . '/content/' . $item->id;
			$o->category = $item->category->name;
			$o->categoryLink = '';
			$o->state = 1;
			$o->introtext = strip_tags($item->introtext);
			$o->video = $item->video;
			$o->created = $item->created;
			$o->img = $this->base . $item->image;
			$o->thumb = $this->base . $item->imageSmall;
			$items[] = $o;
		}

		$app->render(200, array('items' => $items));
	}

}
