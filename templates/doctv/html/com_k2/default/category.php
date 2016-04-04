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
<div id="category" class="itemlist<?php if ($this->params->get('pageclass_sfx')) echo ' ' . $this->params->get('pageclass_sfx'); ?>">
	<?php if ((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))) { ?>
		<?php if (isset($this->leading) && count($this->leading)) { ?>
			<div class="box top-news">
				<?php
				foreach ($this->leading as $key => $item) {
					$media = !empty($item->video) ? ' video' : '';
					$media .=!empty($item->gallery) ? ' gallery' : '';
					$modified = ($item->modified != $this->nullDate && $item->modified != $item->created) ? JHTML::_('date', $item->modified, JText::_('K2_DATE_FORMAT_LC2')) : '';
					?>
					<article class="item group-<?php echo $item->itemGroup . $media; ?><?php echo ($item->featured) ? ' featured' : ''; ?><?php if ($item->params->get('pageclass_sfx')) echo ' ' . $item->params->get('pageclass_sfx'); ?>" data-hits="<?php echo $item->hits; ?>">
						<?php
						$this->item = $item;
						echo $this->loadTemplate('item');
						?>
					</article>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if (isset($this->primary) && count($this->primary)) { ?>
			<div class="secondary">
				<?php foreach ($this->primary as $key => $item) { ?>
					<article class="item">
						<?php
						$this->item = $item;
						echo $this->loadTemplate('item');
						?>
					</article>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if (isset($this->secondary) && count($this->secondary)) { ?>
			<div class="highlights">
				<?php foreach ($this->secondary as $key => $item) { ?>
					<article class="item">
						<?php
						$this->item = $item;
						echo $this->loadTemplate('item');
						?>
					</article>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if (isset($this->links) && count($this->links)) { ?>
			<div class="list-items">
				<h4><?php echo JText::_('K2_MORE'); ?></h4>
				<ul>
					<?php foreach ($this->links as $key => $item) { ?>
						<li>
							<?php
							$this->item = $item;
							echo $this->loadTemplate('item');
							?>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
		<?php if ($this->pagination->getPagesLinks()) { ?>
			<div class="paging">
				<?php if ($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
				<?php if ($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?>
			</div>
		<?php } ?>
	<?php } ?>
</div>