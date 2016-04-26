<?php
/**
 * @version     1.0.0
 * @package     com_schedules
 * @copyright   Copyright (C) 2012,  Pooya TV. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid Roshan <faridv@gmail.com> - http://www.faridr.ir
 */

// no direct access
defined('_JEXEC') or die;
$user = JFactory::getUser();
$hasFullAccess = in_array('10', $user->groups);
$hasAccess = in_array('16', $user->groups);
// var_dump($hasAccess);
//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_schedules', JPATH_ADMINISTRATOR);
(int) $limit = JRequest::getVar('p');
$l = ($limit) ? $limit : 0;
if ($hasAccess || $hasFullAccess) {
	$query = 'SELECT s.*, u.name AS username, uu.name AS checked_out_by FROM #__schedules AS s LEFT JOIN #__users AS u ON s.modified_by = u.id LEFT JOIN #__users AS uu ON s.checked_out = uu.id WHERE state > -1 ORDER BY id DESC LIMIT ' . $l . ', 20';
} else {
	$query = 'SELECT * FROM #__schedules WHERE state > 0 ORDER BY id DESC LIMIT ' . $l . ', 20';
}
$db = JFactory::getDbo();
$db->setQuery($query);
$result = $db->loadObjectList();

$countQuery = 'SELECT COUNT(1) AS c FROM #__schedules WHERE state > -1';
$db->setQuery($countQuery);
$count = $db->loadObject();
(int) $c = $count->c / 20;

include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';

?>
<div class="schedules-list">
<?php if ($hasFullAccess) { ?>
	<div class="add-item">
		<a href="<?php echo JRoute::_('index.php?option=com_schedules&task=schedules.edit&id=0'); ?>">
			<i class="icon-plus icon-large"></i>&nbsp;
			<span style="display: inline;">مورد جدید</span>
		</a>
	</div>
<?php } ?>
<form action="<?php echo JURI::base() . 'schedules-search'; ?>" method="get">
	<fieldset>
		<div class="control-group form-inline">
			<input type="text" class="input-large" name="keyword" placeholder="جستجو در کنداکتور" />
			<button type="submit" class="btn">جستجو</button>
		</div>
	</fieldset>
</form>
<?php if(count($result)) { ?>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>شناسه</th>
				<th>تاریخ</th>
				<th>وضعیت</th>
				<th>مناسبت</th>
				<?php if ($hasAccess || $hasFullAccess) { ?>
				<th>آخرین ویرایش</th>
				<th>ویرایش</th>
				<?php } ?>
				<?php // if ($user->authorize('core.manage', 'com_schedules')) { ?>
				<?php if ($hasFullAccess) { ?>
				<th></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($result as $i => $item) { ?>
			<tr>
				<td><?php echo $item->id; ?></td>
				<?php 
				list($y, $m, $d) = explode('-', $item->date);
				$jalaliDate = gregorian_to_jalali($y, $m, $d, '-');
				?>
				<td><?php echo $jalaliDate; ?></td>
				<?php
				list($modDate, $modTime) = explode(' ', $item->modified);
				list($my, $mm, $md) = explode('-', $modDate);
				$mJalaliDate = (intval($my) != 0) ? gregorian_to_jalali($my, $mm, $md, '-') : null;
				?>
				<td><?php echo JHtml::_('jgrid.published', $item->state, $i); ?></td>
				<td><?php echo $item->occassion; ?></td>
				<?php if ($hasAccess || $hasFullAccess) { ?>
				<td><?php if ($mJalaliDate) echo $item->username . '<br />' . $modTime . ' ' . $mJalaliDate; ?></td>
				<td>
					<?php if ($item->checked_out != 0) { ?><span style="color: tomato; cursor: pointer;" rel="tooltip" class="hasTip icon-info-sign" title="در حال ویرایش توسط <?php echo $item->checked_out_by; ?>"></span>&nbsp;<?php } ?>
					<a href="<?php echo JRoute::_('index.php?option=com_schedules&task=schedules.edit&id='. $item->id); ?>">ویرایش</a>
				</td>
				<?php } ?>
				<?php if ($hasFullAccess) { ?>
				<td>
					<span class="duplicate-link">تکرار</span>
					<form class="duplicate" action="<?php echo JRoute::_('index.php?option=com_schedules&view=save'); ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="former-date" value="<?php echo $item->date; ?>" />
						<input type="text" name="new-date" placeholder="انتخاب تاریخ" class="new-date input-small" id="dup-<?php echo $item->id; ?>" />
						<input type="hidden" name="save-type" value="duplicate" />
						<input type="hidden" name="option" value="com_schedules" />
						<input type="hidden" name="view" value="save" />
						<?php echo JHtml::_('form.token'); ?>
						<input type="submit" value="تکرار" class="btn" />
					</form>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>
</div>
<div class="pagination pagination-centered">
	<ul>
	<?php 
	for ($i = 0; $i <= $c; $i++) {
		$class = ($l == ($i * 20)) ? ' class="active"' : '';
		echo '<li' . $class . '><a href="' . JURI::current() . '?p=' . ($i * 20) . '">' . ($i + 1) . '</a></li>';
	}
	?>
	</ul>
</div>