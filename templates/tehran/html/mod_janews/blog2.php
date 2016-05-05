<?php
// No direct access.
defined('_JEXEC') or die;

$showcreater			= 	$params->get( 'showcreater', 0 );
$showdate 				= 	$params->get( 'showdate', 0 );
$showimage 				= 	$params->get( 'showimage', 0 );
$autoresize 			= 	intval (trim( $params->get( 'autoresize', 0) ));
$img_w 					= 	intval (trim( $params->get( 'width', 100 ) ));
$img_h 					= 	intval (trim( $params->get( 'height', 100 ) ));
$img_align 				=	$params->get( 'align' , 'top');

$introitems 			=	intval (trim( $params->get( 'introitems', 1 ) ));
$linkitems 				=	intval (trim( $params->get( 'linkitems', 0 ) ));

$showreadmore 			= 	intval (trim( $params->get( 'showreadmore', 1 ) ));
$showcattitle 			= 	trim( $params->get( 'showcattitle' ));
$hiddenClasses 			= 	trim( $params->get( 'hiddenClasses', '' ) );


$news = count($contents);
if($news < $cols) $cols = $news;
if($rowsCount * $cols < $news) $news = $rowsCount * $cols;
if (!$cols) return;
$cols == 3 ? $width = '200px' : $width = 99.9/$cols."%";
$cols == 4 ? $width = '150px' : $width = 99.9/$cols."%";

?>
<div class="t-wrapper" style="position: relative;">
	<div class="module-title grid_8" style="margin: 0;  position: absolute; overflow: hidden; z-index: 1">
		<h2 class="title" style="width: 100%"></h2>
	</div>
	<div class="multiplenews clearfix" style="position: relative; z-index: 2">
	<?php
	$k = 0;
	for ($z = 0; $z < $cols; $z ++) {
		$cls = $cols==1?'full':($z==0?'left':($z==$cols-1?'right':'center'));

		/*<div class="col-<?php echo $cls;?>" style="width:<?php echo $width; ?>"> */
		$position = "";
		($z+1 == $cols) ? $position = "omega" : $position = ""; ?>
		<div class="col-<?php echo $cls.' '.$position;?> grid_2_sub">
			<?php
			for ($y = 0; $y < ($news / $cols) && $k<$news; $y ++) {
				$params->set('blog_theme', $themes[$k]);
				$rows = $contents[$k];
				if($catid) {
					$path = JModuleHelper::getLayoutPath('mod_janews', 'blog2_item');
					if (file_exists($path)) {
						require($path);
					}
				}
				$k++;
			} ?>
		</div>
	<?php } ?>
	</div>
</div>