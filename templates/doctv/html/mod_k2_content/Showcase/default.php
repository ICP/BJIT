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
<div class="slideshow">
	<div class="caption-container">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<div class="inner">
					<div class="controls">
						<span class="prev"><i class="icon-left"></i></span>
						<span class="next"><i class="icon-right"></i></span>
					</div>
					<ul class="sharings list-unstyled list-inline text-center">
						<!--<li><a href="<?php echo JURI::base(); ?>"><i class="icon-instagram"></i></a></li>-->
						<li><a target="_blank" href="https://www.facebook.com/%D8%B4%D8%A8%DA%A9%D9%87-%D9%85%D8%B3%D8%AA%D9%86%D8%AF-%D8%B3%DB%8C%D9%85%D8%A7-1409575439340446/"><i class="icon-facebook"></i></a></li>
						<li><a target="_blank" href="https://www.youtube.com/channel/UC6m7kHAMbPhx6XtxZd9HM_g"><i class="icon-youtube"></i></a></li>
						<!--<li><a href="#"><i class="icon-twitter"></i></a></li>-->
						<li><a target="_blank" href="https://vimeo.com/user35891422"><i class="icon-vimeo"></i></a></li>
						<li><a target="_blank" href="https://plus.google.com/u/0/109499617150127549017/posts"><i class="icon-gplus"></i></a></li>
						<li><a target="_blank" href="http://www.aparat.com/mostanadsaz"><i class="icon-aparat"></i></a></li>
						<!--<li><a target="_blank" href="http://net.tebyan.net/pages/mostanad"><i class="icon-tebiyan"></i></a></li>-->
					</ul>
					<div class="pages"></div>
				</div>
			</div>
		</div>
	</div>
	<?php if (count($items)) { ?>
		<ul class="items list-unstyled">
			<?php foreach ($items as $key => $item) { ?>
				<li data-created="<?php echo JHTML::_('date', $item->created, JText::_('K2_DATE_FORMAT_LC2')); ?>">
					<?php echo $item->event->BeforeDisplay; ?>
					<?php echo $item->event->K2BeforeDisplay; ?>
					<?php if ($params->get('itemImage') && isset($item->image)) { ?>
						<div class="img">
							<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" />
						</div>
					<?php } ?>
					<div class="desc">
						<div class="row">
							<div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
								<div class="inner">
									<?php if ($params->get('itemTitle')) { ?><h2><span><?php echo $item->title; ?></span></h2><?php } ?>
									<?php echo $item->event->AfterDisplayTitle; ?>
									<?php echo $item->event->K2AfterDisplayTitle; ?>
									<?php echo $item->event->BeforeDisplayContent; ?>
									<?php echo $item->event->K2BeforeDisplayContent; ?>
									<?php if ($params->get('itemIntroText')) { ?>
										<?php if ($item->video) { ?>
											<div class="video-container hide" data-video="<?php echo $item->video; ?>">
												<img src="<?php echo str_replace('_XL', '_S', $item->image); ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" />
											</div>
										<?php } ?>
										<?php echo $item->introtext; ?>
										<?php if ($item->video) { ?>
											<div class="video-container text-center" data-video="<?php echo $item->video; ?>">
												<i class="icon-play"></i>
												<img src="<?php echo str_replace('_XL', '_S', $item->image); ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" class="hide" />
											</div>
										<?php } ?>
									<?php } ?>
									<?php echo $item->event->AfterDisplayContent; ?>
									<?php echo $item->event->K2AfterDisplayContent; ?>
								</div>
							</div>
						</div>
					</div>
					<?php echo $item->event->AfterDisplay; ?>
					<?php echo $item->event->K2AfterDisplay; ?>
				</li>
			<?php } // forach [items] ?>
		</ul>
	<?php } // if [count items] ?>
</div>