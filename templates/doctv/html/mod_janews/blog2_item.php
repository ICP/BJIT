<?php
// No direct access.
defined('_JEXEC') or die;

//get Itemid of category
$catlink   = JRoute::_(K2HelperRoute::getCategoryRoute($rows[0]->catslug));

$cattitle = $rows[0]->cattitle;
$catdesc = $rows[0]->catdesc;

$cls_sufix = trim($params->get('blog_theme',''));

if($cls_sufix) $cls_sufix = '-'.$cls_sufix;
?>
<div class="tnews-boxwrap tnews-theme<?php echo $cls_sufix;?>">
	<div class="tnews-box">
		<?php if ($showcattitle) { ?>
		<div class="tnews-section clearfix">
			<h2 class="title">
				<a href="<?php echo $catlink;?>" title="<?php echo trim(strip_tags($cattitle));?>">
					<span><?php echo $cattitle;?></span>
				</a>
			</h2>
		</div>
		<?php } ?>
	<?php
	$i = 0;
	while($i < $introitems && $i<count($rows)) {
		$row = $rows[$i];
		$link   = JRoute::_(K2HelperRoute::getItemRoute($row->slug, $row->catslug));
		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_M.jpg')){
			$image = modJANewsHelper::replaceImage ($row, $img_align, $params, $wordlimit, $showimage, $img_w, $img_h, $hiddenClasses);
			$image = '<img src="' . 'media/k2/items/cache/'.md5("Image".$row->id).'_M.jpg" alt="' . $row->title . '" />';
		} else {
			$image = modJANewsHelper::replaceImage ($row, $img_align, $params, $wordlimit, $showimage, $img_w, $img_h, $hiddenClasses);
		}
	?>
		<div class="tnews-content-2 clearfix">
			<?php if ($showimage) { ?>
			<div style="text-align: center;" class="img-wrapper clearfix">
				<a href="<?php echo $link;?>" title="<?php echo strip_tags($row->title);?>">
					<?php echo $image; ?>
				</a>
			</div>
			<?php } ?>
			<h4 class="tnews-title-2">
				<a href="<?php echo $link;?>" title="<?php echo strip_tags($row->title);?>">
					<?php echo $row->title;?>
				</a>
			</h4>
			<?php if ($showcreater||$showdate) { ?>
			<div class="tnews-meta">
				<?php if ($showcreater) { ?>
				<span class="createby"><?php echo $row->creater;?></span><?php if ($showdate) { ?> - <?php } ?>						
				<?php } ?>
				<?php if ($showdate) { ?>
				<span class="createdate"><?php echo JHTML::_('date', $row->created, JText::_('DATE_FORMAT_LC2'));?></span>
				<?php } ?>
			</div>
			<?php } ?>
			<p><?php echo $row->introtext; ?></p>
			<?php if ($showreadmore) { ?>
			<a href="<?php echo $link; ?>" class="readon" title="<?php echo JText::sprintf('READ MORE...');?>"><?php echo JText::sprintf('Read more...');?></a>
			<?php } ?>
		</div>
	<?php
		$i++;
	}

	if (count ($rows) > $i) {
		//echo "<strong class=\"jazin-more\">".JText::_("MORE:")."</strong>\n";
		echo "<ul class=\"news-links-2\">\n";

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
