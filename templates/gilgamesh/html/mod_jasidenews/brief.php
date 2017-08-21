<?php 
/*
  # ------------------------------------------------------------------------
# JA Seleni for Joomla 1.5.x - Version 1.0 - Licence Owner JA115884
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
# ------------------------------------------------------------------------
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="module-title">
<?php if ($params->get('show_cat_title', false)) { ?>
	<a href="<?php echo $helper->getCatLink($list[0]); ?>">
	<h3 class="title"><?php echo $list[0]->cattitle; ?></h3>
	</a>
<?php } ?>
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
			if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_S.jpg')){
				$image = '<img src="' . 'media/k2/items/cache/'.md5("Image".$item->id).'_S.jpg"' . ' align="' . $params->get("image_alignment","left") . '" alt="' . $item->title . '" style="margin-right: 7px" />';
				echo $image;
			}/* else {
				$image = $helper->renderImage ($item, $params, $descMaxChars, $iwidth, $iheight );
			}*/
			
		  } ?>
		  
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
