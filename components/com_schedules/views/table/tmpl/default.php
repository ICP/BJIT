<?php
/**
 * @version     1.0.0
 * @package     com_schedules
 * @copyright   Copyright (C) 2012,  Pooya TV. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid Roshan <faridv@gmail.com> - http://www.faridr.ir
 */

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

class schedulesTableHelper {
	public static function createLink($title) {
		
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
		require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');		
		
		if (stristr($title, 'لالایی')) {
			return $item->link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute('4')));
		} else {
			$title = trim($title);
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
			$query .= ' AND i.catid IN (3, 6, 7, 8)';
			$query .= ' AND i.title="' . $title . '"';
			// if ($_GET['debug'] == '1' && strstr($title, 'فوتبال')) echo "\n\n\n" . str_replace('#_', 'p25', $query);
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
}

include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';

$today = date('Y-m-d', time());
list($y, $m, $d) = explode('-', $today);
$jalaliDate = gregorian_to_jalali($y, $m, $d, '-');
$dateValue = JRequest::getVar('date', null, 'get') ? JRequest::getVar('date', null, 'get') : $jalaliDate;
$ajax = (JRequest::getVar('ajax', null, 'get') == 'true') ? JRequest::getVar('ajax', null, 'get') : false;

if (!$ajax) {
?>
<div class="schedules-table">
	<header>
		<h3>جدول پخش برنامه‌های شبکه کودک و نوجوان</h3>
	</header>
	<section id="datepicker-form">
		<form action="/index.php?option=com_schedules&view=table" class="form-inline">
			<label for="datepicker_input">انتخاب تاریخ</label>
			<input type="text" id="datepicker_input" name="datepicker" value="<?php echo $dateValue; ?>" />
			<a href="#" title="انتخاب تاریخ" id="datepicker" class="btn">انتخاب</a>
		</form>
	</section>
	<section id="parograms-table">
<?php } ?>
		<div class="pull-left">
		<!--
			<a target="_blank" href="<?php echo JURI::base() . 'programs-table?view=print&date=' . $dateValue; ?>" title="نسخه قابل چاپ">
				<span class="icon-print"></span>
				<small>نسخه قابل چاپ</small>
			</a>
			-->
		</div>
		<div class="clearfix"></div>
		<?php
		list($y, $m, $d) = explode('-', $dateValue);
		$y = tr_num($y, 'en');
		$m = tr_num($m, 'en');
		$d = tr_num($d, 'en');

		//var_dump($dateValue);
		
		if ($y < 2012) {
			if (intval($y) != 0) {
				$date = jalali_to_gregorian($y, $m, $d, '-');
			}
		}
		$query = 'SELECT s.* FROM #__schedules AS s WHERE s.date = "' . $date . '" AND s.state = 1';
		$db = JFactory::getDBO();
		$db->setQuery($query, 0, 1);
		$schedule = $db->loadObject();
		if (count($schedule)) { 
			$programs = json_decode($schedule->programs);
			$now = strtotime(date('H:i:s', time()));
			$onAirId = 999999; // Invalid program ID
			/*
			$p; $idx = 0;
			foreach ($programs as $property => $program) {
				if (isset($program->kind) && isset($program->name)) {
					// if ($program->kind == 'armstations' || $program->kind == 'announces' || $program->kind == 'commercials') {
					if ($program->kind == 'armstations') {
						$prevProgram = $program->id - 1;
						if (!isset($programs->$prevProgram->name)) {
							$prevProgram = $program->id - 2;
						}
						// $currentDuration = hoursToSeconds($program->duration);
						// $prevDuration = hoursToSeconds($programs->$prevProgram->duration);
						// $programs->$prevProgram->duration = secondsToHour($prevDuration + $currentDuration);
						$program->duration = null;
						unset($programs->$property);
					} else {
						$p[] = $program;
					}
				} else {
					unset($programs->$property);
				}
			}
			$programs = (object) $p;
			*/
			
			foreach ($programs as $program) {
				$program->duration = null;
			}
			foreach ($programs as $program) {
				// On Air
				if (strtotime($date) == strtotime($today)) {
					if (strtotime($program->time) < time()) {
						(int) $onAirId = $program->id;
					}
				}
				// Duration
				if (empty($program->daration)) {
					$nextProgram = $program->id + 1;
					if (isset($programs->$nextProgram->time)) {
						$program->duration = strtotime($programs->$nextProgram->time) - strtotime($program->time);
					} else {
						$program->duration = strtotime($schedule->end) - strtotime($program->time);
					}
					$program->duration = gmdate('H:i:s', $program->duration);
				}
				$program->link = schedulesTableHelper::createLink($program->name);
			}
			$i = 0;
		?>
		<table class="table table-hover table-bordered programs-table">
			<thead>
				<tr>
					<th></th>
					<th class="i">ردیف</th>
					<th class="s">شروع</th>
					<th class="n">نام برنامه</th>
					<th class="d">مدت</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//print_r($programs);
				foreach ($programs as $item) {
					$i++;
					$trClass = ($item->id == $onAirId) ? ' now': '';
					$part = (!empty($item->part) || ($item->part != 0)) ? ' - قسمت ' . $item->part : '';
					$item->name = (!empty($item->link)) ? '<a href="' . $item->link . '" title="' . $item->name . '">' . $item->name . '</a>' : $item->name;
				?>
				<tr class="<?php echo $item->kind . $trClass; ?>">
					<td class="o"><?php echo ($item->id == $onAirId) ? '<span class="icon-arrow-left"></span>' : ''; ?></td>
					<td class="i"><?php echo $i; ?></td>
					<td class="s"><?php echo date('H:i:s', strtotime($item->time)); ?></td>
					<td class="n"><?php echo $item->name . $part; ?></td>
					<td class="d"><?php echo $item->duration; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="colors-guide">
			<br />
			<br />
			<table class="table" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td class="foreigner-series">مجموعه خارجی</td>
						<td class="persian-series">مجموعه ایرانی</td>
						<td class="armstations">آرم‌استیشن، وله، اعلام برنامه</td>
						<td class="movies">سینمایی</td>
						<td class="announces">آنونس، تیزر، میان‌برنامه</td>
						<td class="prayer-time">قرآن و اذان</td>
						<td class="musical">کلیپ موزیکال</td>
						<td class="commercials">آگهی بازرگانی</td>
						<td class="specials">ویژه برنامه ها</td>
					</tr>
				<tbody>
			</table>
		</div>
		<?php } else { ?>
		<div class="alert fade in">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>خطا!</strong> جدول پخش روز مورد نظر پیدا نشد.
		</div>
		<?php } ?>
<?php if (!$ajax) { ?>
	</section>
</div>
<?php 
} else { 
	JFactory::getApplication()->close();
}
?>