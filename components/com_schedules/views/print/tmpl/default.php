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

include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';

$dayNames = array('Monday' => 'دوشنبه', 'Tuesday' => 'سه‌شنبه', 'Wednesday' => 'چهارشنبه', 'Thursday' => 'پنج‌شنبه', 'Friday' => 'جمعه', 'Saturday' => 'شنبه', 'Sunday' => 'یک‌شنبه');
$today = date('Y-m-d', time());
list($y, $m, $d) = explode('-', $today);
$jalaliDate = gregorian_to_jalali($y, $m, $d, '-');
$dateValue = JRequest::getVar('date', null, 'get') ? JRequest::getVar('date', null, 'get') : $jalaliDate;
list($y2, $m2, $d2) = explode('-', $dateValue);

$weekDayHelper = jalali_to_gregorian($y2, $m2, $d2, '-');
$weekday = $dayNames[gmdate('l', strtotime($weekDayHelper) + 86400)];
$printDate = $weekday . ' ' . tr_num($y2, 'fa') . '/' . tr_num($m2, 'fa') . '/' . tr_num($d2, 'fa');
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="/templates/pooya/css/bootstrap.min.css" type="text/css" media="all"  />
	<style type="text/css">
	body { margin-top: 20px; }
	.schedules-table { width: 800px; margin: 0 auto; direction: rtl; text-align: right; position: relative; }
	.schedules-table header { display: block; height: 60px; }
	th { text-align: center !important; }
	.i, .s, .d, .m { text-align: center !important; }
	.m { width: 70px; word-wrap:break-word; }
	.n { text-align: center!important; }
	td { font-family: Tahoma, arial, times }
	span.logo { display: block; position: absolute; top: 0; left: 0; width: 200px; height: 56px; }
	.armstation { background-color: #f04848; }
	.foreigner { background-color: #F2DEDE /* #e6b9b8 */ }
	.internal { background-color: #D9EDF7 /* b6dde8 */ }
	.film { background-color: #DFF0D8 /* 99ff99 */ }
	.azaan { background-color: #f2e5da /* f79646 */ }
	.lullaby { background-color: #ece6f2 /* ccc0da */ }
	.table-condensed th, .table-condensed td { padding: 1px 4px !important; }
	tbody { font-size: 12px; line-height: 14px }
	.table * { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
	.occassion * { text-align: right !important; }
	.provinces { background-color: #AFEEEE; }
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
	#additional-info * { direction: rtl; text-align: right; }
	</style>
	<title>جدول پخش برنامه‌های شبکه پویا <?php echo $printDate; ?></title>
</head>
<body onload="window.print();">
<div class="schedules-table">
	<header>
		<span class="logo">
			<img src="/templates/pooya/img/print-logo.jpg" title="شبکه پویا" alt="شبکه پویا" />
		</span>
		<h3 class="title">جدول پخش برنامه‌ها:  <span style="direction: ltr; text-align: left"><?php echo $printDate; ?></span></h3>
	</header>
	<section id="parograms-table">
		<?php
		list($y, $m, $d) = explode('-', $dateValue);
		$y = tr_num($y, 'en');
		$m = tr_num($m, 'en');
		$d = tr_num($d, 'en');
		
		if ($y < 2012) {
			if (intval($y) != 0) {
				$date = jalali_to_gregorian($y, $m, $d, '-');
			}
		}
		$query = 'SELECT u.name, s.* FROM #__schedules AS s  LEFT JOIN #__users AS u ON u.id = s.modified_by WHERE s.date = "' . $date . '" AND s.state = 1';
		$db = JFactory::getDBO();
		$db->setQuery($query, 0, 1);
		$schedule = $db->loadObject();
		if (count($schedule)) { 
			$programs = json_decode($schedule->programs);
			$now = strtotime(date('H:i:s', time()));
			$onAirId = 999999; // Invalid program ID
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
			}
			$i = 0;
		?>
		<?php if (!empty($schedule->occassion)) { ?>
		<div class="clearfix"></div><br /><br />
		<table class="table table-condensed table-bordered occassion">
			<tbody>
				<tr>
					<td style="width: 15%;"><strong>مناسبت روز</strong></td>
					<td style="width: 85%;"><?php echo $schedule->occassion; ?></td>
				</tr>
			</tbody>
		</table>
		<div class="clearfix"></div>
		<?php } ?>
		<?php if (!empty($schedule->modified)) { ?>
		<?php 
			$modifiedDate = explode(' ', $schedule->modified);
			list($my, $mm, $md) = explode('-', $modifiedDate[0]);
			$modifiedJDate = gregorian_to_jalali($my, $mm, $md, '-');
		?>
		<div class="clearfix"></div>
		<table class="table table-condensed table-bordered occassion">
			<tbody>
				<tr>
					<td style="width: 15%;"><strong>آخرین ویرایش</strong></td>
					<td style="width: 85%;">
						<?php echo $modifiedJDate . ' ' . $modifiedDate[1]; ?>
						&nbsp;&nbsp;
						توسط
						&nbsp;
						<?php echo $schedule->name; ?>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="clearfix"></div>
		<?php } ?>
		<table class="table table-hover table-bordered programs-table table-condensed">
			<thead>
				<tr>
					<th class="i">ردیف</th>
					<th class="s">شروع</th>
					<th class="n">نام برنامه</th>
					<th class="d">مدت</th>
					<th class="i">نوع برنامه</th>
					<th class="i">شناسه برنامه</th>
					<th class="m">ملاحظات</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//print_r($programs);
				foreach ($programs as $item) {
					$i++;
					$trClass = ($item->id == $onAirId) ? ' now': '';
					$part = (!empty($item->part) || ($item->part != 0)) ? ' - قسمت ' . $item->part : '';
					$parts = (!empty($item->parts) || ($item->parts != 0)) ? ' ' . $item->parts : '';
					$partsOutput = (!empty($item->part) || !empty($item->parts)) ? $part . ' از ' . $parts : '';
					switch ($item->kind) {
						/* Old Types */
						case 'armstation': $item->pkind = 'وله و آرم'; break;
						case 'internal': $item->pkind = 'داخلی'; break;
						case 'foreigner': $item->pkind = 'خارجی'; break;
						case 'azaan': $item->pkind = 'اذانگاهی'; break;
						case 'film': $item->pkind = 'فیلم سینمایی'; break;
						case 'lullaby': $item->pkind = 'لالایی'; break;
						case 'provinces': $item->pkind = 'سیمای استان‌ها'; break;
						/* New Types */
						case 'movies': $item->pkind = 'سینمایی'; break; 
						case 'persian-series': $item->pkind = 'مجموعه ایرانی'; break;
						case 'foreigner-series': $item->pkind = 'مجموعه خارجی'; break;
						case 'prayer-time': $item->pkind = 'قرآن و اذان'; break;
						case 'armstations': $item->pkind = 'آرم استیشن'; break;
						case 'musical': $item->pkind = 'کلیپ موزیکال'; break;
						case 'announces': $item->pkind = 'تیزر و آنونس'; break;
						case 'specials': $item->pkind = 'ویژه برنامه ها'; break;
						case 'commercials': $item->pkind = 'آگهی بازرگانی'; break;
					}
				?>
				<?php
				// Backward compatibility for new times. Originally it was "99:99" and now it's "99:99:99"
				$explodedTime = explode(':', $item->time);
				if (count($explodedTime) == 2)
					$item->time = $item->time . ':00';
				?>
				<tr class="<?php echo $item->kind . $trClass; ?>">
					<td class="i"><?php echo $i; ?></td>
					<td class="s"><?php echo $item->time; ?></td>
					<td class="n"><?php echo $item->name . $partsOutput; ?></td>
					<td class="d"><?php echo $item->duration; ?></td>
					<td class="i"><?php echo $item->pkind; ?></td>
					<td class="i"><?php echo $item->uid; ?></td>
					<td class="m"><?php if (!empty($item->note)) { echo $item->note; } ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="colors-guide">
			<?php /*
			<br /><br />
			<!-- New Types -->
			<table class="table" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td class="foreigner-series">مجموعه خارجی</td>
						<td class="persian-series">مجموعه ایرانی</td>
						<td class="armstations">آرم استیشن و وله</td>
						<td class="movies">سینمایی</td>
						<td class="announces">تیزر، آنونس و اعلام برنامه</td>
						<td class="prayer-time">قرآن و اذان</td>
						<td class="musical">کلیپ موزیکال</td>
						<td class="commercials">آگهی بازرگانی</td>
						<td class="specials">ویژه برنامه ها</td>
					</tr>
				<tbody>
			</table>
			<!-- Old Types -->
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
		<div id="additional-info">
			<table class="table" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td>گرافیست</td>
					</tr>
					<tr>
						<td>ناظر پخش</td>
					</tr>
					<tr>
						<td>عوامل فنی</td>
					</tr>
					<tr>
						<td>ملاحظات</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php } else { ?>
		<div class="alert fade in">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>خطا!</strong> جدول پخش روز مورد نظر پیدا نشد.
		</div>
		<?php } ?>
	</section>
</div>
<?php JFactory::getApplication()->close(); ?>