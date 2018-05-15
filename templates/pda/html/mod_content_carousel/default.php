<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php if (count($items)) { ?>
<div id="slideshow">
	<?php foreach ($items as $key=>$item) {	?>
	<figure class="item<?php if (count($items) == $key+1) echo ' last'; ?>">
		<?php if($params->get('itemImage') && isset($item->image)){ ?>
		<!--<a class="carousel-image" href="<?php echo $item->link; ?>" title="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>">-->
			<img src="<?php echo str_replace('XL', 'L', $item->image); ?>" alt="<?php echo htmlspecialchars($item->title); ?>" title="<?php echo htmlspecialchars($item->title); ?>" />
		<!--</a>-->
		<?php } ?>
		<?php if($params->get('itemTitle')) { ?>
		<figcaption>
			<!--<a class="moduleItemTitle" href="<?php echo $item->link; ?>">-->
				<?php echo $item->title; ?>
			<!--</a>-->
		</figcaption>
		<?php } ?>
	</figure>
	<?php } ?>
</div>
<?php } ?>