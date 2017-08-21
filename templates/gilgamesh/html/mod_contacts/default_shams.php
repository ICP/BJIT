<?php
/**
 * File name: $HeadURL: svn://tools.janguo.de/jacc/trunk/admin/templates/modules/tmpl/default.php $
 * Revision: $Revision: 147 $
 * Last modified: $Date: 2013-10-06 10:58:34 +0200 (So, 06. Okt 2013) $
 * Last modified by: $Author: michel $
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license 
 */
defined('_JEXEC') or die('Restricted access');
?>
<div class="panel interaction">
	<div class="panel-heading">
		<h2>تماس با ما</h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="alert">
					 <p>شبکه مستند با حضور اساتید و کارشناسان در دو شورای آموزش و تولید، اقدام به بررسی فرم های تکمیل شده از سوی علاقمندان و فیلم سازان نموده و نتایج این بررسی را با هدف ارتقاء سطح کیفی تولید فیلم مستند مبنای برنامه ریزی برای کارگاه های آموزشی و سیاست گذاری های تولیدی خود قرار خواهد داد.</p>
					 <p>همچنین شبکه مستند پس از برگزاری جلسات مشاوره و کارگاه های آموزشی مدون و نیز بررسی طرح ها و ایده- های فیلم سازان، نتیجه پروژه های به مرحله تولید رسیده را به وسیله پست الکترونیکی به اطلاع آنان خواهد رساند. </p>
					 <p>در ادامه باید گفت مخاطبین می توانند از طریق پست الکترونیکی، تلفن و فکس با ما در ارتباط بوده و شبکه مستند را هرچه بیشتر و بهتر در نیل به اهداف خود یاری نمایند.</p>
				</div>
			</div>
			<div class="col-md-8 col-md-offset-2">
				<div class="row">
					<div class="col-md-6">
						<form role="form" action="<?php echo JURI::base() . 'contacts'; ?>" method="post" class="contact-form">
							<div class="form-group">
								<?php echo JHtml::_('form.token'); ?>
								<input type="text" name="name" class="form-control" placeholder="نام" required />
							</div>
							<div class="form-group">
								<input type="email" name="email" class="form-control" placeholder="آدرس ایمیل" required />
							</div>
							<div class="form-group">
								<textarea class="form-control" name="message" placeholder="پیام" rows="3" required></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success pull-left">ارسال</button>
							</div>
						</form>
						<div class="results-container" style="display: none;">
							<div class="inner"></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contact-form">
							<ul class="list-unstyled contact-details">
								<li>
									<span class="title">
										<i class="icon-phone"></i>تلفن روابط عمومی
									</span>021-29152703
								</li>
								<li>
									<span class="title">
										<i class="icon-phone"></i>تلفن گوياي شبكه
									</span>27869000
								</li>
								<li>
									<span class="title">
										<i class="icon-chat"></i>پیامک
									</span>3000080
								</li>
								<li>
									<span class="title">
										<i class="icon-telegram"></i>کانال  تلگرام
									</span><a href="http://telegram.me/mostanad_TV" target="_blank" class="ltr">@mostanad_TV</a>
								</li>
								<li>
									<span class="title">
										<i class="icon-mail"></i>پست الکترونیکی
									</span><a href="mailto:intl@mostanadtv.com">office@mostanadtv.com</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>