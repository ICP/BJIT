<style>
#main { padding-left: 20px; }
label { width: auto !important; }
textarea { font-family: Tahoma; }
.form-inline label { width: 100px !important; }
.table-bordered { border: 1px solid #000 !important; }
</style>
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

// header("Content-type: text/xml; charset=utf-8");
include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';

function shorten($text, $wordCount = 10) {
	$words = explode(' ', $text);
	$output = '';
	for ($c = 0; $c < $wordCount; $c++) {
		$delimiter = ($c == ($wordCount - 1)) ? '...' : ' ';
		$output .= $words[$c] . $delimiter;
	}
	return $output;
}
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
function hoursToSeconds ($hour) { // $hour must be a string type: "HH:mm:ss"
    $parse = array();
	if (!preg_match('#^(?<hours>[\d]{2}):(?<mins>[\d]{2}):(?<secs>[\d]{2})$#', $hour, $parse)) {
         // Throw error, exception, etc
         // throw new RuntimeException ("Hour Format not valid");
		return 'hey!';
    }
        return (int) $parse['hours'] * 3600 + (int) $parse['mins'] * 60 + (int) $parse['secs'];
}
function secondsToHour($init) {
	$hours = floor($init / 3600);
	$minutes = floor(($init / 60) % 60);
	$seconds = $init % 60;
	if (intval($hours) < 10) $hours = '0' . $hours;
	if (intval($minutes) < 10) $minutes = '0' . $minutes;
	if (intval($seconds) < 10) $seconds = '0' . $seconds;
	return "$hours:$minutes:$seconds";
}
$today = date('Y-m-d', time());
$epgDate = date('Ymd', time());
list($y, $m, $d) = explode('-', $today);
$jalaliDate = gregorian_to_jalali($y, $m, $d, '-');
$dateValue = JRequest::getVar('date', null, 'get') ? JRequest::getVar('date', null, 'get') : $jalaliDate;
list($y2, $m2, $d2) = explode('-', $dateValue);
$printDate = tr_num($d2, 'fa') . '/' . tr_num($m2, 'fa') . '/' . tr_num($y2, 'fa');

list($y, $m, $d) = explode('-', $dateValue);
$y = tr_num($y, 'en');
$m = intval(tr_num($m, 'en')) < 10 ? '0' . intval(tr_num($m, 'en')) : tr_num($m, 'en');
$d = intval(tr_num($d, 'en')) < 10 ? '0' . intval(tr_num($d, 'en')) : tr_num($d, 'en');
$jalaliDate = $y . '-' . $m . '-' . $d;
if ($y < 2012) {
	if (intval($y) != 0) {
		$date = jalali_to_gregorian($y, $m, $d, '-');
		$epgDate = date('Ymd', strtotime($date));
	}
}
$query = 'SELECT s.* FROM #__schedules AS s WHERE s.date = "' . $date . '" AND s.state = 1';
$db = JFactory::getDBO();
$db->setQuery($query, 0, 1);
$schedule = $db->loadObject();

$epgItemQuery = 'SELECT i.introtext, i.fulltext FROM #__k2_items AS i WHERE i.id = 55091';
$db->setQuery($epgItemQuery, 0, 1);
$epgItem = $db->loadObject();

if (count($schedule)) { 
	$schedule->start = ($schedule->start) ? $schedule->start : '06:30';
	$schedule->end = ($schedule->end) ? $schedule->end : '23:00';
	$programs = json_decode($schedule->programs);
	$now = strtotime(date('H:i', time()));
	$onAirId = 999999; // Invalid program ID

	foreach ($programs as $property => $program) {
		// Duration
		if (empty($program->duration)) {
			$nextProgram = $program->id + 1;
			if (isset($programs->$nextProgram->time)) {
				$program->duration = strtotime($programs->$nextProgram->time) - strtotime($program->time);
			} else {
				$program->duration = strtotime($schedule->end) - strtotime($program->time);
			}
		}
	}
	
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
			}
		} else {
			unset($programs->$property);
		}
	}

	foreach ($programs as $property => $program) {
	
		if (!$program->name) unset($programs->$property);
		// On Air
		if (strtotime($date) == strtotime($today)) {
			if (strtotime($program->time) < time()) {
				(int) $onAirId = $program->id;
			}
		}
		$program->end = secondsToHour(hoursToSeconds($program->time) + hoursToSeconds($program->duration));
		// Description
		if (empty($program->description)) {
			$itemQuery  = 'SELECT i.introtext, i.fulltext FROM #__k2_items AS i ';
			$itemQuery .= 'WHERE i.catid IN (3, 6, 7, 8) AND i.published = 1 AND i.trash = 0 AND i.access > 0 ';
			$itemQuery .= 'AND i.title = "' . $program->name . '"';
			//echo $itemQuery; die;
			$db->setQuery($itemQuery, 0, 1);
			$description = $db->loadObject();
			if ($description) {
				$program->description = str_replace('"', '\'', strip_tags($description->fulltext));
				$program->shortDesc = str_replace('"', '\'', strip_tags($description->introtext));
			} else {
				$program->description = str_replace('"', '\'', strip_tags(str_replace("<br />", "\n", $epgItem->fulltext)));
				$program->shortDesc = str_replace('"', '\'', strip_tags($epgItem->introtext));
			}
			if ($program->description == '') $program->description = $program->shortDesc;
		}
	}	
?>
<div>
	<form id="pooya_test">
		<fieldset>
			<table class="table table-bordered table-condensed table-hover">
				<tbody>
					<tr>
						<td>
							<label for="date">تاریخ میلادی</label>
							<input name="date" type="text" class="input-small" value="<?php echo $date; ?>" />
						</td>
						<td>
							<label for="jdate">تاریخ شمسی</label>
							<input name="jdate" type="text" class="input-small" value="<?php echo $jalaliDate; ?>" />
						</td>
						<td>
							<label for="occassion">مناسبت</label>
							<input name="occassion" type="text" class="input-xlarge" value="<?php echo $schedule->occassion; ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
		<?php
		$i = 0;
		foreach ($programs as $item) {
			$i++;
			$onAir = ($item->id == $onAirId) ? 'true': 'false';
			$part = (!empty($item->part) || ($item->part != 0)) ? ' - قسمت ' . $item->part : '';
			// Backward compatibility for new times. Originally it was "99:99" and now it's "99:99:99"
			$explodedTime = explode(':', $item->time);
			if (count($explodedTime) == 2)
				$item->time = $item->time . ':00';
			if (!empty($item->duration)) {
				$explodedDuration = explode(':', $item->duration);
				if (count($explodedDuration) == 2)
					$item->duration = $item->duration . ':00';
			}
		?>
		<fieldset>
			<table class="table table-bordered table-condensed">
				<tbody>
					<tr>
						<td colspan="4">
							<?php echo "#" . $i . ' - ' . $item->id; ?>
							<div class="form-inline">
								<label for="title">عنوان برنامه</label>
								<input class="span6" name="title" type="text" value="<?php echo $item->name . $part; ?>" />
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="form-inline">
								<label for="short_synopsis">توضیح اجمالی</label>
								<textarea class="span6" rows="<?php echo ($item->shortDesc) ? '3' : '1' ; ?>" name="short_synopsis"><?php echo $item->shortDesc; ?></textarea>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="form-inline">
								<label for="extended_synopsis">شرح کلی</label>
								<textarea class="span6" rows="<?php echo ($item->shortDesc) ? '10' : '1' ; ?>" name="extended_synopsis"><?php echo $item->description; ?></textarea>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<label for="ddate">تاریخ</label>
							<input name="ddate" class="input-small" type="text" value="<?php echo str_replace('-', '/', $jalaliDate); ?>" />
						</td>
						<td>
							<label for="duration">مدت</label>
							<input name="duration" class="input-small" type="text" value="<?php echo $item->duration; ?>" />
						</td>
						<td>
							<label for="start_time">ساعت شروع</label>
							<input name="start_time" class="input-small" type="text" value="<?php echo $item->time; ?>" />
						</td>
						<td>
							<label for="end_time">ساعت پایان</label>
							<input name="end_time" class="input-small" type="text" value="<?php echo $item->end; ?>" />
							<input type="checkbox" name="toggle-read" class="toggle-read pull-left" />
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
		<?php } ?>
	</form>
</div>
<?php 
} else {
?>
<div class="alert">یافت نشد!</div>
<?php } ?>
<?php //JFactory::getApplication()->close(); ?>