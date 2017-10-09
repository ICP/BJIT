<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

function resolveMessageType($type) {
	switch (strtolower($type)) {
		case 'error':
			$class = 'danger';
			break;
		case 'notice':
			$class = 'info';
			break;
		default:
		case 'message':
			$class = 'success';
			break;
	}
	return $class;
}

$msgList = $displayData['msgList'];
?>
<div id="system-message-container"><?php if (is_array($msgList) && !empty($msgList)) : ?>
		<div id="system-message">
			<?php foreach ($msgList as $type => $msgs) : ?>
				<div class="alert alert-<?php echo resolveMessageType($type); ?>">
					<?php // This requires JS so we should add it through JS. Progressive enhancement and stuff.  ?>
					<a class="close" data-dismiss="alert">×</a>
					<?php if (!empty($msgs)) : ?>
						<h4 class="alert-heading"><?php echo JText::_($type); ?></h4>
						<?php foreach ($msgs as $msg) : ?>
							<p><?php echo strip_tags($msg); ?></p>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?></div>
