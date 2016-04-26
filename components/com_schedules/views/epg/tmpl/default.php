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

header("Content-type: text/xml; charset=utf-8");

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

$today = date('Y-m-d', time());
$epgDate = date('Ymd', time());
list($y, $m, $d) = explode('-', $today);
$jalaliDate = gregorian_to_jalali($y, $m, $d, '-');
$dateValue = JRequest::getVar('date', null, 'get') ? JRequest::getVar('date', null, 'get') : $jalaliDate;
list($y2, $m2, $d2) = explode('-', $dateValue);
$printDate = tr_num($d2, 'fa') . '/' . tr_num($m2, 'fa') . '/' . tr_num($y2, 'fa');

list($y, $m, $d) = explode('-', $dateValue);
$y = tr_num($y, 'en');
$m = tr_num($m, 'en');
$d = tr_num($d, 'en');
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
if (count($schedule)) { 
	$schedule->start = ($schedule->start) ? $schedule->start : '06:30';
	$schedule->end = ($schedule->end) ? $schedule->end : '23:00';
	$programs = json_decode($schedule->programs);
	$now = strtotime(date('H:i', time()));
	$onAirId = 999999; // Invalid program ID
	foreach ($programs as $program) {
		// On Air
		if (strtotime($date) == strtotime($today)) {
			if (strtotime($program->time) < time()) {
				(int) $onAirId = $program->id;
			}
		}
		// Duration
		if (empty($program->duration)) {
			$nextProgram = $program->id + 1;
			if (isset($programs->$nextProgram->time)) {
				$program->duration = strtotime($programs->$nextProgram->time) - strtotime($program->time);
			} else {
				$program->duration = strtotime($schedule->end) - strtotime($program->time);
			}
			$program->end = date('H:i:s', (strtotime($program->time) + $program->duration));
			//$program->duration = gmdate('H:i:s', $program->duration);
		}
		if (empty($program->description)) {
			$itemQuery  = 'SELECT i.introtext FROM #__k2_items AS i ';
			$itemQuery .= 'WHERE i.catid IN (3, 6, 7, 8) AND i.published = 1 AND i.trash = 0 AND i.access > 0 ';
			$itemQuery .= 'AND i.title = "' . $program->name . '"';
			//echo $itemQuery; die;
			$db->setQuery($itemQuery, 0, 1);
			$description = $db->loadObject();
			if ($description) {
				$program->description = str_replace('"', '\'', strip_tags($description->introtext));
				$program->shortDesc = str_replace('"', '\'', shorten(strip_tags($description->introtext), 10));
			} else {
				$program->description = '';
				$program->shortDesc = '';
			}
		}
	}
	$i = 0;
echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<epg_import>
	<schedule id="pooya_test" date="<?php echo $date; ?>" jalaliDate="<?php echo $jalaliDate; ?>" occassion="<?php echo $schedule->occassion; ?>">
	<?php
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
		<event end_time="<?php echo $epgDate . ' ' . $item->end; ?>" event_seq="seq<?php echo $i; ?>" start_time="<?php echo $epgDate . ' ' . $item->time; ?>" title="<?php echo $item->name; ?>">
			<description extended_synopsis="<?php echo $item->description; ?>" language="ira" short_synopsis="<?php echo $item->shortDesc; ?>" title="<?php echo $item->name . $part; ?>"/>
			<content nibble1="0" nibble2="0"/>
			<parental_rating country="IRN" rating="0"/>
		</event>
	<?php } ?>
	</schedule>
</epg_import>
<?php 
} else {
echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<error>No schedules found for specified date.</error>
<?php } ?>
<?php JFactory::getApplication()->close(); ?>


<?php /*
<epg_import>
<schedule id="bbcp_test">
<event end_time="20110412 11:11:50" event_seq="seq1" start_time="20110412 11:11:48" title="">
<description extended_synopsis="شرح برنامه کانال 1" language="ira" short_synopsis="توضیحات کانال 1" title="برنامه کانال 1"/>
<content nibble1="0" nibble2="0"/>
<parental_rating country="IRN" rating="0"/>
</event>
<event end_time="20110412 10:21:00" event_seq="seq2" start_time="20110412 09:58:55" title="">
<description extended_synopsis="شرح 1 جدید" language="ira" short_synopsis="" title="عنوان 1"/>
<content nibble1="0" nibble2="0"/>
<parental_rating country="IRN" rating="0"/>
</event>
<event end_time="20110412 11:12:00" event_seq="seq3" start_time="20110412 10:21:00" title="">
<description extended_synopsis="vbmnvbn" language="ira" short_synopsis="vbmnvbn" title="cfjh"/>
<content nibble1="0" nibble2="0"/>
<parental_rating country="IRN" rating="0"/>
</event>
<event end_time="20110412 17:21:00" event_seq="seq4" start_time="20110412 11:12:00" title="">
<description extended_synopsis="شرح 1 جدید" language="ira" short_synopsis="" title="عنوان 1"/>
<content nibble1="0" nibble2="0"/>
<parental_rating country="IRN" rating="0"/>
</event>
</schedule>
</epg_import>
*/