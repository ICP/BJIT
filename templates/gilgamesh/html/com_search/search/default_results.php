<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
//var_dump($this->results);
require_once (JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'route.php');
//urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($item->catid . ':' . urlencode($item->categoryalias))));
?>
<section class="box episodes tiles highlights latest grid">
	<div>
		<ul>
			<?php foreach ($this->results as $result) { ?>
				<li class="item">
					<figure class="img">
						<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) { ?> target="_blank"<?php } ?>>
							<img src="<?php echo JURI::root() . '/media/k2/items/cache/' . md5('Image' . explode(':', $result->slug)[0]) . '_S.jpg'; ?>" alt="<?php echo $this->escape($result->title); ?>" />
						</a>
					</figure>
					<div class="desc">
						<div class="item-header">
							<h3 class="item-title">
								<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) { ?> target="_blank"<?php } ?>><?php echo ($result->title); ?></a>
							</h3>
						</div>
						<div class="introtext">
							<?php echo $result->text; ?>
						</div>
						<div class="item-category">
							<a href="<?php echo urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($result->catslug))); ?>">
							<?php echo $this->escape($result->section); ?>
								</a>
						</div>
					</div>
				</li>
			<?php } ?>
		</ul>
	</div>
</section>
<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
