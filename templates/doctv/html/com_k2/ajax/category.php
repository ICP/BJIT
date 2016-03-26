<?php
/**
 * @version		$Id: category.php 1618 2012-09-21 11:23:08Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
?>
<div id="category">
	<?php if ($this->params->get('show_page_title')): ?>
		<div class="componentheading<?php echo $this->params->get('pageclass_sfx') ?>">
			<?php echo $this->escape($this->params->get('page_title')); ?>
		</div>
	<?php endif; ?>
	<?php if ($this->params->get('catFeedIcon')): ?>
		<div class="feed-link hide">
			<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
				<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
			</a>
		</div>
	<?php endif; ?>
	<?php if ((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))): ?>
		<!-- Item list -->
		<div class="items">
			<?php if (isset($this->leading) && count($this->leading)): ?>
				<!-- Leading items -->
				<div id="itemListLeading">
					<?php foreach ($this->leading as $key => $item): ?>
						<?php
						// Define a CSS class for the last container on each row
						if ((($key + 1) % ($this->params->get('num_leading_columns')) == 0) || count($this->leading) < $this->params->get('num_leading_columns'))
							$lastContainer = ' itemContainerLast';
						else
							$lastContainer = '';
						?>

						<div class="itemContainer<?php echo $lastContainer; ?>"<?php echo (count($this->leading) == 1) ? '' : ' style="width:' . number_format(100 / $this->params->get('num_leading_columns'), 1) . '%;"'; ?>>
							<?php
							// Load category_item.php by default
							$this->item = $item;
							echo $this->loadTemplate('item');
							?>
						</div>
						<?php if (($key + 1) % ($this->params->get('num_leading_columns')) == 0): ?>
							<div class="clr"></div>
						<?php endif; ?>
					<?php endforeach; ?>
					<div class="clr"></div>
				</div>
			<?php endif; ?>
			<?php if (isset($this->primary) && count($this->primary)) { ?>
				<?php
				$characters = array('sloth', 'fatcat', 'sheep', 'mushroom', 'bees', 'sable', 'cat', 'cloud', 'mosquito', 'momcat');
				shuffle($characters);
				?>
				<?php foreach ($this->primary as $key => $item) { ?>
					<div class="item">
						<div class="inner <?php echo $float = ($key % 2 == 0) ? 'right' : 'left'; ?>">
							<?php
							$this->item = $item;
							echo $this->loadTemplate('item');
							?>
						</div>
						<div class="clearfix"></div>
					</div>
				<?php } ?>
			<?php } ?>
			<?php if (isset($this->secondary) && count($this->secondary)): ?>
				<!-- Secondary items -->
				<div id="itemListSecondary">
					<?php foreach ($this->secondary as $key => $item): ?>

						<?php
						// Define a CSS class for the last container on each row
						if ((($key + 1) % ($this->params->get('num_secondary_columns')) == 0) || count($this->secondary) < $this->params->get('num_secondary_columns'))
							$lastContainer = ' itemContainerLast';
						else
							$lastContainer = '';
						?>

						<div class="itemContainer<?php echo $lastContainer; ?>"<?php echo (count($this->secondary) == 1) ? '' : ' style="width:' . number_format(100 / $this->params->get('num_secondary_columns'), 1) . '%;"'; ?>>
							<?php
							// Load category_item.php by default
							$this->item = $item;
							echo $this->loadTemplate('item');
							?>
						</div>
						<?php if (($key + 1) % ($this->params->get('num_secondary_columns')) == 0): ?>
							<div class="clr"></div>
						<?php endif; ?>
					<?php endforeach; ?>
					<div class="clr"></div>
				</div>
			<?php endif; ?>
			<?php if (isset($this->links) && count($this->links)): ?>
				<!-- Link items -->
				<div id="itemListLinks">
					<h4><?php echo JText::_('K2_MORE'); ?></h4>
					<?php foreach ($this->links as $key => $item): ?>
						<?php
						// Define a CSS class for the last container on each row
						if ((($key + 1) % ($this->params->get('num_links_columns')) == 0) || count($this->links) < $this->params->get('num_links_columns'))
							$lastContainer = ' itemContainerLast';
						else
							$lastContainer = '';
						?>
						<div class="itemContainer<?php echo $lastContainer; ?>"<?php echo (count($this->links) == 1) ? '' : ' style="width:' . number_format(100 / $this->params->get('num_links_columns'), 1) . '%;"'; ?>>
							<?php
							// Load category_item_links.php by default
							$this->item = $item;
							echo $this->loadTemplate('item_links');
							?>
						</div>
						<?php if (($key + 1) % ($this->params->get('num_links_columns')) == 0): ?>
							<div class="clr"></div>
						<?php endif; ?>
					<?php endforeach; ?>
					<div class="clr"></div>
				</div>
			<?php endif; ?>
		</div>
		<?php if (count($this->pagination->getPagesLinks())): ?>
			<div id="itemlist-pagination" class="pagination pagination-right">
				<?php if ($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
			</div>
			<?php if ($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?>
		<?php endif; ?>
	<?php endif; ?>
</div>
<!-- End K2 Category Layout -->
