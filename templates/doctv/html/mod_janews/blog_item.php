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
		//get Itemid of category
		$catlink   = JRoute::_(K2HelperRoute::getCategoryRoute($rows[0]->catslug));

		$cattitle = $rows[0]->cattitle;
		$catdesc = $rows[0]->catdesc;
		
		$cls_sufix = trim($params->get('blog_theme',''));
		
		if($cls_sufix) $cls_sufix = '-'.$cls_sufix;
?>
		<div class="jazin-boxwrap jazin-theme<?php echo $cls_sufix;?>">
		<div class="jazin-box">
		<?php if ($showcattitle) : ?>
		<div class="jazin-section clearfix">
			<a href="<?php echo $catlink;?>" title="<?php echo trim(strip_tags($catdesc));?>">
				<span><?php echo $cattitle;?></span>
			</a>
		</div>
		<?php endif; ?>
<?php
		$i = 0;
		while($i < $introitems && $i<count($rows)) {
			$row = $rows[$i];
			$link   = JRoute::_(K2HelperRoute::getItemRoute($row->slug, $row->catslug));
			if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_L.jpg')){
				$image = '<img src="' . 'media/k2/items/cache/'.md5("Image".$row->id).'_L.jpg"' . '" alt="' . $row->title . '" />';
			} else {
				$image = modJANewsHelper::replaceImage ($row, $img_align, $params, $wordlimit, $showimage, $img_w, $img_h, $hiddenClasses);
			}
			
			//Show the latest news
?>
			<div class="jazin-content clearfix">
				<h4 class="jazin-title"><a href="<?php echo $link;?>" title="<?php echo strip_tags($row->title);?>"><?php echo $row->title;?></a></h4>
				
				<?php if ($showcreater||$showdate) : ?>
					<div class="jazin-meta">
						<?php if ($showcreater) : ?>
							<span class="createby"><?php echo $row->creater;?></span><?php if ($showdate) : ?> - <?php endif; ?>						
						<?php endif; ?>
						<?php if ($showdate) : ?>
							<span class="createdate"><?php echo JHTML::_('date', $row->created, JText::_('DATE_FORMAT_LC2'));?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
				<?php if ($showimage) : ?>
				<?php echo $image; ?>
				<?php endif; ?>
				<?php 
				      echo $row->introtext;
				?>
				<?php if ($showreadmore) : ?>
				<a href="<?php echo $link; ?>" class="readon" title="<?php echo JText::sprintf('READ MORE...');?>"><?php echo JText::sprintf('Read more...');?></a>
				<?php endif; ?>
			</div>
<?php
			$i++;
		}
		
		if (count ($rows) > $i) {
			echo "<strong class=\"jazin-more\">".JText::_("MORE:")."</strong>\n";
			echo "<ul class=\"jazin-links\">\n";
  		
  		while (count ($rows) > $i) {
  			$row = $rows[$i];
  			$link   = JRoute::_(K2HelperRoute::getItemRoute($row->slug, $row->catslug));
?>
  			<li>
  			<a title="<?php echo strip_tags($row->introtext); ?>" href="<?php echo $link; ?>">
  			<?php echo $row->title; ?></a>
  			</li>
<?php
  			$i++;
  		}
  		echo "</ul>\n";
		} 
?>
		</div>
		</div>
