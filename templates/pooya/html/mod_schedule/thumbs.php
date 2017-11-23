<?php
$time = time();
$items = array_values($items);
?>
<div class="links">
	<a href="<?php echo JUri::root(); ?>schedule" class="btn btn-default category-link"><i class="icon-calendar"></i> جدول پخش</a>
	<a href="<?php echo JUri::root(); ?>live" class="btn btn-default category-link"><i class="icon-play"></i> پخش زنده</a>
</div>
<ul>
	<?php
	foreach ($items as $key => $item) {
		$key++;
		if ($key <= $params->get('count')) {
			?>
			<li>
				<figure>
					<a href="<?php echo $item->link; ?>"><img src="<?php echo str_replace('_XS', '_M', $item->thumb); ?>" alt="<?php echo $item->title; ?>"></a>
				</figure>
				<div class="desc">
					<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
					<div class="introtext">
						<p><?php echo $item->introtext; ?></p>
					</div>
				</div>
				<?php
			}
		}
		?>
</ul>
