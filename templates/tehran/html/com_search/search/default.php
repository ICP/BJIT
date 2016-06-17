<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<div class="page search<?php echo $this->pageclass_sfx; ?>">
	<div class="page-tools">
		<ul class="list-unstyled list-inline order-style">
			<li>نحوه نمایش:</li>
			<li><span class="clickable" data-style="list"><i class="icon-list"></i></span></li>
			<li class="active"><span class="clickable" data-style="grid"><i class="icon-th"></i></span></li>
		</ul>
	</div>

	<?php echo $this->loadTemplate('form'); ?>
	<?php
	if ($this->error == null && count($this->results) > 0) :
		echo $this->loadTemplate('results');
	else :
		echo $this->loadTemplate('error');
	endif;
	?>
</div>
