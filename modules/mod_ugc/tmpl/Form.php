<?php
defined('_JEXEC') or die;

$user = JFactory::getUser();
$user_id = $user->id;
?>
<form class="form" role="form" action="<?php echo JURI::root() . 'api/ugc/upload/'; ?>" method="post" data-type="ajax" data-eligibility="<?php echo ($user_id) ? 'true' : 'false'; ?>">
	<div class="alert alert-danger" style="display: none;">برای ارسال اثر وارد می‌بایست وارد سایت شوید.</div>
	<div class="alert results-container" style="display: none;"></div>
	<div class="form-group">
		<input class="form-control" type="text" name="title" placeholder="عنوان" required />
	</div>
	<div class="form-group">
		<textarea class="form-control" name="description" placeholder="توضیحات" rows="7" required></textarea>
	</div>
	<div class="form-group">
		<input type="hidden" name="file" value="" required />
		<div class="ajax-upload"></div>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">ارسال</button>
	</div>
</form>
<script src="<?php echo JURI::base() . 'assets/js/jquery.fine-uploader.min.js'; ?>"></script>
<script type="text/template" id="qq-template">
	<div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
		<div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
			<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
		</div>
		<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
			<span class="qq-upload-drop-area-text-selector"></span>
		</div>
		<div class="qq-upload-button-selector btn btn-default">
			<div>بارگذاری فایل</div>
		</div>
			<span class="qq-drop-processing-selector qq-drop-processing">
				<span>Processing dropped files...</span>
				<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
			</span>
		<ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
			<li>
				<div class="progress">
					<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-warning progress-bar-striped active"></div>
				</div>
				<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
				<span class="qq-upload-file-selector qq-upload-file"></span>
				<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
				<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
				<span class="qq-upload-size-selector qq-upload-size"></span>
				<!--<button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">لغو</button>-->
				<button type="button" class="qq-upload-retry-selector qq-upload-retry btn btn-warning btn-xs">تلاش مجدد</button>
				<button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">حذف</button>
				<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
			</li>
		</ul>

		<dialog class="qq-alert-dialog-selector">
			<div class="qq-dialog-message-selector"></div>
			<div class="qq-dialog-buttons">
				<button type="button" class="btn">بستن</button>
			</div>
		</dialog>

		<dialog class="qq-confirm-dialog-selector">
			<div class="qq-dialog-message-selector"></div>
			<div class="qq-dialog-buttons">
				<button type="button" class="qq-cancel-button-selector">خیر</button>
				<button type="button" class="qq-ok-button-selector">بلی</button>
			</div>
		</dialog>

		<dialog class="qq-prompt-dialog-selector">
			<div class="qq-dialog-message-selector"></div>
			<input type="text">
			<div class="qq-dialog-buttons">
				<button type="button" class="qq-cancel-button-selector">لغو</button>
				<button type="button" class="qq-ok-button-selector">تایید</button>
			</div>
		</dialog>
	</div>
</script>