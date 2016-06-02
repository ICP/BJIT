<?php 
/**
 * File name: $HeadURL: svn://tools.janguo.de/jacc/trunk/admin/templates/modules/tmpl/default.php $
 * Revision: $Revision: 147 $
 * Last modified: $Date: 2013-10-06 10:58:34 +0200 (So, 06. Okt 2013) $
 * Last modified by: $Author: michel $
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license 
 */
defined('_JEXEC') or die('Restricted access'); 
?>
<ul class="social-links list-ustyled list-inline">
	<?php if ($params->get('facebook')) { ?><li class="fb"><a target="_blank" href="<?php echo $params->get('facebook'); ?>"><i class="icon-facebook"></i></a></li><?php } ?>
	<?php if ($params->get('twitter')) { ?><li class="tw"><a target="_blank" href="<?php echo $params->get('twitter'); ?>"><i class="icon-twitter"></i></a></li><?php } ?>
	<?php if ($params->get('gplus')) { ?><li class="gp"><a target="_blank" href="<?php echo $params->get('gplus'); ?>"><i class="icon-gplus"></i></a></li><?php } ?>
	<?php if ($params->get('youtube')) { ?><li class="yt"><a target="_blank" href="<?php echo $params->get('youtube'); ?>"><i class="icon-youtube"></i></a></li><?php } ?>
	<?php if ($params->get('vimeo')) { ?><li class="vi"><a target="_blank" href="<?php echo $params->get('vimeo'); ?>"><i class="icon-vimeo"></i></a></li><?php } ?>
	<?php if ($params->get('instagram')) { ?><li class="in"><a target="_blank" href="<?php echo $params->get('instagram'); ?>"><i class="icon-instagram"></i></a></li><?php } ?>
	<?php if ($params->get('telegram')) { ?><li class="tg"><a target="_blank" href="<?php echo $params->get('telegram'); ?>"><i class="icon-telegram"></i></a></li><?php } ?>
	<?php if ($params->get('aparat')) { ?><li class="ap"><a target="_blank" href="<?php echo $params->get('aparat'); ?>"><i class="icon-aparat"></i></a></li><?php } ?>
	<?php if ($params->get('lenzor')) { ?><li class="lz"><a target="_blank" href="<?php echo $params->get('lenzor'); ?>"><i class="icon-lenzor"></i></a></li><?php } ?>
	<?php if ($params->get('cloob')) { ?><li class="cl"><a target="_blank" href="<?php echo $params->get('cloob'); ?>"><i class="icon-cloob"></i></a></li><?php } ?>
</ul>