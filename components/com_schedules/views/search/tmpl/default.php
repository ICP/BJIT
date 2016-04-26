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
<h2 class="componentheading" style="text-indent: 20px;">
جستجو در کنداکتور
</h2>
<?php
if ($keyword == null) $keyError = true;
if (!$keyError) {
	$dayNames = array('Monday' => 'دوشنبه', 'Tuesday' => 'سه‌شنبه', 'Wednesday' => 'چهارشنبه', 'Thursday' => 'پنج‌شنبه', 'Friday' => 'جمعه', 'Saturday' => 'شنبه', 'Sunday' => 'یک‌شنبه');
	// $today = date('Y-m-d', time());
	
	$db = JFactory::getDBO();
	$query = $db->getQuery(true);
	$query->select(array('s.*', 'u.name'))
		  ->from('#__schedules AS s')
		  ->join('LEFT', '#__users AS u ON (u.id = s.modified_by)')
		  ->where(array('s.programs LIKE \'%' . str_replace('\\', '\\\\\\\\', str_replace('"', '', json_encode($keyword))) . '%\'', 's.state = 1'))
		  ->order('s.date DESC');
	if (isset($_GET['ref']) && $_GET['ref'] == 'item') {
		$db->setQuery($query, 0, 15);
	} else {
		$db->setQuery($query);
	}
	
	$results = $db->loadObjectList();
}
?>
<div class="schedules-table">


<?php if (!$keyError && $results) { ?>
<table class="">
	<tbody>
		<tr>
			<td class="span7">
				<strong style="font-family: 'B Koodak', 'BKoodak', koodak, tahoma, arial; font-size: 18px;"><span style="font-size: 22px;"><?php echo $keyword; ?></span>،&nbsp;<?php echo count($results); ?>&nbsp;روز، به شرح زیر در جدول برنامه ها قرار گرفته است.</strong>
			</td>
			<td class="span5">
				<?php if (!isset($print)) { ?>
				<form action="<?php echo JURI::base() . 'schedules-search'; ?>" method="get" style="margin: 0" class="pull-left">
					<fieldset>
						<div class="control-group form-inline">
							<input type="text" class="input-large" name="keyword" placeholder="جستجو در کنداکتور" value="<?php echo $keyword; ?>" />
							<button type="submit" class="btn">جستجو</button>
						</div>
					</fieldset>
				</form>
				
				<?php } ?>
			</td>
		</tr>
	</tbody>
</table>
<?php if (!isset($print)) { ?><div class="pull-left"><a target="_blank" href="<?php echo $_SERVER['REQUEST_URI'] . '&print'; ?>"><span class="icon-print"></span>&nbsp;<small>نسخه قابل چاپ</small></a></div><div class="clearfix"></div><?php } ?>
<div class="accordion" id="schedule-results">
<?php
	foreach ($results as $key => $result) {
	$state = ($key == 0) ? ' in' : '';
	$state = (isset($print)) ? ' in' : $state;
?>
	<div class="accordion-group">
		<div class="accordion-heading" style="position: relative;">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#schedule-results" href="#collapse<?php echo $key; ?>">
				<strong style="font-family: 'B Koodak', 'BKoodak', koodak, tahoma, arial; font-size: 16px;">
					<span class="date"><?php echo $this->convertJalali($result->date); ?></span>
					<span class="weekday"><?php echo $dayNames[gmdate('l', strtotime($result->date) + 86400)]; ?></span>
				</strong>
			</a>
			<?php if (!isset($print)) { ?>
			<a href="<?php echo JURI::base(true) . JRoute::_('index.php?option=com_schedules&view=table&date=' . $this->convertJalali($result->date)); ?>" class="pull-left" style="display: block; position: absolute; left: 0; top: 0; padding: 7px 0 0 10px">» مشاهده کل کنداکتور روز</a>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
		<div id="collapse<?php echo $key; ?>" class="accordion-body collapse<?php echo $state; ?>">
			<div class="accordion-inner">
				<?php 
				$items = $this->handlePrograms($result->programs, $keyword);
				if (!empty($items)) {
				?>
				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th>شناسه</th>
							<th>کد برنامه</th>
							<th>شروع</th>
							<th>مدت</th>
							<th>نام</th>
							<th>قسمت</th>
							<th>قسمت ها</th>
							<th>نوع</th>
							<th>ملاحظات</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($items as $item) { ?>
						<tr>
							<td><?php echo $item->id; ?></td>
							<td><?php echo $item->uid; ?></td>
							<td><?php echo $item->time; ?></td>
							<td><?php echo $item->duration; ?></td>
							<td><?php echo $item->name; ?></td>
							<td><?php echo $item->part; ?></td>
							<td><?php echo $item->parts; ?></td>
							<td><?php echo $this->getKind($item->kind); ?></td>
							<td><?php echo $item->notes; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php
				}
				?>
			</div>
		</div>
	</div>
<?php
	}
?>
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
