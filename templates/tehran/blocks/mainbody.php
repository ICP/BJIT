<body id="bd" class="dark <?php echo strtolower($helper->device) . ($isFrontpage ? ' home' : ''); ?>" data-spy="scroll" data-target="#menu">
	<header id="header">
		<?php if ($isFrontpage) { ?><h1 class="hide"><?php echo $sitename; ?></h1><?php } ?>
		<div id="masthead" class="wrapper purple-light">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="logo">
							<a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
						</div>
						<div class="menu-toggle hidden-md hidden-lg"><a href="#" data-toggle="menuslide" data-target=".menu"><i class="icon-menu"></i></a></div>
						<div class="search hidden-sm hidden-xs">
							<a class="search-toggle" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i></a>
						</div>
						<ul class="header-anchors list-inline list-unstyled">
							<li><a href="#"><i class="icon-facebook"></i></a></li>
							<li><a href="#"><i class="icon-twitter"></i></a></li>
							<li><a href="#"><i class="icon-aparat"></i></a></li>
							<li><a href="#"><i class="icon-instagram"></i></a></li>
							<li><a href="#"><i class="icon-telegram"></i></a></li>
							<li class="search hidden-md hidden-lg">
								<a class="search-toggle" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i><span>جستجو</span></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="navbar" class="wrapper purple">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php if ($helper->countModules('menu')) { ?>
							<jdoc:include type="modules" name="menu" />
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</header>
<?php if ($helper->countModules('search')) { ?><jdoc:include type="modules" name="search" /><?php } ?>
<?php if ($helper->countModules('showcase')) { ?>
	<section id="showcase">
		<div data-identifier="showcase" class="wrapper">
			<jdoc:include type="modules" name="showcase" style="basic" />
		</div>
	</section>
<?php } ?>
<main id="mainbody">
	<div data-identifier="main-top" class="wrapper content gray-lighter">
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
						<div class="<?php echo (JFactory::getApplication()->getMenu()->getActive()->note === 'cols-9-3') ? "col-xs-12 col-md-9" : "col-xs-12"; ?>">
							<section class="page-conntent">
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
		<?php } ?>
		<div class="container">
			<?php if ($helper->countModules('main-top')) { ?>
				<div id="main-top" class="row">
					<div class="col-xs-12">
						<jdoc:include type="modules" name="main-top" style="default" />
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<div data-identifier="main" class="wrapper content gray-light">
		<div class="container">
			<?php if ($helper->countModules('main')) { ?>
				<div id="main" class="row">
					<div class="col-xs-12">
						<jdoc:include type="modules" name="main" style="default" />
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php if ($helper->countModules('special')) { ?>
		<aside id="showcase">
			<div class="wrapper purple">
				<jdoc:include type="modules" name="special" style="basic" />
			</div>
		</aside>
	<?php } ?>
	<div data-identifier="main-bot" class="wrapper content gray-lighter">
		<div class="container">
			<?php if ($helper->countModules('main-bot')) { ?>
				<div id="main-bot" class="row">
					<div class="col-xs-12">
						<jdoc:include type="modules" name="main-bot" style="default" />
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</main>
<footer id="footer">
	<?php // if ($helper->countModules('newsletter')) { ?>
	<div id="newsletter" class="wrapper gray">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<jdoc:include type="modules" name="newsletter" />
					<section class="box newsletter inline">
						<header>
							<h2>عضویت در خبرنامه</h2>
						</header>
						<div>
							<form action="#" role="form" class="form-inline">
								<div class="form-group">
									<input class="form-control ltr" name="email" type="email" placeholder="ایمیل خود را وارد کنید" />
									<button type="submit" class="btn btn-default">عضویت</button>
								</div>
							</form>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<?php // } ?>
	<?php if ($helper->countModules('footer')) { ?>
		<div id="sitemap" class="wrapper gray-lightest">
			<div class="container">
				<div class="row _relative">
					<div class="col-xs-12 col-sm-10 col-md-9">
						<div class="row">
							<div class="col-xs-12 col-md-4">
								<ul>
									<li><a href="#">صفحه اصلی</a></li>
									<li><a href="#">درباره ما</a></li>
									<li><a href="#">تماس با ما</a></li>
									<li><a href="#">خبرنامه</a></li>
								</ul>
							</div>
							<div class="col-xs-12 col-md-4">
								<ul>
									<li><a href="#">صفحه اصلی</a></li>
									<li><a href="#">درباره ما</a></li>
									<li><a href="#">تماس با ما</a></li>
									<li><a href="#">خبرنامه</a></li>
								</ul>
							</div>
							<div class="col-xs-12 col-md-4">
								<ul>
									<li><a href="#">صفحه اصلی</a></li>
									<li><a href="#">درباره ما</a></li>
									<li><a href="#">تماس با ما</a></li>
									<li><a href="#">خبرنامه</a></li>
								</ul>
							</div>
						</div>
						<jdoc:include type="modules" name="sitemap" />
					</div>
					<div class="col-xs-12 col-sm-2 col-md-3">
						<a href="<?php echo JURI::base(); ?>" class="footer-logo"><img src="<?php echo JURI::base() ?>assets/img/logo_footer_tehran.png" /></a>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if ($helper->countModules('copyright')) { ?>
		<div id="copyright" class="wrapper purple">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<jdoc:include type="modules" name="copyright" />
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</footer>
<script src="<?php echo JURI::base(); ?>assets/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo JURI::base(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo JURI::base(); ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo JURI::base(); ?>assets/js/jquery.nanoscroller.min.js"></script>
<script src="<?php echo JURI::base(); ?>assets/js/tehran.min.js?_=20160326"></script>
<script type="text/javascript">
    // Piwik code
</script>
</body>