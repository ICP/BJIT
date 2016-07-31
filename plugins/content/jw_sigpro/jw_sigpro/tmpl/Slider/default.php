<?php
/**
 * @version		3.0.x
 * @package		Simple Image Gallery Pro
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2015 JoomlaWorks Ltd. All rights reserved.
 * @license		http://www.joomlaworks.net/license
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="gallery-inner" data-id="<?php echo $gal_id; ?>">
	<ul class="slider has-carousel galllery">
		<?php foreach ($gallery as $key => $photo) { ?>
			<li<?php echo ($key == 0) ? ' class="active"' : ''; ?>>
				<figure class="img">
					<a href="<?php echo $photo->sourceImageFilePath; ?>" title="<?php echo ($gal_captions && $photo->captionTitle) ? $photo->captionTitle : '' ?>" class=" thumbnail">
						<img src="<?php echo $photo->sourceImageFilePath; ?>" alt="<?php echo ($gal_captions && $photo->captionTitle) ? $photo->captionTitle : '' ?>" />
					</a>
				</figure>
			</li>
		<?php } ?>
	</ul>
</div>
