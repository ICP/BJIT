<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

//JHtml::_('formbehavior.chosen', 'select.aaa');
include JPATH_COMPONENT_ADMINISTRATOR . '/helpers/jdatetime.class.php';
new jDateTime(false);
?>
<select style="display: none"></select>
<div id="schedule-panel">
	<div class="panel-header">
		<div id="calendar" class="pull-right">
			<btn class="btn btn-default pull-left load-btn" data-task="load">Load</btn>
			<?php // echo JHTML::calendar(date("Y-m-d H:i:s"), 'mycalendar', 'date', '%Y-%m-%d %H:%M:00', array('size' => '8', 'maxlength' => '20', 'class' => ' validate[\'required\']',)); ?>
			<?php echo JHTML::calendar(date("Y-m-d"), 'calendar', 'date', '%Y-%m-%d', array('size' => '8', 'maxlength' => '10', 'class' => ' validate[\'required\']',)); ?>
		</div>
	</div>
	<div class="panel-body">
		<h3 class="text-center schedule-title">Schedule of <span><?php echo jDateTime::date('Y-m-d', time()); ?></span></h3>
		<table id="schedule-table" class="table tabl-hover table-bordered table-responsive table-striped">
			<thead>
				<tr>
					<th width="1%" class="">#</th>
					<th width="1%" class="">Revision</th>
					<th colspan="2" width="54%" class="">Title</th>
					<th width="10%" class="">Start</th>
					<th width="10%" class="">Duration</th>
					<th width="10%" class="">State</th>
					<th width="1%" class="">Program</th>
					<th width="10%" class="">Created</th>
				</tr>
			</thead>
			<tbody>
				<tr class="edit">
			<form class="add-schedule">
				<td></td>
				<td></td>
				<td width="30%">
					<div class="form-group select-holder">
						<select id="program-list" name="program_id" class="form-control input-block-level programs has-suggest" required>
							<option value="0" selected>ناموجود</option>
						</select>
					</div>
					<div class="form-group has-feedback">
						<input type="text" name="title" placeholder="Program Title" class="form-control input-block-level input-sm" required />
					</div>
				</td>
				<td width="25%">
					<div class="form-group select-holder">
						<select id="episode-list" name="episode"  class="form-control input-block-level has-suggest disabled" required>
							<option value="0" selected>ناموجود</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="subtitle" placeholder="Episode Title" class="form-control input-block-level input-sm" />
					</div>
				</td>
				<td>
					<div class="form-group has-feedback">
						<input type="text" name="start" placeholder="00:00" class="form-control input-block-level text-center mask required" required />
					</div>
				</td>
				<td>
					<div class="form-group has-feedback">
						<input type="text" name="duration" placeholder="00:00" class="form-control input-block-level text-center mask required" required />
					</div>
				</td>
				<td>
					<div class="form-group">
						<select name="state" class="form-control input-block-level">
							<option value="1" selected>Published</option>
							<option value="0">Unpublished</option>
						</select>
					</div>
				</td>
				<td>
				</td>
				<td>
					<input type="hidden" name="created" value="<?php echo jDateTime::date('Y-m-d H:i:s', time()); ?>" />
					<?php echo JHtml::_('form.token'); ?>
					<button type="submit" class="btn btn-success" data-task="add">Add <span class="icon-new icon-white"></span></button>
				</td>
			</form>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="schedule-add" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Item</h4>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" data-task="add">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>