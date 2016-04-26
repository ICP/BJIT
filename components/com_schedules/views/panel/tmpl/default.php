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
?>
<section id="schedules-panel" style="margin-left: 20px;">
	<header>
		<h3>پنل کنداکتور</h3>
	</header>
	<div class="inner">
		<table class="table table-bordered table-hover table-striped">
			<tbody>
				<tr class="search">
					<td>جستجو در کنداکتور</td>
					<td>
						<form action="<?php echo JURI::base() . 'schedules-search'; ?>" method="get" style="margin: 0" class="">
							<fieldset>
								<div class="control-group form-inline">
									<input type="text" class="input-large" name="keyword" placeholder="جستجو در کنداکتور" value="" />
									<button type="submit" class="btn">جستجو</button>
								</div>
							</fieldset>
						</form>
					</td>
				</tr>
				<tr class="daily">
					<td>کنداکتور روزانه</td>
					<td>
						<input type="text" class="input-large" name="date" id="datepicker-1" placeholder="انتخاب تاریخ" />
						<a href="/programs-table?date=" class="picker btn">انتخاب</a>
					</td>
				</tr>
				<tr class="print">
					<td>چاپ کنداکتور روزانه</td>
					<td>
						<input type="text" class="input-large" name="date" id="datepicker-2" placeholder="انتخاب تاریخ" />
						<a href="/programs-table?view=print&date=" class="picker btn">انتخاب</a>
					</td>
				</tr>
				<tr class="weekly">
					<td>چاپ کنداکتور هفتگی</td>
					<td>
						<input type="text" class="input-large" name="date" id="datepicker-5" placeholder="از تاریخ" />
						<a href="/weekly?date=" class="picker btn">انتخاب</a>
					</td>
				</tr>
				<tr class="2pg">
					<td>خروجی EPG</td>
					<td>
						<input type="text" class="input-large" name="date" id="datepicker-3" placeholder="انتخاب تاریخ" />
						<a href="/epg?date=" class="picker btn">انتخاب</a>
					</td>
				</tr>
				<tr class="epg2">
					<td>خروجی EPG 2</td>
					<td>
						<input type="text" class="input-large" name="date" id="datepicker-4" placeholder="انتخاب تاریخ" />
						<a href="/epg2?date=" class="picker btn">انتخاب</a>
					</td>
				</tr>
				<tr class="epg2">
					<td>گواهی پخش</td>
					<td>
						<form action="<?php echo JURI::base() . 'schedules-report'; ?>" method="get" style="margin: 0" class="">
							<fieldset>
								<div class="control-group form-inline">
									<input type="text" class="input-large" name="keyword" placeholder="جستجو در گواهی پخش" value="" />
									<button type="submit" class="btn">جستجو</button>
								</div>
							</fieldset>
						</form>
					</td>
				</tr>
				<?php if (!$user->guest) { ?>
				<tr class="daily">
					<td>ایجاد کنداکتور</td>
					<td><a href="/schedules">پنل ورود و ویرایش کنداکتور</a></td>
				</tr>
				<tr class="logout">
					<td colspan="2"><br />کاربر گرامی، <?php echo $user->name; ?>&nbsp;&nbsp;&nbsp;
						<form action="<?php echo JRoute::_('index.php', true, 0); ?>" method="post" id="login-form" class="pull-left">
							<div class="logout-button">
								<input type="submit" name="Submit" class="btn" value="خروج از سیستم" />
								<input type="hidden" name="option" value="com_users" />
								<input type="hidden" name="task" value="user.logout" />
								<input type="hidden" name="return" value="<?php echo base64_encode('index.php?option=com_schedules&view=panel'); ?>" />
								<?php echo JHtml::_('form.token'); ?>
							</div>
						</form>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</section>