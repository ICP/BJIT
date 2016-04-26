<?php 
$dateInputValue = isset($jalaliDate) ? $jalaliDate : ''; 
$dayNames = array('Monday' => 'دوشنبه', 'Tuesday' => 'سه‌شنبه', 'Wednesday' => 'چهارشنبه', 'Thursday' => 'پنج‌شنبه', 'Friday' => 'جمعه', 'Saturday' => 'شنبه', 'Sunday' => 'یک‌شنبه');
$weekday = $dayNames[gmdate('l', strtotime($this->item->date) + 86400)];
$document = JFactory::getDocument();
$document->setTitle('کنداکتور روز ' . $weekday . ' ' . $dateInputValue);
?>
<form id="form-schedules" class="edit-programs" action="<?php echo JRoute::_('index.php?option=com_schedules&view=save&save-type=edit&user-id=' . JFactory::getUser()->id); ?>" method="post" class="" enctype="multipart/form-data">
	<fieldset>
		<table class="pull-left">
			<thead>
				<tr>
					<th><label for="start-time" style="width: 100px;">زمان شروع</label></th>
					<th><label for="end-time" style="width: 100px;">زمان پایان</label></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="text" class="timepicker input-mini" name="start-time" id="start-time" value="<?php echo $this->item->start; ?>" />
					</td>
					<td>
						<input type="text" class="timepicker input-mini" name="end-time" id="end-time" value="<?php echo $this->item->end; ?>" />
					</td>
				<tr>
			</tbody>
		</table>
		<ul>
			<li>
				<label for="jform_id">شناسه</label>
				<?php echo $this->form->getInput('id'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?>
			</li>
			<li>
				<label for="jform_date">تاریخ</label>
				<input id="jform_date" class="inputbox required" type="text" value="<?php echo $dateInputValue; ?>" name="jform[date]" />
				<?php // echo $this->form->getInput('date'); ?>
			</li>
			<li>
				<label for="jform_occassion">مناسبت</label>
				<?php echo $this->form->getInput('occassion'); ?>
			</li>
			<li>
				<label for="programs-table">برنامه ها</label>
			</li>
		</ul>
		<table id="programs-table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th></th>
					<th>شماره</th>
					<th>ساعت شروع</th>
					<th>مدت</th>
					<th>نام برنامه</th>
					<th>قسمت</th>
					<th>تعداد کل</th>
					<th>نوع برنامه</th>
					<th>شناسه برنامه</th>
					<th></th>
				</tr>
			</thead>
			<?php 
			$f = 0;
			$newOptions = array('foreigner-series' => 'مجموعه خارجی', 'persian-series' => 'مجموعه ایرانی', 'armstations' => 'آرم‌استیشن، وله، اعلام برنامه', 'movies' => 'سینمایی', 'announces' => 'آنونس، تیزر، میان‌برنامه', 'prayer-time' => 'قرآن و اذان', 'musical' => 'کلیپ موزیکال', 'commercials' => 'آگهی بازرگانی', 'specials' => 'ویژه برنامه ها');
			$options = array('internal' => 'داخلی', 'foreigner' => 'خارجی', 'film' => 'سینمایی', 'azaan' => 'اذان', 'lullaby' => 'لالایی', 'armstation' => 'وله و آرم استیشن', 'provinces' => 'سیمای استان‌ها');
			function checkOption($kind, $val) {
				if ($kind == $val) {
					return ' selected="selected"';
				} else {
					return;
				}
			}
			?>
			<?php $programs = json_decode($this->item->programs); ?>
			<tbody class="programs-inputs">
				<?php foreach($programs as $program) { ?>
				<tr>
					<td class="edit-row"><a class="add-row" title="افزودن سطر جدید به بعد از سطر فعلی"><span class="icon-plus"></span></a><br /><a class="remove-row" title="حذف سطر"><span class="icon-minus"></span></a></td>
					<td><input type="text" class="program-id" name="programs[program-id][]" value="<?php echo $f + 1; ?>" disabled /></td>
					<?php 
					// Backward compatibility for new times. Originally it was "99:99" and now it's "99:99:99"
					$explodedTime = explode(':', $program->time);
					if (count($explodedTime) == 2)
						$program->time = $program->time . ':00';
					if (!empty($program->duration)) {
						$explodedDuration = explode(':', $program->duration);
						if (count($explodedDuration) == 2)
							$program->duration = $program->duration . ':00';
					}
					?>
					<td><input type="text" class="program-time timepicker3 input-mini" name="programs[time][]" value="<?php echo $program->time; ?>" /></td>
					<td><input type="text" class="program-duration timepicker3 input-mini" name="programs[duration][]" value="<?php echo @$program->duration; ?>" /></td> 
					<td><input type="text" class="program-name program input-medium" name="programs[program][]" value="<?php echo $program->name; ?>" /></td>
					<td><input type="text" class="program-part part input-mini" name="programs[part][]" value="<?php echo @$program->part; ?>" /></td>
					<td><input type="text" class="program-parts parts input-mini" name="programs[parts][]" value="<?php echo @$program->parts; ?>" /></td>
					<td>
						<select name="programs[kind][]" class="kind-picker input-small">
							<?php /*<optgroup label="تایپ های جدید"> */ ?>
							<?php 
							foreach ($newOptions as $value => $text) {
								echo '<option value="' . $value . '"' . checkOption($program->kind, $value) . '>' . $text . '</option>';
							} /* ?>
							</optgroup>
							<optgroup label="تایپ های قدیمی">
							<?php 
							foreach ($options as $value => $text) {
								echo '<option value="' . $value . '"' . checkOption($program->kind, $value) . '>' . $text . '</option>';
							} ?>
							</optgroup>
							*/ ?>
						</select>
					</td>
					<td><input type="text" class="program-uid uidpicker input-small" name="programs[uid][]" value="<?php echo @$program->uid; ?>" /></td>
					<td>
						<div class="program-notes">
							<a href="#" title="ملاحظات" class="toggle-note">
								<span class="icon-asterisk"></span>
							</a>
							<div class="hide">
								<textarea class="input-large" name="programs[note][]"><?php echo @$program->note; ?></textarea>
								<button class="btn btn-success save-note">ثبت ملاحظات</button>
								<div class="clearfix"></div>
							</div>
						</div>
					</td>
				</tr>
				<?php $f++; ?>
				<?php } // End foreach ?>
			</tbody>
		</table>
		<!--<a class="addField"><i class="icon-plus"></i>&nbsp; افزودن برنامه</a><br /><br />-->
		<div>
			<button type="submit" class="btn btn-success"><span>ثبت</span></button>
			<a class="btn btn-danger" href="<?php echo JRoute::_('index.php?option=com_schedules'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
			<input type="hidden" name="save-type" value="edit" />
			<input type="hidden" name="option" value="com_schedules" />
			<input type="hidden" name="user-id" value="<?php echo JFactory::getUser()->id; ?>" />
			<input type="hidden" name="view" value="save" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</fieldset>
</form>