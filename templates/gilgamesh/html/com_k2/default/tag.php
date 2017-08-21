<?php
/**
 * @version    2.7.x
 * @package    K2
 * @author     JoomlaWorks http://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2016 JoomlaWorks Ltd. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
?>
<section class="itemlist tag-posts">
	<section class="box user-info tag-info">
		<div>
			<?php if ($this->params->get('userFeedIcon', 1)) { ?>
				<a class="feed-icon" href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
					<i class="icon-rss-squared"></i>
				</a>
			<?php } ?>
			<h2><?php echo $this->escape($this->params->get('page_title')); ?></h2>
		</div>
	</section>
	<?php if (count($this->items)) { ?>
		<section class="box articles highlights">
			<div>
				<ul>
					<?php foreach ($this->items as $item) { ?>
						<li class="item">
							<?php if ($this->params->get('userItemImage') && !empty($item->imageGeneric)) { ?>
								<figure class="img">
									<a href="<?php echo $item->link; ?>">
										<img src="<?php echo $item->imageGeneric; ?>" alt="<?php
										if (!empty($item->image_caption))
											echo K2HelperUtilities::cleanHtml($item->image_caption);
										else
											echo K2HelperUtilities::cleanHtml($item->title);
										?>" />
									</a>
								</figure>
							<?php } ?>
							<div class="desc">
								<div class="item-header">
									<?php if ($item->params->get('userItemTitle')) { ?>
										<h3 class="item-title">
											<?php if ($item->params->get('userItemTitleLinked')) { ?>
												<a href="<?php echo $item->link; ?>">
													<?php echo $item->title; ?>
												</a>
											<?php } else { ?>
												<?php echo $item->title; ?>
											<?php } ?>
										</h3>
									<?php } ?>
								</div>
								<?php if ($item->params->get('userItemIntroText')) { ?>
									<div class="introtext">
										<?php echo $item->introtext; ?>
									</div>
								<?php } ?>
								<?php if ($item->params->get('userItemCategory')) { ?>
									<div class="item-category">
										<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
										<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
									</div>
								<?php } ?>
								<?php if ($item->params->get('userItemDateCreated')) { ?>
									<time class="created"><?php echo JHTML::_('date', $item->created, JText::_('K2_DATE_FORMAT_LC2')); ?></time>
								<?php } ?>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
		</section>
	<?php } ?>
</section>

<?php if (count($this->pagination->getPagesLinks())) { ?>
	<div class="k2Pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
<?php } ?>