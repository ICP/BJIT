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

// Get user stuff (do not change)
$user = JFactory::getUser();
?>

<section class="itemlist user-posts">
	<section class="box user-info">
		<div>
			<?php if ($this->params->get('userFeedIcon', 1)) { ?>
				<a class="feed-icon" href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
					<i class="icon-rss-squared"></i>
				</a>
			<?php } ?>
			<?php if ($this->params->get('userImage') && !empty($this->user->avatar)) { ?>
				<div class="avatar">
					<img src="<?php echo $this->user->avatar; ?>" alt="<?php echo htmlspecialchars($this->user->name, ENT_QUOTES, 'UTF-8'); ?>" />
				</div>
			<?php } ?>
			<?php if ($this->params->get('userName')) { ?>
				<h2><?php echo $this->user->name; ?></h2>
			<?php } ?>
			<?php if ($this->params->get('userDescription') && trim($this->user->profile->description)) { ?>
				<div class="userDescription"><?php echo $this->user->profile->description; ?></div>
			<?php } ?>
		</div>
	</section>
	<?php echo $this->user->event->K2UserDisplay; ?>
	<?php if (count($this->items)) { ?>
		<section class="box articles highlights">
			<div>
				<ul>
					<?php foreach ($this->items as $item) { ?>
						<li class="item">
							<?php echo $item->event->BeforeDisplay; ?>
							<?php echo $item->event->K2BeforeDisplay; ?>
							<?php if ($this->params->get('userItemImage') && !empty($item->imageGeneric)) { ?>
								<figure class="img">
									<a href="<?php echo $item->link; ?>">
										<img src="<?php echo $item->imageGeneric; ?>" alt="<?php if (!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption);
					else echo K2HelperUtilities::cleanHtml($item->title); ?>" />
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
								<?php echo $item->event->AfterDisplayTitle; ?>
								<?php echo $item->event->K2AfterDisplayTitle; ?>
								<?php echo $item->event->BeforeDisplayContent; ?>
									<?php echo $item->event->K2BeforeDisplayContent; ?>
									<?php if ($item->params->get('userItemIntroText')) { ?>
									<div class="introtext">
									<?php echo $item->introtext; ?>
									</div>
								<?php } ?>
								<?php echo $item->event->AfterDisplayContent; ?>
		<?php echo $item->event->K2AfterDisplayContent; ?>
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
		<?php echo $item->event->AfterDisplay; ?>
						<?php echo $item->event->K2AfterDisplay; ?>

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

