<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// no direct access
defined('_JEXEC') or die;

include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';

$dayNames = array('دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه', 'یک‌شنبه');
$dayNames = array('Monday' => 'دوشنبه', 'Tuesday' => 'سه‌شنبه', 'Wednesday' => 'چهارشنبه', 'Thursday' => 'پنج‌شنبه', 'Friday' => 'جمعه', 'Saturday' => 'شنبه', 'Sunday' => 'یک‌شنبه');
function changeDateOffset($inputDate, $offset) {
	$dateInSeconds = strtotime($inputDate);
	$newOffsetTime = strtotime((string) $offset, $dateInSeconds);
	$newDate = date('Y-m-d', $newOffsetTime);	
	return $newDate;
}
function dateToJalali($gregorianDate, $slashes = false) {
	list($y, $m, $d) = explode('-', $gregorianDate);
	$jalaliDate = gregorian_to_jalali($y, $m, $d, '-');
	list($y2, $m2, $d2) = explode('-', $jalaliDate);
	$output = ($slashes) ? tr_num($d2, 'fa') . '/' . tr_num($m2, 'fa') . '/' . tr_num($y2, 'fa') : $jalaliDate;
	return $output;
}

$ratio = 3; // minutes * pixels
$today = date('Y-m-d', time());
$jalaliDate = dateToJalali($today);
$dateValue = JRequest::getVar('date', null, 'get') ? JRequest::getVar('date', null, 'get') : $jalaliDate;
$printDate = dateToJalali($today, true);
// $selectedDate = dateToJalali($dateValue);
list($y, $m, $d) = explode('-', $dateValue);
$y = tr_num($y, 'en'); $m = tr_num($m, 'en'); $d = tr_num($d, 'en');
if (intval($y) != 0) $date = jalali_to_gregorian($y, $m, $d, '-');
$oneWeekAfter = changeDateOffset($date, "+1 week");
$dates = array(
		$dateValue,
		dateToJalali(changeDateOffset($date, "+1 day")),
		dateToJalali(changeDateOffset($date, "+2 day")),
		dateToJalali(changeDateOffset($date, "+3 day")),
		dateToJalali(changeDateOffset($date, "+4 day")),
		dateToJalali(changeDateOffset($date, "+5 day")),
		dateToJalali(changeDateOffset($date, "+6 day"))
	);
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="/templates/pooya/css/bootstrap.min.css" type="text/css" media="all"  />
	<style type="text/css" media="all">
	@page { margin: 0.2cm 0.5cm 1cm 0.5cm; }
	html * { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
	body { margin-top: 20px; }
	small { font-weight: normal; margin-left: -7px; }
	.schedules { direction: rtl; text-align: center; font-family: Tahoma, arial, times; font-size: 10px; line-height: 10px; border-bottom: 1px solid #333 }
	.item { background: url('../../../../images/pixel.png') repeat-x 0 top transparent; /*display: table-cell;*/ width: 100px; overflow: hidden; }
	.item-wrapper { background: url('../../../../images/pixel.png') repeat-y left 0 transparent; }
	.item-wrapper .item { /*display: table-cell; vertical-align: middle;*/ }
	.item-wrapper .item span { display: inline-block; /*width: 99px; height: 12px; */overflow: visible; margin: auto; }
	.ruler { background: url('../../../../images/pixel.png') repeat-y left 0 transparent; padding-left: 1px; width: 99px !important; }
	.ruler-line { float: left; height: <?php echo $ratio; ?>px; background: url('../../../../images/pixel.png') repeat-x 0 top transparent; position: relative; }
	.ruler-line span { display: block; position: absolute; left: 20px; top: -3px; -webkit-transform: rotate(90deg); -moz-transform: rotate(90deg); -o-transform: rotate(90deg); writing-mode: lr-tb; }
	.clear { clear: both; }
	#parograms-table, .schedules-table { width: 800px; margin: 0 auto; direction: rtl; text-align: right; position: relative; }
	#parograms-table th { width: 100px; font-family: tahoma; font-size: 10px; padding: 20px 0; -webkit-transform: rotate(90deg); -moz-transform: rotate(90deg); -o-transform: rotate(90deg); writing-mode: lr-tb; line-height: 14px; }
	.schedules-table header { display: block; height: 60px; }
	thead { display: table-header-group; }
	th { text-align: center !important; /*font-weight: bold;*/ }
	td { font-family: Tahoma, arial, times; border: none !important;  vertical-align: top}
	tbody { font-size: 12px; line-height: 14px }
	.i, .s, .d { text-align: center !important; }
	.n { text-align: right !important; }
	.message { overflow: hidden; position: relative; height: 100%; width: 50px; float: right; min-height: 4000px !important; }
	.logo { display: block; position: fixed; right: -240px; top: 150px; /*margin-right: -250px; margin-bottom: 50px;*/ width: 45px; height: 56px; -webkit-transform: rotate(90deg); -moz-transform: rotate(90deg); -o-transform: rotate(90deg); writing-mode: lr-tb; display: none; }
	.title { z-index: 9999; direction: rtl !important; letter-spacing: 0 !important; font-family: 'B Koodak', 'BKoodak', Tahoma, Times; white-space: no-wrap; font-weight: bold; display: block; position: fixed; right: -270px; top: 500px; /*margin-right: -500px; margin-top: 350px;*/ width: 600px; height: 20px; -webkit-transform: rotate(90deg); -moz-transform: rotate(90deg); -o-transform: rotate(90deg); writing-mode: lr-tb; }
	.title span { display: inline-block; margin-left: 3px; }
	.title span.date { margin-right: 10px; }
	.armstation { background-color: #f04848; }
	.foreigner { background-color: #F2DEDE /* #e6b9b8 */ }
	.internal { background-color: #D9EDF7 /* b6dde8 */ }
	.film { background-color: #DFF0D8 /* 99ff99 */ }
	.azaan { background-color: #f2e5da /* f79646 */ }
	.lullaby { background-color: #ece6f2 /* ccc0da */ }
	.provinces { background-color: #afeeee; }
	.table-condensed th, .table-condensed td { padding: 1px 4px !important; }
	.last-modified { background: url('../../../../images/pixel.png') repeat-x 0 top transparent; min-height: 1px; }
	.colors-guide tr { border-right: 1px solid #000 !important; }
	.colors-guide td { text-align: center; width: 113px; border-left: 1px solid #000 !important; }
	/* New Types */
	.movies { background-color: #a4d29c; } 
	.persian-series { background-color: #69c4ed; }
	.foreigner-series { background-color: #f5c685; }
	.prayer-time { background-color: #f898f9; }
	.armstations { background-color: #fa4844; }
	.musical { background-color: #ffeb8a; }
	.announces { background-color: #8b5da9; }
	.specials { background-color: #1047f7; }
	.commercials { background-color: #c5cbd0; }
	</style>
	<script type="text/javascript" src="/templates/pooya/js/vendor/jquery-1.8.2.min.js"></script>
	<title>جدول هفتگی پخش برنامه های شبکه پویا</title>
</head>
<body>
	<header>
		<span class="title">
			<span><img src="/templates/pooya/img/print-logo.jpg" title="شبکه پویا" alt="شبکه پویا" width="45" height="56" /></span>
			<span>جدول هفتگی پخش برنامه‌های شبکه پویا از تاریخ</span>
			&nbsp;<span class="date"><?php echo $dates[0]; ?></span>&nbsp;
			<span>تا تاریخ</span>
			&nbsp;<span class="date"><?php echo $dates[6]; ?></span>
		</span>
		<span class="logo">
			<img src="/templates/pooya/img/print-logo.jpg" title="شبکه پویا" alt="شبکه پویا" />
		</span>
	</header>
	<div class="schedules-table">
		<?php		
		$query  = 'SELECT s.*, u.name AS editor FROM #__schedules AS s ';
		$query .= 'LEFT JOIN #__users AS u on s.modified_by = u.id ';
		$query .= 'WHERE s.date >= "' . $date . '" AND s.date < "' . $oneWeekAfter . '" AND s.state = 1 ';
		$query .= 'ORDER BY s.date ASC ';
		$db = JFactory::getDBO();
		$db->setQuery($query, 0, 7);
		$schedules = $db->loadObjectList();
		
		if (count($schedules)) { 
			foreach($schedules as $key => $schedule) {
				$progs[$key] = json_decode($schedule->programs);
				$occassion[$key] = $schedule->occassion;
				$modified[$key] = $schedule->modified;
				$modifiedBy[$key] = $schedule->editor;
				// $scheduleDate[$key] = jdate_words(array('rh' => gmdate('N', strtotime($schedule->date)) + 1), '‌');
				$scheduleDate[$key] = $dayNames[gmdate('l', strtotime($schedule->date) + 86400)];
			}
			foreach ($progs as $programs) {
				foreach ($programs as $program) {
					if (empty($program->daration)) {
						$nextProgram = $program->id + 1;
						if (isset($programs->$nextProgram->time)) {
							$program->duration = strtotime($programs->$nextProgram->time) - strtotime($program->time);
						} else {
							$program->duration = strtotime($schedule->end) - strtotime($program->time);
						}
						$program->seconds = $program->duration;
						$program->minutes = ($program->duration / 60);
						$program->duration = gmdate('H:i:s', $program->duration);
					}
				}
			}
		?>
		<div class="colors-guide">
			<!-- New Types -->
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
			<!-- Old Types -->
			<?php /*
			<table class="table" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td class="armstation">آرم استیشن</td>
						<td class="foreigner">خارجی</td>
						<td class="internal">داخلی</td>
						<td class="film">فیلم سینمایی</td>
						<td class="azaan">کلیپ و اذان</td>
						<td class="lullaby">لالایی</td>
						<td class="provinces">سیمای استان ها</td>
					</tr>
				<tbody>
			</table>
			*/ ?>
		</div>
		<table id="parograms-table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>زمان</th>
					<?php for ($n = 0; $n < 7; $n++) {
						echo '<th>';
						echo $scheduleDate[$n];
						echo '<br />';
						echo $dates[$n];
						echo '<br />';
						echo $occassion[$n];
						echo '</th>';
					} ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="schedules ruler" style="width: 99px !important;">
					<?php
					$hour = 6;
					$minute = 30;
					$minStep = 30;
					for ($j = 0; $j < 1020; $j++) {
						if (($j % 5) == 0) {
							$width = 10;
							if (($j % 10) == 0) {
								$width = 13;
								$clock  = '';
								if (($j % 60) == 0) {
									$width = 25;
									$clock = $hour . ':' . $minute;
									$hour++;
								} else if (($j % 30) == 0) {
									$width = 25;
									$clock = $hour . ':00';
								} 
								if ($clock == '') {
									$minStep += ($minStep == 20) ? 10 : 0;
									if ($minStep < 41) {
										$minStep += 10;
										$clock = '<small>' . $minStep . '</small>';
									} else {
										$minStep = 10;
										$clock = '<small>' . $minStep . '</small>';
									}
								}
							}
						} else {
							$width = 6;
							$clock = '';
						}
					?>
						<div class="ruler-line" style="width: <?php echo $width; ?>px;">
							<?php if ($clock) { ?><span><strong><?php echo $clock; ?></strong></span><?php } ?>
						</div>
						<div class="clear"></div>
					<?php } ?>
					</td>
					<?php foreach ($progs as $key => $program) { ?>
					<td class="schedules" style="width: 100px;">
						<?php
						$i = 0;
						if ($program->$i->time != '06:30') { 
							// Current Start
							$currentStart = $program->$i->time;
							sscanf($currentStart, "%d:%d", $hours, $minutes);
							$currentStartMinutes = $hours * 60 + $minutes;
							$timeDifference = ($currentStartMinutes > 390) ? ($currentStartMinutes - 390) * $ratio : null;
						}
						?>
						<div class="time-difference" style="<?php echo $timeDifference = $timeDifference ? 'height: ' . $timeDifference . 'px' : ''; ?>"></div>
						<?php //} ?>
						<?php 
						foreach ($program as $item) { 
							$itemParts  = (!empty($item->part) || ($item->part != 0)) ? $item->part : '';
							$itemParts .= (!empty($item->parts) || ($item->parts != 0)) ? '/' . $item->parts : '';
						?>
						<div class="item-wrapper <?php echo $item->kind; ?>">
							<div class="item" data-start="<?php echo $item->time; ?>" style="height: <?php echo $item->minutes * $ratio; ?>px">
								<span><?php echo $item->name . ' ' . $itemParts; ?></span>
							</div>
						</div>
						<?php } ?>
						<div class="last-modified">
						<?php if ($modified[$key] != '0000-00-00 00:00:00') { ?>
							<br />
							آخرین ویرایش:
							<br />
							<br />
							<?php 
							$lastModification = explode(' ', $modified[$key]);
							echo dateToJalali($lastModification[0]) . ' ' . $lastModification[1];
							?>
							<br />
							توسط
							<?php echo $modifiedBy[$key]; ?>
						<?php } ?>
						</div>
					</td>
					<?php } ?>
				</tr>
			</tbody>
		</table>
		<?php } else { ?>
		<div class="alert fade in">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>خطا!</strong> جدول پخش روز مورد نظر پیدا نشد.
		</div>
		<?php } ?>
	</div>
	<script>
	/*
	$(function() {
		$('.item-wrapper .item').find('span').each(function(){
			var spanHeight = $(this).height();
			var containerHeight = $(this).parent().height();
			var myMargin = (containerHeight - spanHeight) / 2;
			if (myMargin > 0) {
				// $(this).css({'margin-top': myMargin});
			}
		});
	});
	*/
	</script>
</body>
</html>
<?php JFactory::getApplication()->close(); ?>