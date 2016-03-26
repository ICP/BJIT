<div class="t-wrapper" style="position: relative;">
<?php if($params->get('showcattitle')) { ?>
	<div class="module-title grid_8" style="margin: 0; position: absolute; overflow: hidden; z-index: 1">
		<h2 class="title" style="width: 100%"></h2>
	</div>
	<?php  } ?>
	<div style="position: relative; z-index: 2" class="multiplenews clearfix">
		<?php
		$num = count($list) < 4 ? count($list) : 4 ;		
		for($i=0;$i<$num;$i++) {
			$row = $list[$i];
			$catlink   = JRoute::_(K2HelperRoute::getCategoryRoute($row->catslug));
			$link   = JRoute::_(K2HelperRoute::getItemRoute($row->slug, $row->catslug));
			$class = $i == ($num - 1) ? ' omega ' : '';
		?>
		<div class="col-left <?php echo $class; ?>  grid_2_sub">
			<div class="tnews-boxwrap tnews-theme">
				<div class="tnews-box">
					<?php if($params->get('showcattitle')) { ?>
					<div class="tnews-section clearfix">
						<h2 class="title">
							<a title="<?php echo $row->name; ?>" href="<?php echo $catlink; ?>">
								<span><?php echo  $row->name; ?></span>
							</a>
						</h2>
					</div>
					<?php } ?>
					<div class="tnews-content-2 clearfix">
					<?php 
					$imagefile = "media/k2/items/cache/" .  md5('Image' . $row->id) . '_' . $params->get('imagesize') . ".jpg";
					if(file_exists($imagefile))
					{
					?>
					
						<div class="img-wrapper clearfix" style="text-align: center;">
							<a title="<?php echo $row->title; ?>" href="<?php echo $link; ?>">
								<img alt="<?php echo $row->title; ?>" src="media/k2/items/cache/<?php echo md5('Image' . $row->id) . '_' . $params->get('imagesize'); ?>.jpg">
							</a>
						</div>
					<?php 
					}
					?>
						<h4 class="tnews-title-2">
							<a title="<?php echo  $row->title; ?>" href="<?php echo $link; ?>">
								<?php echo  $row->title; ?>
							</a>
						</h4>
						<p><?php echo K2HelperUtilities::wordLimit($row->introtext, $params->get('wordlimit')); ?></p>
					</div>
				</div>
			</div>
		</div>
		<?php		
		}
		?>		
	</div>
</div>