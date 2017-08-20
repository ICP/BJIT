<?php

abstract class Route {

	public static function video($path) {
		$base = 'http://77.36.165.143/Mostanad/videos';
		$url = str_replace('$old|', '', str_replace('{/mp4}', '', str_replace('{mp4}', '', str_replace('{/mp4remote}', '', str_replace('{mp4remote}', '', $path)))));
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
