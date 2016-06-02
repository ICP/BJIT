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
if (stristr($this->category->alias, "product")) {
	if (isset($this->category->description) && strip_tags($this->category->description) !== "") {
		echo '<div class="hide page-slogan">' . $this->category->description . '</div>';
	}
}
?>
<div class="box-wrapper programs">
		<div class="page-tools">
			<ul class="list-unstyled list-inline order-style">
				<li>نحوه نمایش:</li>
				<li><span class="clickable" data-style="list"><i class="icon-list"></i></span></li>
				<li class="active"><span class="clickable" data-style="grid"><i class="icon-th"></i></span></li>
			</ul>
		</div>
	<?php if (isset($this->secondary) && count($this->secondary)) { ?>
		<section class="box episodes tiles highlights latest grid">
			<div>
				<ul>
					<?php
					foreach ($this->secondary as $key => $item) {
						$media = !empty($item->video) ? ' video' : '';
						$media .=!empty($item->gallery) ? ' gallery' : '';
						$modified = ($item->modified != $this->nullDate && $item->modified != $item->created) ? JHTML::_('date', $item->modified, JText::_('K2_DATE_FORMAT_LC2')) : '';
						?>
						<li class="item<?php $media; ?><?php echo ($item->featured) ? ' featured' : ''; ?><?php if ($item->params->get('pageclass_sfx')) echo ' ' . $item->params->get('pageclass_sfx'); ?>" data-hits="<?php echo $item->hits; ?>">
							<?php
							$this->item = $item;
							echo $this->loadTemplate('item');
							?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</section>
	<?php } ?>
</div>