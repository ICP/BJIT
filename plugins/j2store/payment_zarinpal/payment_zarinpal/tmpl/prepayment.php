<?php
/**
 * @package     Joomla - > Site and Administrator payment info
 * @subpackage  com_j2store
 * @subpackage 	Trangell_Zarinpal
 * @copyright   trangell team => https://trangell.com
 * @copyright   Copyright (C) 20016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
?>

<form action="<?php echo @$vars->zarinpal; ?>" method="post" name="adminForm" enctype="multipart/form-data">
	<p><?php echo 'درگاه زرین پال' ?></p>
	<br />
    <input type="submit" class="j2store_cart_button button btn btn-primary" value="<?php echo JText::_($vars->button_text); ?>" />
</form>
