<?php
// no direct access
defined('_JEXEC') or die;

$status	= homepageCallback::getList();
$today = date("Y-m-d", time());
if (!function_exists('gregorian_to_jalali')) {
	include_once JPATH_BASE . '/modules/mod_programs_table/assets/jdf.php';
}
$jDate = jdate("l، j F Y");
?>
<?php if ($status[0]) { ?>
	<?php
	@$b2part = ($status[1]['before2']['part'] == 0) ? '' : " - " . $status[1]['before2']['part'];
	@$bpart = ($status[1]['before']['part'] == 0) ? '' : " - " . $status[1]['before']['part'];
	@$opart = ($status[1]['now']['part'] == 0) ? '' : " - " . $status[1]['now']['part'];
	@$npart = ($status[1]['next']['part'] == 0) ? '' : " - " . $status[1]['next']['part'];
	@$n2part = ($status[1]['next2']['part'] == 0) ? '' : " - " . $status[1]['next2']['part'];
	
	@$b2title = ($status[1]['before2']['link'] == false) ? $status[1]['before2']['name'] : '<a href="' . $status[1]['before2']['link'] . '" title="' . $status[1]['before2']['name'] . '">' . $status[1]['before2']['name'] . '</a>';
	@$btitle = ($status[1]['before']['link'] == false) ? $status[1]['before']['name'] : '<a href="' . $status[1]['before']['link'] . '" title="' . $status[1]['before']['name'] . '">' . $status[1]['before']['name'] . '</a>';
	@$otitle = ($status[1]['now']['link'] == false) ? $status[1]['now']['name'] : '<a href="' . $status[1]['now']['link'] . '" title="' . $status[1]['now']['name'] . '">' . $status[1]['now']['name'] . '</a>';
	@$ntitle = ($status[1]['next']['link'] == false) ? $status[1]['next']['name'] : '<a href="' . $status[1]['next']['link'] . '" title="' . $status[1]['next']['name'] . '">' . $status[1]['next']['name'] . '</a>';
	@$n2title = ($status[1]['next2']['link'] == false) ? $status[1]['next2']['name'] : '<a href="' . $status[1]['next2']['link'] . '" title="' . $status[1]['next2']['name'] . '">' . $status[1]['next2']['name'] . '</a>';
	?>
		<table class="program-table table table-hover">
			<tbody>
				<?php if (isset($status[1]['before'])) { ?>
				<tr class="<?php echo $status[1]['before']['kind']; ?>">
					<td class="icon">
					</td>
					<td class="guide">
						<strong>قبلی</strong>
						
					</td>
					<td>
						<?php /* echo $btitle . $bpart; */ ?>
						<?php echo $status[1]['before']['time'] . ' - ' . $btitle; ?>
					</td>
				</tr>
				<?php } ?>
				<tr class="<?php echo $status[1]['now']['kind']; ?> now">
					<td class="icon">
						<span class="icon-arrow-left"></span>
					</td>
					<td class="guide">
						<strong>همین الان</strong>
					</td>
					<td>
						<?php // echo $otitle . $opart; ?>
						<?php echo $status[1]['now']['time'] . ' - ' . $otitle; ?>
					</td>
				</tr>
				<?php if (isset($status[1]['next'])) { ?>
				<tr class="<?php echo $status[1]['next']['kind']; ?>">
					<td class="icon">
					</td>
					<td class="guide">
						<strong>بعدی</strong>
					</td>
					<td>
						<?php // echo $ntitle . $npart; ?>
						<?php echo $status[1]['next']['time'] . ' - ' . $ntitle; ?>
					</td>
				</tr>
				<?php } ?>
				<?php if (isset($status[1]['next2'])) { ?>
				<tr class="<?php echo $status[1]['next2']['kind']; ?>">
					<td class="icon">
					</td>
					<td class="guide">
						<strong>دوتا بعدی</strong>
					</td>
					<td>
						<?php // echo $n2title . $n2part; ?>
						<?php echo $status[1]['next2']['time'] . ' - ' . $n2title; ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php /*
		<span class="program-table-link">
			<a href="/programs-table">جدول روزانه برنامه‌ها</a>
		</span>
		*/ ?>
		<div class="clear"></div>
<?php
	} else {
		switch ($status[1]) {
			case 'no-schedules':
				$message = 'اطلاعات مربوط به برنامه کنونی موجود نیست';
				break;
			case 'not-onair':
			$message = '<div class="not-on-air"><span class="icon-arrow-left"></span>&nbsp;شبکه کودک و نوجوان هم اکنون پخش ندارد!<br /><h4>برنامه های این شبکه را هر روز از ساعت 8 صبح تا 22 از تلویزیون دیجیتال دنبال کنید.</h4></div>';
				break;
		}
		echo $message;
	}
?>