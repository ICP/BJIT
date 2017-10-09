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
<div class="slideshow panorama">
	<div class="img">
		<img src="<?php echo JURI::base(); ?>assets/data/panorama.jpg" alt="Panorama" />
	</div>
	<div class="caption-container">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<h2><span>گذر زمان</span></h2>
				<div class="inner">
					<div class="controls">
						<span class="prev"><i class="icon-left"></i></span>
						<span class="next"><i class="icon-right"></i></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row items-holder">
		<div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
			<div class="inner">
				<ul class="items list-unstyled">
					<?php foreach ($items as $key=>$item) { ?>
						<li>
							<a href="<?php echo $item->link; ?>">
								<span class="thumb"><img alt="<?php echo $item->title; ?>" src="<?php echo $item->image; ?>" /></span>
								<span class="title"><?php echo $item->title; ?></span>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="preview" style="display: none;">
		<div class="inner" style="display: none;">
			<div class="close">&times;</div>
			<div class="player"></div>
		</div>
	</div>
</div>