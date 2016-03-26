<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
?>
<div class="panel content">
	<div class="panel-body">
		<div class="close-pane">&times;</div>
		<?php if (count($items)) { ?>
		<ul class="items list-unstyled">
			<?php foreach ($items as $key => $item) { ?>
			<li>
				<div class="player">
					<?php echo $item->event->BeforeDisplay; ?>
					<?php echo $item->event->K2BeforeDisplay; ?>
					<?php if ($params->get('itemImage') && isset($item->image)) { ?>
					<div class="img">
						<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" />
					</div>
					<?php } ?>
				</div>
				<?php echo $item->event->AfterDisplay; ?>
				<?php echo $item->event->K2AfterDisplay; ?>
			</li>
			<?php } // forach [items] ?>
		</ul>
		<?php } // if [count items] ?>
		<div class="sidebar">
			<div class="subcategories">
				<ul class="list-unstyled">
					<li>
						<a href="<?php echo JURI::base() . 'content/natural-heritage'; ?>" data-catid="12">
							<span class="title">میراث معنوی و طبیعی</span>
						</a>
					</li>
					<li>
						<a href="<?php echo JURI::base() . 'content/global-heritage'; ?>" data-catid="13">
							<span class="title">میراث جهانی</span>
						</a>
					</li>
					<li>
						<a href="<?php echo JURI::base() . 'content/the-mosts'; ?>" data-catid="14">
							<span class="title">ترین‌ها</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="itemlist"></div>
</div>