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

$request = JFactory::getApplication()->input;
$limitstart = $request->getInt('limitstart', null);
if ($limitstart && $limitstart > 0) {
	$itemlist = array();
	if (isset($this->leading) && count($this->leading)) {
		foreach ($this->leading as $k => $v) {
			$itemlist[] = $v;
		}
		$this->leading = null;
	}
	if (isset($this->primary) && count($this->primary)) {
		foreach ($this->primary as $k => $v) {
			$itemlist[] = $v;
		}
		$this->primary = null;
	}
	if (isset($this->secondary) && count($this->secondary)) {
		foreach ($this->secondary as $k => $v) {
			$itemlist[] = $v;
		}
		$this->secondary = $itemlist;
	}
}
?>
<div id="category" class="itemlist<?php if ($this->params->get('pageclass_sfx')) echo ' ' . $this->params->get('pageclass_sfx'); ?>">
	<?php if ((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))) { ?>
		<?php if (isset($this->leading) && count($this->leading)) { ?>
			<section class="box content blog">
				<ul class="slider items-carousel blog-posts">
				<?php
				foreach ($this->leading as $key => $item) {
					$media = !empty($item->video) ? ' video' : '';
					$media .=!empty($item->gallery) ? ' gallery' : '';
					$modified = ($item->modified != $this->nullDate && $item->modified != $item->created) ? JHTML::_('date', $item->modified, JText::_('K2_DATE_FORMAT_LC2')) : '';
					?>
					<li class="group-<?php echo $item->itemGroup . $media; ?><?php echo ($item->featured) ? ' featured' : ''; ?>" data-hits="<?php echo $item->hits; ?>">
						<?php
						$this->item = $item;
						$this->item->showMoreLink = true;
						echo $this->loadTemplate('item');
						?>
					</article>
				<?php } ?>
					</ul>
			</section>
		<?php } ?>
		<?php if (isset($this->primary) && count($this->primary)) { ?>
			<div class="box articles blog secondary">
				<?php foreach ($this->primary as $key => $item) { ?>
					<article class="item">
						<?php
						$this->item = $item;
//						var_dump($item);
//						$this->item->created = $item->created;
						echo $this->loadTemplate('item');
						?>
					</article>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if (isset($this->secondary) && count($this->secondary)) { ?>
			<div class="box articles highlights">
				<?php
				foreach ($this->secondary as $key => $item) {
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
		<?php if (isset($this->links) && count($this->links)) { ?>
			<div class="box list-items">
				<h4><?php echo JText::_('K2_MORE'); ?></h4>
				<ul>
					<?php
					foreach ($this->links as $key => $item) {
						$media = !empty($item->video) ? ' video' : '';
						$media .=!empty($item->gallery) ? ' gallery' : '';
						$modified = ($item->modified != $this->nullDate && $item->modified != $item->created) ? JHTML::_('date', $item->modified, JText::_('K2_DATE_FORMAT_LC2')) : '';
						?>
						<li class="<?php echo $media; ?><?php echo ($item->featured) ? ' featured' : ''; ?><?php if ($item->params->get('pageclass_sfx')) echo ' ' . $item->params->get('pageclass_sfx'); ?>" data-hits="<?php echo $item->hits; ?>">
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
			<div class="text-center"><?php if ($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?></div>
			<nav><?php if ($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?></nav>
		<?php } ?>
	<?php } ?>
</div>