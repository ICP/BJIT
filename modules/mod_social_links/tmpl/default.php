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
	<?php if ($params->get('facebook')) { ?><li><a href="#"><i class="icon-facebook"></i></a></li><?php } ?>
	<?php if ($params->get('twitter')) { ?><li><a href="#"><i class="icon-twitter"></i></a></li><?php } ?>
	<?php if ($params->get('gplus')) { ?><li><a href="#"><i class="icon-gplus"></i></a></li><?php } ?>
	<?php if ($params->get('youtube')) { ?><li><a href="#"><i class="icon-youtube"></i></a></li><?php } ?>
	<?php if ($params->get('vimeo')) { ?><li><a href="#"><i class="icon-vimeo"></i></a></li><?php } ?>
	<?php if ($params->get('instagram')) { ?><li><a href="#"><i class="icon-instagram"></i></a></li><?php } ?>
	<?php if ($params->get('telegram')) { ?><li><a href="#"><i class="icon-telegram"></i></a></li><?php } ?>
	<?php if ($params->get('lenzor')) { ?><li><a href="#"><i class="icon-lenzor"></i></a></li><?php } ?>
	<?php if ($params->get('cloob')) { ?><li><a href="#"><i class="icon-cloob"></i></a></li><?php } ?>
</ul>