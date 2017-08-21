<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="ja-sidenews-list clearfix">
	<?php foreach( $list as $item ) : 
		if( $showdate) {
			$item->date = $item->created;
		}
		$item->text = $item->introtext . $item->fulltext;
	?>
		<div class="ja-slidenews-item">
			<a class="ja-title" href="<?php echo  $helper->getLink($item); ?>"><?php echo  $helper->trimString( $item->title, $titleMaxChars );?></a>
		  <?php if( $showimage != "" ):  ?>
  		  	<?php echo $helper->renderImage ($item, $params, $descMaxChars, $iwidth, $iheight ); ?>
		  <?php endif; ?>
		  <?php if (isset($item->date)) : ?>
				<span class="ja-createdate"><?php echo JHTML::_('date', $item->date, JText::_('DATE_FORMAT_LC4')); ?> - </span>
			<?php endif; ?>
			
			<?php echo $helper->trimString( strip_tags($item->introtext), $descMaxChars); ?>
		  <?php if( $showMoredetail ) : ?>
		  <a class="readon" href="<?php echo  $helper->getLink($item); ?>"> <?php echo JTEXT::_("MORE DETAIL"); ?></a>
		  <?php endif;?>
		</div>
  <?php endforeach; ?>
</div>