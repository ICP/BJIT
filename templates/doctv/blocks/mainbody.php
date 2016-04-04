<body id="bd" class="dark <?php echo strtolower($helper->device); ?>" data-spy="scroll" data-target="#menu">
	<header id="header">
		<?php if ($isFrontpage) { ?><h1 class="hide"><?php echo $sitename; ?></h1><?php } ?>
		<div class="wrapper gray-darkest">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="header-schedule">
							<a class="schedule-toggle" href="<?php JURI::base() . 'schedule'; ?>" data-toggle="toggle" data-target="#schedule"><i class="icon-play"></i><span>جدول پخش</span></a>
						</div>
						<div class="logo">
							<a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
						</div>
						<?php if ($helper->countModules('menu')) { ?>
							<jdoc:include type="modules" name="menu" />
						<?php } ?>
						<div class="search">
							<a class="search-toggle" href="<?php JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i></a>
						</div>
						<ul class="header-anchors list-inline list-unstyled">
							<li>
								<a href="#"><span>En</span></a>
							</li>
							<li>
								<a href="#"><i class="icon-placeholder"></i><span>پخش زنده</span></a>
							</li>
							<li>
								<a href="#"><i class="icon-download"></i><span>کاتالوگ</span></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
	<?php if ($helper->countModules('search')) { ?><jdoc:include type="modules" name="search" /><?php } ?>
	<?php if ($helper->countModules('showcase')) { ?>
	<section id="showcase">
		<div class="wrapper gray-dark">
			<jdoc:include type="modules" name="showcase" />
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
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div class="page">
								<header class="page-header">
									<h1><?php echo JFactory::getDocument()->getTitle(); ?></h1>
								</header>
								<section class="page-conntent">
									<jdoc:include type="component" />
								</section>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if ($helper->countModules('content-left') || $helper->countModules('content-center') || $helper->countModules('content-right')) { ?>
				<div class="container">
					<div class="row">
						<?php if ($helper->countModules('content-right')) { ?>
							<div class="col-xs-12 col-md-4"><jdoc:include type="modules" name="content-right" style="default" /></div>
						<?php } ?>
						<?php if ($helper->countModules('content-center')) { ?>
							<div class="col-xs-12 col-md-4"><jdoc:include type="modules" name="content-center" style="default" /></div>
						<?php } ?>
						<?php if ($helper->countModules('content-left')) { ?>
							<div class="col-xs-12 col-md-4"><jdoc:include type="modules" name="content-left" style="default" /></div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
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
							<div  id="main-right" class="col-xs-12 col-sm-6"><jdoc:include type="modules" name="main-right" style="default" /></div>
						<?php } ?>
						<?php if ($helper->countModules('main-left')) { ?>
							<div id="main-left" class="col-xs-12 col-sm-6"><jdoc:include type="modules" name="main-left" style="default" /></div>
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
	<script src="<?php echo JURI::base(); ?>assets/js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo JURI::base(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo JURI::base(); ?>assets/js/main.js?_=20160326"></script>
	<script type="text/javascript">
		// Piwik code
	</script>
</body>