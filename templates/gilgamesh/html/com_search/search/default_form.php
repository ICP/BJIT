<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

//JHtml::_('bootstrap.tooltip');

$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();
?>
<form class="search-options" action="<?php echo JRoute::_('index.php?option=com_search'); ?>" method="post">
	<div class="input-container">
		<div class="form-group">
			<input type="text" name="searchword" placeholder="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" size="30" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>" class="form-control" />
			<button onclick="this.form.submit()" class="btn btn-default"><span class="icon-search"></span></button>
		</div>
		<?php if (!empty($this->searchword)) { ?>
		<div class="total-count"><span class="label label-warning"><?php echo $this->total; ?></span> نتیجه</div>
		<?php } ?>
	</div>
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="limit" value="20" />
</form> 