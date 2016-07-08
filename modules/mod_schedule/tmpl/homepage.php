<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_syndicate
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$time = time();
$items = array_values($items);
//echo date('H:i:s', time());

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
<aside id="schedule" class="box schedule">
	<div class="container">
		<div>
			<ul>
				<?php
				foreach ($items as $key => $item) {
					$key++;
//					$item->link = ($item->link) ? $item->link : JUri::base();
					$item->thumb = ($item->thumb) ? $item->thumb : JUri::root() . 'assets/img/placeholder.png';
					if ($key < $params->get('count')) {
						?>
						<li>
							<?php if ($key == 1) { ?><div class="type">در حال پخش<i class="icon-play"></i></div><?php } ?>
							<?php if ($key == 2) { ?><div class="type">برنامه‌های بعدی<i class="icon-placeholder"></i></div><?php } ?>
							<figure<?php if ($key > 1) { ?> class="grayscale"<?php } ?>>
								<figcaption>
									<?php if ($item->link) { ?><a href="<?php echo $item->link; ?>"><?php } ?>
										<?php echo limit_text($item->title, 3); ?><small><?php echo $item->start_small; ?></small>
									<?php if ($item->link) { ?></a><?php } ?>
								</figcaption>
								<?php if ($item->link) { ?><a href="<?php echo $item->link; ?>"><?php } ?>
									<img src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>">
								<?php if ($item->link) { ?></a><?php } ?>
							</figure>
						</li>
						<?php
					}
				}
				?>
				<li class="link">
					<div class="link-inner">
						<a href="<?php echo JUri::root(); ?>schedule">
							جدول پخش<small><?php echo $jdate; ?></small>
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</aside>