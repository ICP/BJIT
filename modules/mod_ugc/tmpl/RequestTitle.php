<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$user = JFactory::getUser();
$user_id = $user->id;
?>
<form class="form-inline" role="form" action="<?php echo JURI::root() . 'api/ugc/requesttitle/'; ?>" method="post" data-type="ajax" data-eligibility="<?php echo ($user_id) ? 'true' : 'false'; ?>">
	<div class="form-group">
		<select id="program-list" class="form-control" name="item_id"></select>
	</div>
	<button type="submit" class="btn btn-default">ارسال</button>
	<div class="alert alert-danger" style="display: none;">برای درخواست برنامه می‌بایست وارد سایت شوید.</div>
	<div class="alert results-container" style="display: none;"></div>
</form>