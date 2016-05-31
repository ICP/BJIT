<body id="bd" class="<?php echo $theme . ' ' . strtolower($helper->device); ?>" data-spy="scroll" data-target="#menu">
	<header id="header">
		<?php if ($isFrontpage) { ?><h1 class="hide"><?php echo $sitename; ?></h1><?php } ?>
		<div class="wrapper gray-darkest">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="header-schedule">
							<a class="schedule-toggle" href="<?php echo JURI::base() . 'schedule'; ?>" data-toggle="toggle" data-target="#schedule"><i class="icon-play"></i><span>جدول پخش</span></a>
						</div>
						<div class="logo">
							<a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
						</div>
						<?php if ($helper->countModules('menu')) { ?>
							<jdoc:include type="modules" name="menu" />
						<?php } ?>
						<div class="menu-toggle hidden-md hidden-lg"><a href="#" data-toggle="menuslide" data-target=".menu"><i class="icon-menu"></i></a></div>
						<div class="search hidden-sm hidden-xs">
							<a class="search-toggle" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i></a>
						</div>
						<ul class="header-anchors list-inline list-unstyled">
							<li class="lang-anchor">
								<a href="<?php echo JURI::base() . 'english'; ?>"><span>English</span></a>
							</li>
							<li class="live-anchor">
								<a href="<?php echo JURI::base() . 'live'; ?>"><i class="icon-live"></i><span>پخش زنده</span></a>
							</li>
							<li class="catalog-anchor">
								<a href="#"><i class="icon-download"></i><span>کاتالوگ</span></a>
							</li>
							<li class="search hidden-md hidden-lg">
								<a class="search-toggle" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i><span>جستجو</span></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
<?php if ($helper->countModules('search')) { ?><jdoc:include type="modules" name="search" /><?php } ?>
<?php if ($helper->countModules('schedule')) { ?><jdoc:include type="modules" name="schedule" /><?php } ?>
<?php if ($helper->countModules('showcase')) { ?>
	<section id="showcase">
		<div class="wrapper gray-dark">
			<jdoc:include type="modules" name="showcase" style="basic" />
		</div>
	</section>
<?php } ?>
<?php if ($helper->countModules('special')) { ?>
	<aside id="showcase">
		<div class="wrapper yellow">
			<jdoc:include type="modules" name="special" style="basic" />
		</div>
	</aside>
<?php } ?>
<main id="mainbody">
	<div class="wrapper content gray-dark">
		<?php if (!$isFrontpage) { ?>
			<div class="page">
				<header class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<h1><?php echo isset(JFactory::getApplication()->getMenu()->getActive()->title) ? JFactory::getApplication()->getMenu()->getActive()->title : $sitename; ?></h1>
							</div>
						</div>
					</div>
				</header>
				<div class="container">
					<div class="row">
						<?php if (JFactory::getApplication()->getMenu()->getActive()->note === 'cols-9-3') { ?>
							<div class="col-xs-12 col-md-9">
							<?php } else { ?>
								<div class="col-xs-12">
								<?php } ?>
								<section class="page-conntent">
									<jdoc:include type="message" />
									<?php /* if ($helper->countMessages($app->getMessageQueue())) { ?><jdoc:include type="message" /><?php } */ ?>
									<jdoc:include type="component" />
								</section>
							</div>
							<?php if (JFactory::getApplication()->getMenu()->getActive()->note === 'cols-9-3') { ?>
								<div id="sidebar" class="col-xs-12 col-md-3">
									<jdoc:include type="modules" name="sidebar" style="default" />
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($helper->countModules('content-left') || $helper->countModules('content-center') || $helper->countModules('content-right')) { ?>
			<div class="container">
				<div id="contents" class="row">
					<?php if ($helper->countModules('content-right')) { ?>
						<div id="content-right" class="col-xs-12 col-md-4"><jdoc:include type="modules" name="content-right" style="default" /></div>
					<?php } ?>
					<?php if ($helper->countModules('content-center')) { ?>
						<div id="content-center" class="col-xs-12 col-md-4"><jdoc:include type="modules" name="content-center" style="default" /></div>
					<?php } ?>
					<?php if ($helper->countModules('content-left')) { ?>
						<div id="content-left" class="col-xs-12 col-md-4"><jdoc:include type="modules" name="content-left" style="default" /></div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<?php if ($helper->countModules('main-top-left') || $helper->countModules('main-top-right')) { ?>
			<div class="wrapper main-top gray-darker">
				<div class="container">
					<div class="row">
						<?php if ($helper->countModules('main-top-right')) { ?>
							<div id="main-top-right" class="col-xs-12 col-sm-6"><jdoc:include type="modules" name="main-top-right" style="default" /></div>
						<?php } ?>
						<?php if ($helper->countModules('main-top-left')) { ?>
							<div id="main-top-left" class="col-xs-12 col-sm-6"><jdoc:include type="modules" name="main-top-left" style="default" /></div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($helper->countModules('main-left') || $helper->countModules('main-right')) { ?>
			<div class="wrapper main gray-dark">
				<div class="container">
					<div class="row">
						<?php if ($helper->countModules('main-right')) { ?>
							<div  id="main-right" class="col-xs-12 col-sm-6 full-height"><jdoc:include type="modules" name="main-right" style="default" /></div>
						<?php } ?>
						<?php if ($helper->countModules('main-left')) { ?>
							<div id="main-left" class="col-xs-12 col-sm-6 full-height"><jdoc:include type="modules" name="main-left" style="default" /></div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($helper->countModules('main-bot')) { ?>
			<div class="wrapper main-bot gray">
				<jdoc:include type="modules" name="main-bot" />
			</div>
		<?php } ?>
		<?php if ($helper->countModules('main-bot2')) { ?>
			<div class="wrapper main-bot gray">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<jdoc:include type="modules" name="main-bot2" style="default" />
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</main>
<footer id="footer">
	<div class="wrapper gray-darker">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-3">
					<div class="footer-about">
						<a href="<?php echo JURI::base(); ?>"><img src="<?php echo JURI::base() ?>assets/img/logo_footer.png" /></a>
						<?php if ($helper->countModules('footer-about')) { ?><jdoc:include type="modules" name="footer-about" /><?php } ?>
					</div>
				</div>
				<div class="col-xs-12 col-md-9">
					<?php if ($helper->countModules('footer')) { ?><jdoc:include type="modules" name="footer" /><?php } ?>
					<?php if ($helper->countModules('copyright')) { ?><jdoc:include type="modules" name="copyright" /><?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php if ($helper->countMessages($app->getMessageQueue())) { ?><jdoc:include type="message" /><?php } ?>
</footer>
<?php if ($isFrontpage) { ?>
	<script src="<?php echo JURI::base(); ?>assets/js/jquery-1.11.1.min.js"></script>
<?php } else { ?>
	<script src="<?php echo JURI::base(); ?>assets/js/select2.full.min.js"></script>
	<script src="<?php echo JURI::base(); ?>assets/js/persian-date-0.1.8.min.js"></script>
	<script src="<?php echo JURI::base(); ?>assets/js/persian-datepicker-0.4.5.min.js"></script>
	<script src="<?php echo JURI::base(); ?>assets/js/jquery.nanoscroller.min.js"></script>
<?php } ?>
<script src="<?php echo JURI::base(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo JURI::base(); ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo JURI::base(); ?>assets/js/doctv.min.js?_=20160326"></script>
<script type="text/javascript">
    // Piwik code
</script>
</body>