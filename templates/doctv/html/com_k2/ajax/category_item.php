<?php
/**
 * @version		$Id: category_item.php 1766 2012-11-22 14:10:24Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;

// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);
?>
<?php echo $this->item->event->BeforeDisplay; ?>
<?php echo $this->item->event->K2BeforeDisplay; ?>
<div class="img">
	<?php echo $this->item->event->BeforeDisplayContent; ?>
	<?php echo $this->item->event->K2BeforeDisplayContent; ?>
	<?php if ($this->item->params->get('catItemImage') && !empty($this->item->image)): ?>
		<a href="<?php echo $this->item->link; ?>" title="<?php
		if (!empty($this->item->image_caption))
			echo K2HelperUtilities::cleanHtml($this->item->image_caption);
		else
			echo K2HelperUtilities::cleanHtml($this->item->title);
		?>">
			<img src="<?php echo $this->item->image; ?>" alt="<?php
			if (!empty($this->item->image_caption))
				echo K2HelperUtilities::cleanHtml($this->item->image_caption);
			else
				echo K2HelperUtilities::cleanHtml($this->item->title);
			?>" />
		</a>
	<?php endif; ?>
</div>
<div class="desc">
	<?php if ($this->item->params->get('catItemDateCreated')): ?>
		<span class="item-date">
			<?php echo JHTML::_('date', $this->item->created, JText::_('K2_DATE_FORMAT_LC2')); ?>
		</span>
	<?php endif; ?>
	<?php if ($this->item->params->get('catItemTitle')): ?>
		<h3 class="item-title">
			<?php if ($this->item->params->get('catItemTitleLinked')): ?>
				<a href="<?php echo $this->item->link; ?>">
					<?php echo $this->item->title; ?>
				</a>
			<?php else: ?>
				<?php echo $this->item->title; ?>
			<?php endif; ?>
		</h3>
	<?php endif; ?>
	<?php echo $this->item->event->AfterDisplayTitle; ?>
	<?php echo $this->item->event->K2AfterDisplayTitle; ?>
	<?php if ($this->item->params->get('catItemIntroText')): ?>
		<div class="item-text">
			<?php echo $this->item->introtext; ?>
			
			<div class="clearfix"></div>
			<?php if (!empty($this->item->attachments)) { ?>
			<?php if ($this->item->params->get('itemAttachments') && count($this->item->attachments)) { ?>
				<div class="item-attachments">
					<!--<h4>پیوست‌ها</h4>-->
					<?php foreach ($this->item->attachments as $attachment) { ?>
						<a class="btn btn-warning" target="_blank" title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>">
							<?php echo $attachment->title; ?> <i class="icon-download"></i>
						</a>
						<?php if ($this->item->params->get('itemAttachmentsCounter')) { ?>
								<!--<span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits == 1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>-->
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
	<?php endif; ?>
	<?php echo $this->item->event->AfterDisplayContent; ?>
	<?php echo $this->item->event->K2AfterDisplayContent; ?>
	<?php if ($this->item->params->get('catItemReadMore')): ?>
		<a class="more" href="<?php echo $this->item->link; ?>">
			<?php echo JText::_('K2_READ_MORE'); ?>
		</a>
	<?php endif; ?>
</div>
<?php echo $this->item->event->AfterDisplay; ?>
<?php echo $this->item->event->K2AfterDisplay; ?>