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

$showcreater			= 	$params->get( 'showcreater', 0 );
$showdate 				= 	$params->get( 'showdate', 0 );
$showimage 				= 	$params->get( 'show', 0 );
$autoresize 			= 	intval (trim( $params->get( 'autoresize', 0) ));
$img_w 					= 	intval (trim( $params->get( 'width', 100 ) ));
$img_h 				= 	intval (trim( $params->get( 'height', 100 ) ));
$img_align 					= $params->get( 'align' , 'left');

$introitems 				= 	intval (trim( $params->get( 'introitems', 1 ) ));
$linkitems 				= 	intval (trim( $params->get( 'linkitems', 0 ) ));

$showreadmore 				= 	intval (trim( $params->get( 'showreadmore', 1 ) ));
$showcattitle 			= 	trim( $params->get( 'showcattitle' ));
$hiddenClasses 				= 	trim( $params->get( 'hiddenClasses', '' ) );

$news = count($contents);
if($news < $cols*$rowsCount) $rowsCount = $news / $cols;
if (!$cols) return;
$width = 99.9/$cols;

?>


<div id="jazin-wrap-<?php echo $GLOBALS['janewsIDNum'];?>">
<div id="jazin-<?php echo $GLOBALS['janewsIDNum'];?>" class="clearfix">

<?php 
  $k = 0;
  for ($z = 0; $z < $cols; $z ++) :
	  $cls = $cols==1?'full':($z==0?'left':($z==$cols-1?'right':'center'));
?>	  
		<div class="jazin-<?php echo $cls;?>" style="width:<?php echo $width;?>%">
		<?php for ($y = 0; $y < ($rowsCount) && $k<$news; $y ++) :
		  $params->set('blog_theme', $themes[$k]);
		  $rows = $contents[$k];
		  if($catid) {
				$path = JModuleHelper::getLayoutPath('mod_janews', 'blog_item');
				if (file_exists($path)) {
					require($path);
				}
  			//include(dirname(__FILE__).'/blog_item.php');
      }
		  $k++;
		endfor; ?>
		</div>
	<?php endfor; ?>

</div>
</div>