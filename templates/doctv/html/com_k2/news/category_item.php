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
// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);
?>
<?php echo $this->item->event->BeforeDisplay; ?>
<?php echo $this->item->event->K2BeforeDisplay; ?>
<?php if ($this->item->params->get('catItemImage') && !empty($this->item->image)) { ?>
	<figure class="img">
		<a href="<?php echo $this->item->link; ?>">
			<img src="<?php echo $this->item->image; ?>" alt="<?php
			if (!empty($this->item->image_caption))
				echo K2HelperUtilities::cleanHtml($this->item->image_caption);
			else
				echo K2HelperUtilities::cleanHtml($this->item->title);
			?>" />
		</a>
	</figure>
<?php } ?>
<div class="desc">
	<div class="item-header">
		<?php if ($this->item->params->get('catItemTitle')) { ?>
			<h3 class="item-title">
				<?php if ($this->item->params->get('catItemTitleLinked')) { ?>
					<a href="<?php echo $this->item->link; ?>">
						<?php
						$extra_fields = json_decode($this->item->extra_fields);
						if (count($extra_fields)) {
							?>
							<small><?php echo $extra_fields[0]->value; ?></small>
						<?php } ?>
						<?php echo $this->item->title; ?>
					</a>
				<?php } else { ?>
					<?php echo $this->item->title; ?>
				<?php } ?>
			</h3>
		<?php } ?>
		<?php if ($this->item->params->get('catItemAuthor')) { ?>
			<div class="author">
				<?php echo K2HelperUtilities::writtenBy($this->item->author->profile->gender); ?>
				<?php if (isset($this->item->author->link) && $this->item->author->link) { ?>
					<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
				<?php } else { ?>
					<?php echo $this->item->author->name; ?>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<?php echo $this->item->event->AfterDisplayTitle; ?>
	<?php echo $this->item->event->K2AfterDisplayTitle; ?>
	<?php echo $this->item->event->BeforeDisplayContent; ?>
	<?php echo $this->item->event->K2BeforeDisplayContent; ?>
	<?php if ($this->item->params->get('catItemIntroText')) { ?>
		<div class="introtext">
			<?php echo $this->item->introtext; ?>
		</div>
	<?php } ?>
	<?php echo $this->item->event->AfterDisplayContent; ?>
	<?php echo $this->item->event->K2AfterDisplayContent; ?>
	<?php if ($this->item->params->get('catItemCategory')) { ?>
		<div class="item-category">
			<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
			<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
		</div>
	<?php } ?>
	<?php if ($this->item->params->get('catItemDateCreated')) { ?>
		<time class="created"><?php echo JHTML::_('date', $this->item->created, JText::_('K2_DATE_FORMAT_LC2')); ?></time>
		<?php } ?>
</div>
<?php echo $this->item->event->AfterDisplay; ?>
<?php echo $this->item->event->K2AfterDisplay; ?>