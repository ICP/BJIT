<?php
/**
 * @version		$Id: default.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

if (count($items)) {
	$catimg = JURI::base() . 'media/k2/categories/' . $items[0]->categoryimg;
	?>
	<div class="box-wrapper special">
		<div class="cat-img grayscale">
			<img src="<?php echo $catimg; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($items[0]->categoryname); ?>" />
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<section class="box special<?php if ($params->get('moduleclass_sfx')) echo ' ' . $params->get('moduleclass_sfx'); ?>">
						<header><h2><span class="icon-holder"><i class="icon-click"></i></span><?php echo $module->title; ?></h2></header>
						<div class="row">
							<div class="cat-desc col-sm-6 col-md-4">
								<h3><a href="<?php echo $items[0]->categoryLink ?>"><?php echo $items[0]->categoryname; ?></a></h3>
								<div class="introtext"><?php echo $items[0]->categorydesc; ?></div>
								<a class="more" href="<?php echo $items[0]->categoryLink ?>"><i class="icon-left-circle"></i> بیشتر</a>
							</div>
							<div class="cat-thumb col-sm-6 col-md-4">
								<figure>
									<a href="<?php echo $items[0]->categoryLink; ?>">
										<img src="<?php echo $catimg; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($items[0]->categoryname); ?>" />
									</a>
								</figure>
							</div>
							<div class="cat-items hidden-sm col-md-4">
								<div class="carousel">
									<ul>
										<?php foreach ($items as $key => $item) { ?>
											<li>
												<?php if ($params->get('itemImage') || $params->get('itemIntroText')) { ?>
													<?php if ($params->get('itemImage') && isset($item->image)) { ?>
														<figure>
															<a href="<?php echo $item->link; ?>">
																<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
															</a>
														</figure>
													<?php } ?>
													<?php if ($params->get('itemTitle')) { ?>
														<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
													<?php } ?>
												<?php } ?>
											</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<?php
}