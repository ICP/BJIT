<?php
$time = time();
$items = array_values($items);
//echo date('H:i:s', time());
?>
<ul>
	<?php
	foreach ($items as $key => $item) {
		$key++;
		if ($key <= $params->get('count')) {
			?>
			<li<?php if ($key > 1) { ?> class="grayscale color-on-hover"<?php } ?>>
				<?php if ($key == 1) { ?>
					<figure<?php if ($key > 1) { ?> class="grayscale"<?php } ?>>
						<a href="<?php echo $item->link; ?>"><img src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>"></a>
					</figure>
					<div class="desc">
						<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
						<div class="introtext">
							<p><?php echo $item->introtext; ?></p>
						</div>
					</div>
				<?php } else { ?>
					<figure>
						<a href="<?php echo $item->link; ?>"><img src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>"></a>
					</figure>
					<div class="desc">
						<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
					</div>
				</li>
				<?php
			}
		}
	}
	?>
</ul>
<a href="<?php echo JUri::root(); ?>schedule" class="btn btn-default category-link _bottom"><i class="icon-left-circle"></i> بیشتر</a>
