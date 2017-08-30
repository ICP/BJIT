<body id="bd" class="dark <?php echo strtolower($helper->device) . ($isFrontpage ? ' home' : '') . ($isProgram ? ' home program' : ''); ?>" data-spy="scroll" data-target="#menu">
	<header id="header">
		<?php if ($isFrontpage) { ?><h1 class="hide"><?php echo $sitename; ?></h1><?php } ?>
		<div id="masthead" class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="logo">
							<a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
						</div>
						<div class="menu-toggle hidden-md hidden-lg"><a href="#" data-toggle="menuslide" data-target=".menu"><i class="icon-menu"></i></a></div>
					</div>
				</div>
			</div>
		</div>
		<div id="navbar" class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php if ($helper->countModules('menu')) { ?>
							<jdoc:include type="modules" name="menu" />
						<?php } ?>
							<div class="search hidden-sm hidden-xs">
							<a class="search-toggle" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
<?php if ($helper->countModules('search')) { ?><jdoc:include type="modules" name="search" /><?php } ?>
<?php if ($helper->countModules('showcase') || $isProgram) { ?>
	<section id="showcase">
		<div data-identifier="showcase" class="wrapper">
			<jdoc:include type="modules" name="showcase" style="basic" />
			<?php if ($isProgram) { ?>
				<div class="page">
					<header class="page-header hide">
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<h1><?php echo isset(JFactory::getApplication()->getMenu()->getActive()->title) ? JFactory::getApplication()->getMenu()->getActive()->title : $sitename; ?></h1>
								</div>
							</div>
						</div>
					</header>
					<jdoc:include type="component" />
				</div>
			<?php } ?>
		</div>
	</section>
<?php } ?>
<main id="mainbody">
	<div data-identifier="main-top" class="wrapper content gray-lighter">
		<?php if (!$isFrontpage && !$isProgram) { ?>
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
				<?php if (!$isProgram) { ?>
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
				<?php } ?>
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
						<ul class="list-inline">
							<li><a href="<?php echo JURI::base(); ?>">صفحه اصلی</a></li>
							<li><a href="<?php echo JURI::base(); ?>about-us">درباره ما</a></li>
							<li><a href="<?php echo JURI::base(); ?>contact-us">تماس با ما</a></li>
							<li><a href="#">خبرنامه</a></li>
						</ul>
						<jdoc:include type="modules" name="sitemap" />
					</div>
					<div class="col-xs-12 col-sm-2 col-md-3">
						<a href="<?php echo JURI::base(); ?>" class="footer-logo"><img src="<?php echo JURI::base() ?>assets/img/logo_tehran.png" /></a>
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
<script src="<?php echo JURI::base(); ?>assets/js/gilgamesh.min.js"></script>
<script type="text/javascript">
    // Piwik code
</script>
</body>