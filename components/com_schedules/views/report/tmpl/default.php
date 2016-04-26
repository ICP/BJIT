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
$print = $_GET['print'];

if (!function_exists('gregorian_to_jalali'))
	include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';

$keyword = JRequest::getVar('keyword', null, 'get');
$dateFrom = JRequest::getVar('from', null, 'get');
$dateFromG = ($dateFrom) ? $this->convertGregorian($dateFrom) : null;
$dateTo = JRequest::getVar('to', null, 'get');
$dateToG = ($dateTo) ? $this->convertGregorian($dateTo) : null;
?>
<?php if (isset($print)) { ?>
<!DOCTYPE html><html><head><title>جستجوی <?php echo $keyword; ?> در کنداکتور</title>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/pooya/css/bootstrap.min.css" type="text/css" media="all"  />
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/pooya/css/main.css" type="text/css" media="all"  />
<style type="text/css">
body { background: none transparent !important; }
</style>
</head><body>
<div class="container" id="main">
<?php } ?>
<h2 class="componentheading" style="text-indent: 20px;">گواهی پخش برنامه</h2>
<hr />
<?php
if ($keyword == null) $keyError = true;
if (!$keyError) {
	$dayNames = array('Monday' => 'دوشنبه', 'Tuesday' => 'سه‌شنبه', 'Wednesday' => 'چهارشنبه', 'Thursday' => 'پنج‌شنبه', 'Friday' => 'جمعه', 'Saturday' => 'شنبه', 'Sunday' => 'یک‌شنبه');
	// $today = date('Y-m-d', time());
	
	$whereClause = array(
			's.programs LIKE \'%' . str_replace('\\', '\\\\\\\\', str_replace('"', '', json_encode($keyword))) . '%\''
			, 's.state = 1'
			);
	if (isset($dateFromG)) $whereClause[] = 'date >= "' . $dateFromG . '"';
	if (isset($dateToG)) $whereClause[] = 'date <= "' . $dateToG . '"';
	
	$db = JFactory::getDBO();
	$query = $db->getQuery(true);
	$query->select(array('s.*', 'u.name'))
		  ->from('#__schedules AS s')
		  ->join('LEFT', '#__users AS u ON (u.id = s.modified_by)')
		  ->where($whereClause)
		  ->order('s.date DESC');
		$db->setQuery($query);
	$results = $db->loadObjectList();
	
	$map = $repo = array();
	foreach ($results as $key => $result) {
		$items = $this->handlePrograms($result->programs, $keyword);
		if (!empty($items)) {
			foreach ($items as $item) {
				if (!array_key_exists($item->name . $item->part, $map)) {
					if ($item->kind != 'armstation' && $item->kind != 'armstations' && $item->kind != 'announces') {
						$item->date = $dayNames[gmdate('l', strtotime($result->date) + 86400)] . ' ' . $this->convertJalali($result->date);
						$map[$item->name . $item->part] = $item;
					}
				}
			}
		}
	}
	if (count($map > 0)) {
		$durations = 0;
		foreach($map as $item) {
			$str_time = $item->duration;
			$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
			sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
			$durations += $item->time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
		}
		
		$hours = floor($durations / 3600);
		$mins = floor(($durations - ($hours*3600)) / 60);
		$minss = floor($durations / 60);
		$secs = floor($durations % 60);
		$time = $hours . ':' . $mins . ':' . $secs;
	}
}
?>
<div class="schedules-table" id="schedules-report">
	<?php if (!isset($print)) { ?>
	<form action="<?php echo JURI::base() . 'schedules-report'; ?>" method="get" style="margin-bottom: 0;">
		<div>
			<div style="width: 29%; float: right; padding: 0 10px;">
				<div class="control-group">
					<input id="datepicker-1" class="input-large" type="text" placeholder="از تاریخ" value="<?php echo ($dateFrom) ? $dateFrom : ''; ?>" data-type="calendar" name="from" />
				</div>
			</div>
			<div style="width: 29%; float: right; padding: 0 10px;">
				<div class="control-group">
					<input id="datepicker-2" class="input-large" type="text" placeholder="تا تاریخ" value="<?php echo ($dateTo) ? $dateTo : ''; ?>" data-type="calendar" name="to" />
				</div>
			</div>
			<div style="width: 35%; float: right; padding: 0 10px;">
				<fieldset>
					<div class="control-group form-inline">
						<input type="text" class="input-large" name="keyword" placeholder="جستجو در کنداکتور" value="<?php echo $keyword; ?>" />
						<button type="submit" class="btn">جستجو</button>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="clearfix"></div>
	</form>
	<hr />
	<br />
	<?php } ?>
	<?php if (!$keyError && $results) { ?>
	<table class="">
		<tbody>
			<tr>
				<td class="span12">
					<strong style="font-family: 'B Koodak', 'BKoodak', koodak, tahoma, arial; font-size: 18px;"><span style="font-size: 22px;">
						‫برنامه  &nbsp;<?php echo $keyword; ?>
						
					</strong>
					<br /><br />
					<?php echo count($map); ?> کلاکت با مجموع تایم <?php echo $minss; ?> دقیقه و <?php echo $secs; ?> ثانیه ‬‎
					<?php if ($dateFrom || $dateTo) { ?>
						از تاریخ <?php echo $dateFrom; ?>&nbsp;
						<?php if ($dateTo) { ?>تا تاریخ <?php echo $dateTo; ?><?php } ?>
					<?php } ?>
					پخش شده است.
				</td>
			</tr>
		</tbody>
	</table>
	<hr />
	<?php if (!isset($print)) { ?>
		<div class="pull-left">
			<a target="_blank" href="<?php echo $_SERVER['REQUEST_URI'] . '&print'; ?>"><span class="icon-print"></span>&nbsp;<small>نسخه قابل چاپ</small></a>
		</div>
		<div class="clearfix"></div>
	<?php } ?>
	<div class="" id="schedule-results">
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th>تاریخ</th>
					<th>شناسه</th>
					<th>کد برنامه</th>
					<th>شروع</th>
					<th>مدت</th>
					<th>نام</th>
					<th>قسمت</th>
					<th>قسمت ها</th>
					<th>نوع</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($map as $key => $item) {
				$state = ($key == 0) ? ' in' : '';
				$state = (isset($print)) ? ' in' : $state;
			?>
				<tr>
					<td><?php echo $item->date; ?></td>
					<td><?php echo $item->id; ?></td>
					<td><?php echo $item->uid; ?></td>
					<td><?php echo $item->time; ?></td>
					<td><?php echo $item->duration; ?></td>
					<td><?php echo $item->name; ?></td>
					<td><?php echo $item->part; ?></td>
					<td><?php echo $item->parts; ?></td>
					<td><?php echo $this->getKind($item->kind); ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
</div>
<?php
} else {
?>
	<div class="alert fade in">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>خطا!</strong> هیچ موردی یافت نشد!
	</div>
<?php
}
?>
</div>
<?php if (isset($print)) {
echo '</div></body>';
$app = JFactory::getApplication()->close();
} ?>