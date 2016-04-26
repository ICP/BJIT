<?php
$document = JFactory::getDocument();
$document->setTitle('کنداکتور جدید');
?>
<form id="form-schedules" class="add-programs" action="<?php echo JRoute::_('index.php?option=com_schedules&view=save'); ?>" method="post" class="" enctype="multipart/form-data">
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
						<input type="text" class="timepicker2 input-mini" name="start-time" id="start-time" value="07:00" />
					</td>
					<td>
						<input type="text" class="timepicker2 input-mini" name="end-time" id="end-time" value="23:00" />
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
				<?php echo $this->form->getInput('date'); ?>
			</li>
			<li>
				<label for="jform_occassion">مناسبت</label>
				<?php echo $this->form->getInput('occassion'); ?>
			</li>
			<li>
				
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
			<tbody class="programs-inputs">
				<?php for ($f = 0; $f < 54; $f++) { ?>
				<tr>
					<td class="edit-row"><a class="add-row" title="افزودن سطر جدید به بعد از سطر فعلی"><span class="icon-plus"></span></a><br /><a class="remove-row" title="حذف سطر"><span class="icon-minus"></span></a></td>
					<td><input type="text" class="program-id" name="programs[program-id][]" value="<?php echo $f + 1; ?>" disabled /></td>
					<td><input type="text" class="program-time timepicker3 input-mini" name="programs[time][]" placeholder="00:00:00" /></td>
					<td><input type="text" class="program-duration timepicker3 input-mini" name="programs[duration][]" placeholder="00:00:00" /></td>
					<td><input type="text" class="program-name program input-medium" name="programs[program][]" data-provide="typeahead" data-source="http://62.220.120.60/demo/index.php?option=com_schedules&view=list" /></td>
					<td><input type="text" class="program-part part input-mini" name="programs[part][]" /></td>
					<td><input type="text" class="program-parts parts input-mini" name="programs[parts][]" /></td>
					<td>
						<?php /*
						<select name="programs[kind][]" class="kind-picker input-small">
							<option value="foreigner">خارجی</option>
							<option value="internal">داخلی</option>
							<option value="film">سینمایی</option>
							<option value="azaan">اذان</option>
							<option value="lullaby">لالایی</option>
							<option value="armstation">وله و آرم استیشن</option>
							<option value="provinces">سیمای استان‌ها</option>
						</select>
						*/ ?>
						<select name="programs[kind][]" class="kind-picker input-small">
							<?php /* <optgroup label="تایپ های جدید"> */ ?>
								<option value="foreigner-series">مجموعه خارجی</option>
								<option value="persian-series">مجموعه ایرانی</option>
								<option value="armstations">آرم‌استیشن، وله، اعلام برنامه</option>
								<option value="movies">سینمایی</option>
								<option value="announces">آنونس، تیزر، میان‌برنامه</option>
								<option value="prayer-time">قرآن و اذان</option>
								<option value="musical">کلیپ موزیکال</option>
								<option value="commercials">آگهی بازرگانی</option>
								<option value="specials">ویژه برنامه ها</option>
							<?php /*
							</optgroup>
							<optgroup label="تایپ های قدیمی">
								<option value="foreigner">خارجی</option>
								<option value="internal">داخلی</option>
								<option value="film">سینمایی</option>
								<option value="azaan">اذان</option>
								<option value="lullaby">لالایی</option>
								<option value="armstation">وله و آرم استیشن</option>
								<option value="provinces">سیمای استان‌ها</option>
							</optgroup>
							*/ ?>
						</select>
					</td>
					<td><input type="text" class="program-uid uidpicker input-small" name="programs[uid][]" value="" /></td>
					<td>
						<div class="program-notes">
							<a href="#" title="ملاحظات" class="toggle-note">
							<span class="icon-asterisk"></span>
							</a>
							<div class="hide">
								<textarea class="input-large" name="programs[note][]"></textarea>
								<button class="btn btn-success save-note">ثبت ملاحظات</button>
								<div class="clearfix"></div>
							</div>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<a class="addField"><i class="icon-plus"></i>&nbsp; افزودن برنامه</a><br /><br />
		<div>
			<button type="submit" class="btn btn-success"><span>ثبت</span></button>
			<a class="btn btn-danger" href="<?php echo JRoute::_('index.php?option=com_schedules'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
			<?php $saveType = (isset($this->item->id)) ? 'edit' : 'save'; ?>
			<input type="hidden" name="save-type" value="<?php echo $saveType; ?>" />
			<input type="hidden" name="option" value="com_schedules" />
			<input type="hidden" name="view" value="save" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</fieldset>
</form>