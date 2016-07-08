<?php
/**
 * @version		$Id: default.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

if (!function_exists('limit_text')) {
	function limit_text($string, $length = 10) {
		$words = explode(' ', $string);
		if (count($words) <= $length)
			return $string;
		$output = '';
		for ($i = 0; $i < $length; $i++) {
			$output .= $words[$i] . ' ';
		}
		return trim($output) . '&hellip;';
	}
}
?>
<?php if (count($items)) { ?>
	<?php if ($params->get('category_link') && $params->get('mymenu_id')) { ?>
		<a href="<?php echo JRoute::_('index.php?option=com_k2&Itemid=' . $params->get('mymenu_id')); ?>" class="btn btn-default category-link">بیشتر</a>
	<?php } ?>
	<ul>
		<?php foreach ($items as $key => $item) { ?>
			<li>
				<?php if ($key == 0) { ?>
					<?php if ($params->get('itemImage') || $params->get('itemIntroText')) { ?>
						<?php if ($params->get('itemImage') && isset($item->image)) { ?>
							<figure>
								<a href="<?php echo $item->link; ?>">
									<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
								</a>
							</figure>
						<?php } ?>
						<div class="desc">
							<?php if ($params->get('itemTitle')) { ?>
								<h3><a href="<?php echo $item->link; ?>"><?php echo limit_text($item->title); ?></a></h3>
							<?php } ?>
							<?php if ($params->get('itemIntroText')) { ?>
								<p><?php echo $item->introtext; ?></p>
							<?php } ?>
						</div>
					<?php } ?>
				<?php } else { ?>
					<h3><a href="<?php echo $item->link; ?>"><?php echo limit_text($item->title); ?></a></h3>
				<?php } ?>
			</li>
		<?php } ?>
	</ul>
<?php } ?>