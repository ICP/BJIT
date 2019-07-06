<?php
// no direct access
defined('_JEXEC') or die;
?>
<aside id="search" class="box search">
	<button class="btn close" data-toggle="toggle" data-target="#search">&times;</button>
	<form class="search-form" role="form" action="<?php echo JUri::root() . 'search'; ?>">
		<div class="form-group">
			<input type="text" name="searchword" placeholder="<?php echo JText::_('K2_SEARCH'); ?>" class="form-control" />
			<button type="submit" class="btn btn-success"><?php echo JTEXT::_('K2_SEARCH'); ?></button>
		</div>
	</form>
</aside>