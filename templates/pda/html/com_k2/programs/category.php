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

if (!function_exists('sortByHits')) {

	function sortByHits($items) {
		usort($items, function($a, $b) {
			return($a->hits < $b->hits);
		});
		return $items;
	}

}

$app = JFactory::getApplication();
$request = $app->input;
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
if (count($this->secondary) === 1) {
	header('Location: ' . $this->secondary[0]->link, true, 303);
	exit();
}

// Categories slicing and pagination
jimport('joomla.html.pagination');
$program_count = isset($this->subCategories) ? count($this->subCategories) : null;
if ($program_count) {
	$this->subCategories = array_reverse($this->subCategories);
	$start = ($limitstart && $limitstart > 0) ? $limitstart : 0;
	$offset = ($start == 0) ? 31 : 30;
	$pageNav = new JPagination(count($this->subCategories), $start, $offset);
	$start_key = ($start == 0) ? 0 : -1;
	$this->subCategories = array_slice($this->subCategories, $start, $offset);
}

$most_viewed = sortByHits($this->secondary);
?>
<div class="box-wrapper programs">
	<div id="category" class="itemlist<?php if ($this->params->get('pageclass_sfx')) echo ' ' . $this->params->get('pageclass_sfx'); ?>">
		<section class="box category<?php echo ($this->category->id == 2) ? ' main-page' : ''; ?> ">
			<?php if (isset($this->category) && ($this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->event->K2CategoryDisplay )) { ?>
				<?php if ($this->category->image || $this->params->get('catTitle')) { ?>
					<div data-identifier="category-desc" class="category-desc<?php if ($this->params->get('catImage') && $this->category->image) { ?> has-img<?php } ?>">
						<?php if ($this->params->get('catImage') && $this->category->image) { ?>
							<figure id="item-media" class="img cat-img">
								<img src="<?php echo $this->category->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($this->category->name); ?>" />
							</figure>
						<?php } ?>
						<?php if ($this->params->get('catTitle')) { ?>
							<div class="container desc-wrapper">
								<div class="row">
									<div class="col-xs-12">
										<div class="desc">
											<?php if ($this->params->get('catTitle')) { ?>
												<h2 class="cat-title"><?php echo $this->category->name; ?></h2>
											<?php } ?>
											<?php if ($this->params->get('catDescription')) { ?>
												<div class="cat-text"><?php echo $this->category->description; ?></div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			<?php } ?>
			<div data-identifier="category-items" class="wrapper content gray-lighter">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<?php if (isset($most_viewed) && count($most_viewed) > 3) { ?>
								<section class="box episodes tiles highlights grid latest has-carousel">
									<header>
										<h2>محبوب‌ترین قسمت‌ها</h2>
									</header>
									<div>
										<ul>
											<?php
											foreach ($most_viewed as $key => $item) {
												if ($key < 10) {
													$media = !empty($item->video) ? ' video' : '';
													$media .=!empty($item->gallery) ? ' gallery' : '';
													$modified = ($item->modified != $this->nullDate && $item->modified != $item->created) ? JHTML::_('date', $item->modified, JText::_('K2_DATE_FORMAT_LC2')) : '';
													?>
													<li class="item<?php $media; ?><?php echo ($item->featured) ? ' featured' : ''; ?>" data-hits="<?php echo $item->hits; ?>">
														<?php
														$this->item = $item;
														echo $this->loadTemplate('item');
														?>
													</li>
													<?php
												}
											}
											?>
										</ul>
									</div>
								</section>
							<?php } ?>
							<?php if (isset($this->secondary) && count($this->secondary)) { ?>
								<section class="box episodes tiles highlights grid latest">
									<header>
										<h2>قسمت‌ها</h2>
										<?php if ($this->params->get('catTitleItemCounter') && $this->pagination->total > 1) { ?>
											<div class="items-count"><span><?php echo $this->pagination->total; ?></span> قسمت پخش شده</div>
										<?php } ?>
									</header>
									<div>
										<ul>
											<?php
											foreach ($this->secondary as $key => $item) {
												$media = !empty($item->video) ? ' video' : '';
												$media .=!empty($item->gallery) ? ' gallery' : '';
												$modified = ($item->modified != $this->nullDate && $item->modified != $item->created) ? JHTML::_('date', $item->modified, JText::_('K2_DATE_FORMAT_LC2')) : '';
												?>
												<li class="item<?php $media; ?><?php echo ($item->featured) ? ' featured' : ''; ?>" data-hits="<?php echo $item->hits; ?>">
													<?php
													$this->item = $item;
													echo $this->loadTemplate('item');
													?>
												</li>
											<?php } ?>
										</ul>
									</div>
								</section>
								<?php if ($this->pagination->getPagesLinks()) { ?>
									<div class="text-center"><?php if ($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?></div>
									<nav><?php if ($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?></nav>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php echo $this->category->event->K2CategoryDisplay; ?>
		</section>
		<?php if (isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )) { ?>
			<?php if ($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)) { ?>
				<div data-identifier="subcategories" class="container">
					<div class="row">
						<div class="col-xs-12">
							<section class="box subcategories grid">
								<div>
									<ul>
										<?php foreach ($this->subCategories as $key => $subCategory) { ?>
											<li data-count="<?php echo $subCategory->numOfItems; ?>">
												<?php $imgSource = ($this->params->get('subCatImage') && $subCategory->image) ? $subCategory->image : JURI::root() . 'assets/data/placeholder_tehran.jpg'; ?>
												<figure class="img cat-img">
													<a class="subCategoryImage" href="<?php echo $subCategory->link; ?>">
														<img alt="<?php echo K2HelperUtilities::cleanHtml($subCategory->name); ?>" src="<?php echo $imgSource; ?>" />
													</a>
												</figure>
												<?php if ($this->params->get('subCatTitle') || $this->params->get('subCatDescription')) { ?>
													<div class="desc">
														<?php if ($this->params->get('subCatTitle')) { ?>
															<h2>
																<a href="<?php echo $subCategory->link; ?>"><?php echo $subCategory->name; ?></a>
															</h2>
														<?php } ?>
														<?php if ($this->params->get('subCatDescription')) { ?>
															<div class="cat-text"><?php echo $subCategory->description; ?></div>
														<?php } ?>
													</div>
												<?php } ?>
											</li>
										<?php } ?>
									</ul>
								</div>
							</section>
							<nav><?php echo $pageNav->getListFooter(); ?></nav>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
			
		<div class="clearfix item-tools">
			<ul class="list-inline list-unstyled">
				<li class="fb"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo JUri::current(); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
				<li class="tw"><a href="https://twitter.com/home?status=<?php echo $this->item->title; ?> - <?php echo JUri::current(); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
				<li class="gp"><a href="https://plus.google.com/share?url=<?php echo JUri::current(); ?>" target="_blank"><i class="icon-gplus"></i></a></li>
			</ul>
		</div>
	</div>
</div>