<?php
defined('_JEXEC') or die;

if (!class_exists('jDateTime'))
	include JPATH_LIBRARIES . DS . 'vendor' . DS . 'jdate' . DS . 'jdatetime.class.php';
new jDateTime(false);

if (!function_exists('limitParagraphs')) {

	function limitParagraphs($sHTML, $iLimit = 1) {
		if (1 === preg_match('~(<p>.+?</p>){' . (int) $iLimit . '}~i', $sHTML, $aMatches)) {
			return $aMatches[0];
		}
		return $sHTML;
	}

}

$jinput = JFactory::getApplication()->input;
$date = $jinput->get('date', date('Y-m-d', time()), 'string');
$items = $this->getItems($date);
$time = strtotime($date);
$jdate_full = jDateTime::date('l d F', $time);
$current_date = [(int) jDateTime::date('Y', $time), (int) jDateTime::date('m', $time), (int) jDateTime::date('d', $time)];
?>
<section class="box schedule-table">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-9">
			<small class="schedule-header-date"><?php echo $jdate_full; ?></small>
			<?php if (count($items)) { ?>
				<ul class="program-table">
					<?php foreach ($items as $item) { ?>
						<li<?php echo ($item->current) ? ' class="active"' : ''; ?>>
							<div class="time">
								<span><?php echo $item->start_small; ?></span>
							</div>
							<div class="inner">
								<figure>
									<?php if ($item->link) { ?><a href="<?php echo $item->link; ?>"><?php } ?>
										<img src="<?php echo ($item->thumb) ? $item->thumb : JUri::root() . 'assets/img/placeholder.png'; ?>" alt="<?php echo $item->title; ?>" />
										<?php if ($item->link) { ?></a><?php } ?>
								</figure>
								<div class="desc">
									<h3>
										<?php if ($item->link) { ?><a href="<?php echo $item->link; ?>"><?php } ?>
											<?php echo $item->title; ?>
											<?php if ($item->link) { ?></a><?php } ?>
									</h3>
									<p><?php echo limitParagraphs($item->introtext, 1); ?></p>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
				<div class="alert alert-warning">اطلاعات مربوط به جدول پخش این روز موجود نیست</div>
			<?php } ?>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-3">
			<div class="schedule-sidebar">
				<div class="inner">
					<form id="load-schedule" action="<?php echo JUri::current(); ?>" method="get">
						<input id="date-input" type="hidden" name="date" value="" />
					</form>
					<aside id="datepicker" data-current='<?php echo json_encode($current_date); ?>'></aside>
					<div class="clearfix"></div>
					<a href="<?php echo JUri::root() ?>live" class="btn btn-block btn-default"><i class="icon-live"></i> پخش زنده</a>
				</div>
			</div>
		</div>
	</div>
</section>