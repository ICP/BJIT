<?php 
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div id="ja-sidenews-<?php echo $moduleID; ?>">
	<?php foreach( $list as $i => $item ){
		$item->text = $item->introtext . $item->fulltext;
		$onclick = ' onclick="location.href=\''.$helper->getLink($item).'\'"';
		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_S.jpg')){
			$item->title = htmlspecialchars($item->title);
			$image = '<img src="'.'media/k2/items/cache/'.md5("Image".$item->id).'_S.jpg"'.' alt="'.$item->title.'" />';
		} else {
			$image = $helper->renderImage ($item, $params, $descMaxChars, $iwidth, $iheight );
		}
	?>
	<div class="ja-sidenews" <?php echo $onclick ;?> style="width:<?php echo $iwidth;?>px; height:<?php echo $height;?>px">
		<div  class="ja-slidenews-cover" >
			<?php echo $image; ?>
		</div>
		<div class="ja-opacity" style=" <?php echo $bgcolor;?>;height:<?php echo $height;?>px;"></div>
			<div class="ja-sidenews-display">
				<div class="ja-sidenews-desc" style="<?php echo $color; ?>;">
					<h3><?php echo $helper->trimString($item->title, $titleMaxChars);?></h3>
					<?php echo $helper->trimString( strip_tags($item->introtext), $descMaxChars); ?>
				</div>
			</div>
	</div>
	<?php } ?>
</div>	