<?php
// no direct access
defined('_JEXEC') or die;

if (!function_exists('shorten')) {
	function shorten($text, $wordCount = 10) {
		$words = explode(' ', $text);
		$output = '';
		for ($c = 0; $c < $wordCount; $c++) {
			$delimiter = ($c == ($wordCount - 1)) ? '...' : ' ';
			$output .= $words[$c] . $delimiter;
		}
		return $output;
	}
}
if (!function_exists('ellipsis')) {
	function ellipsis($text) {
		$words = explode(' ', $text);
		$output = '';
		$wordCount = count($words) - 1;
		for ($c = 0; $c < $wordCount; $c++) {
			$delimiter = ($c == ($wordCount - 1)) ? '...' : ' ';
			$output .= $words[$c] . $delimiter;
		}
		return $output;
	}
}
if (!function_exists('hoursToSeconds')) {
	function hoursToSeconds ($hour) { // $hour must be a string type: "HH:mm:ss"
		$parse = array();
		if (!preg_match('#^(?<hours>[\d]{2}):(?<mins>[\d]{2}):(?<secs>[\d]{2})$#', $hour, $parse)) {
			 // Throw error, exception, etc
			 // throw new RuntimeException ("Hour Format not valid");
			return 'hey!';
		}
			return (int) $parse['hours'] * 3600 + (int) $parse['mins'] * 60 + (int) $parse['secs'];
	}
}
if (!function_exists('secondsToHour')) {
	function secondsToHour($init) {
		$hours = floor($init / 3600);
		$minutes = floor(($init / 60) % 60);
		$seconds = $init % 60;
		if (intval($hours) < 10) $hours = '0' . $hours;
		if (intval($minutes) < 10) $minutes = '0' . $minutes;
		if (intval($seconds) < 10) $seconds = '0' . $seconds;
		return "$hours:$minutes:$seconds";
	}
}

class homepageCallback {
	
	public static function createLink($title) {
		
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');		
		
		if (stristr($title, 'لالایی')) {
			return $item->link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute('4')));
			return JRoute::_('index.php?option=com_k2&view=itemlist&layout=category&task=category&id=4');
		} else {
			$db = JFactory::getDBO(); // Create db instance
			$jnow = JFactory::getDate();
			$now = $jnow->toSql();
			$nullDate = $db->getNullDate();
			$query  = 'SELECT i.*, c.name AS categoryname, c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams';
			
			if (defined('TAGIDS')) $query .= ' , CASE WHEN tx.tagID IN(' . TAGIDS . ') THEN "NAHAL" ELSE "POOYA" END as sitename ';
			
			$query .= ' FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid';
			
			if (defined('TAGIDS')) $query .= ' LEFT JOIN p25_k2_tags_xref tx ON tx.itemID = i.id ';
			
			$query .= ' WHERE i.published = 1 AND i.trash = 0 AND c.published = 1 AND c.trash = 0';
			$query .= ' AND ( i.publish_up = ' . $db->Quote($nullDate) . ' OR i.publish_up <= ' . $db->Quote($now) . ' )';
			$query .= ' AND ( i.publish_down = ' . $db->Quote($nullDate) . ' OR i.publish_down >= ' . $db->Quote($now) . ' )';
			$query .= ' AND i.catid IN(3, 4, 8)';
			$query .= ' AND i.title="' . $title . '"';
			$db->setQuery($query, 0, 1);
			$item = $db->loadObject();
			
			if (count($item)) {
				$item->link  = ($item->sitename === 'NAHAL') ? 'http://nahaltv.ir': 'http://pooyatv.ir';
				$item->link .= urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias))));
				return $item->link;
			}
			
			return false;
		}
	}
	
	public static function getList() {
		
		$app = JFactory::getApplication();
		date_default_timezone_set('Asia/Tehran'); // Set default timezone to Tehran
		
		/* Times */
		$now = strtotime(date('H:i', time()));
		
		/* Dates */
		$today = date("Y-m-d", time());

		$db = JFactory::getDBO(); // Create db instance
		$query = 'SELECT * FROM #__schedules WHERE date = "' . $today . '" AND state > 0';
		$db->setQuery($query);
		$result = $db->loadObject();
		$startLimit = empty($result->start) ? strtotime("06:30") : strtotime($result->start);
		$endLimit = empty($result->end) ? strtotime("23:00") : strtotime($result->end);
		
		if ($now > $startLimit && $now < $endLimit) { // Broadcasting
			if ($result) {
				$occassion = empty($result->occassion) ? '' : $result->occassion;
				$programs = json_decode($result->programs);
				
				
				$p; $idx = 0;
				foreach ($programs as $property => $program) {
					if (isset($program->kind) && isset($program->name)) {
						// if ($program->kind == 'armstations' || $program->kind == 'announces' || $program->kind == 'commercials') {
						if ($program->kind == 'armstations') {
							$prevProgram = $program->id - 1;
							if (!isset($programs->$prevProgram->name)) {
								$prevProgram = $program->id - 2;
							}
							$currentDuration = hoursToSeconds($program->duration);
							$prevDuration = hoursToSeconds($programs->$prevProgram->duration);
							$programs->$prevProgram->duration = secondsToHour($prevDuration + $currentDuration);

							unset($programs->$property);
						} else {
							$p[] = $program;
						}
					} else {
						unset($programs->$property);
					}
				}
				// if ($_GET['t'] === '1') var_dump((object) $p);
				$programs = (object) $p;
				
				$count = count(get_object_vars($programs));
				
				foreach ($programs as $program) {
					$program->id = $idx;
					$programTime = strtotime($program->time);
					if ($programTime < $now) {
						(int) $onAirId = $program->id;
					}
					$idx++;
				}
				
				
				if ($onAirId >= 0) {
					foreach ($programs as $program) {
						if ($program->id == $onAirId) {
							$schedule['now'] = array ('id' => $onAirId, 'time' => $program->time, 'name' => $program->name, 'kind' => $program->kind, 'part' => $program->part, 'link' => self::createLink($program->name));
						}	
					}
					if ($onAirId == $count) {
						$schedule['next'] = false;
						$schedule['next2'] = false;
					} else {
						$onAirIdN = $onAirId + 1;
						$onAirIdN2 = $onAirId + 2;
						// if ($_GET['t'] === '1') echo $onAirIdN;
						foreach ($programs as $program) {
							if ($program->id == $onAirIdN) {
								$schedule['next'] = array ('id' => $onAirIdN, 'time' => $program->time, 'name' => $program->name, 'kind' => $program->kind, 'part' => $program->part, 'link' => self::createLink($program->name));
							}
						}
						foreach ($programs as $program) {
							if ($program->id == $onAirIdN2) {
								$schedule['next2'] = array ('id' => $onAirIdN, 'time' => $program->time, 'name' => $program->name, 'kind' => $program->kind, 'part' => $program->part, 'link' => self::createLink($program->name));
							}
						}
					}
					if ($onAirId == 0) {
						$schedule['before'] = false;
						$schedule['before2'] = false;
					} else if ($onAirId == 1) {
						foreach ($programs as $program) {
							if ($program->id == 0) {
								$schedule['before'] = array ('id' => 0, 'time' => $program->time, 'name' => $program->name, 'kind' => $program->kind, 'part' => $program->part, 'link' => self::createLink($program->name));
							}
						}
					} else {
						$onAirIdB2 = $onAirId - 2;
						$onAirIdB = $onAirId - 1;
						foreach ($programs as $program) {
							if ($program->id == $onAirIdB) {
								$schedule['before'] = array ('id' => $onAirIdB, 'time' => $program->time, 'name' => $program->name, 'kind' => $program->kind, 'part' => $program->part, 'link' => self::createLink($program->name));
							}
							if ($program->id == $onAirIdB2) {
								$schedule['before2'] = array ('id' => $onAirIdB2, 'time' => $program->time, 'name' => $program->name, 'kind' => $program->kind, 'part' => $program->part, 'link' => self::createLink($program->name));
							}
						}
					}
					
					return array(true, $schedule, $occassion);
				} else { // No schedules found for current time;
					return array(false, 'no-schedules');
				}
			} else { // No schedules found for current time;
				return array(false, 'no-schedules');
			}
		} else { // Not broadcasting
			return array(false, 'not-onair');
		}
	}
}

include 'homepage.php';