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
?>
<aside id="schedule" class="box schedule">
	<div class="container">
		<div>
			<ul>
				<?php
				foreach ($items as $key => $item) {
					$key++;
					if ($key < $params->get('count')) {
						?>
						<li>
							<?php if ($key == 1) { ?><div class="type">در حال پخش<i class="icon-play"></i></div><?php } ?>
							<?php if ($key == 2) { ?><div class="type">برنامه‌های بعدی<i class="icon-placeholder"></i></div><?php } ?>
							<figure<?php if ($key > 1) { ?> class="grayscale"<?php } ?>>
								<figcaption><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?><small><?php echo $item->start_small; ?></small></a></figcaption>
								<a href="<?php echo $item->link; ?>"><img src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>"></a>
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