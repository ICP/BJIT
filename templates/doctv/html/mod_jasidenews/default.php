<?php 
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
	
<h3><a href="<?php echo $helper->getCatLink($list[0]); ?>"><?php echo $list[0]->cattitle; ?></a></h3>
<div>
	<div class="ja-sidenews-list clearfix">
		<?php foreach( $list as $item ) : 
			if( $showdate) {
				$item->date =  $item->created;
			}
			$item->text = $item->introtext . $item->fulltext;
		?>
			<div class="ja-slidenews-item clearfix">
				<a class="ja-title" href="<?php echo  $helper->getLink($item); ?>"><?php echo  $helper->trimString( $item->title, $titleMaxChars );?></a>
			<?php if($showimage){
				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XL.jpg')){
					$item->title = htmlspecialchars($item->title);
					$image = '<img src="' . 'media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg"' . ' alt="' . $item->title . '"/>';
				} else {
					$image = $helper->renderImage ($item, $params, $descMaxChars, $iwidth, $iheight );
				}
				echo $image;
			  } 
			  ?>  
			  <?php if (isset($item->date)) : ?>
					<span class="ja-createdate"><?php echo JHTML::_('date', $item->date, JText::_('DATE_FORMAT_LC4')); ?> </span>
				<?php endif; ?>	
				<?php echo $helper->trimString( strip_tags($item->introtext), $descMaxChars); ?>
			  <?php if( $showMoredetail ) : ?>
			  <a class="readon" href="<?php echo  $helper->getLink($item); ?>"> <?php echo JTEXT::_("More detail"); ?></a>
			  <?php endif;?>
			</div>
	  <?php endforeach; ?>
	</div>
</div>