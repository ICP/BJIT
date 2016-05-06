<body id="bd" class="<?php echo $theme . ' ' . strtolower($helper->device); ?>" data-spy="scroll" data-target="#menu">
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
		<div class="wrapper gray-dark">
			<jdoc:include type="modules" name="showcase" style="basic" />
		</div>
	</section>
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
				<?php if ($helper->countModules('main')) { ?>
					<div id="main" class="row">
						<div class="col-xs-12">
							<jdoc:include type="modules" name="main" style="default" />
						</div>
					</div>
				<?php } ?>
				<?php if ($helper->countModules('main-bot')) { ?>
					<div id="main-bot" class="row">
						<div class="col-xs-12">
							<jdoc:include type="modules" name="main-bot" style="default" />
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</main>
<footer id="footer">
	<?php if ($helper->countModules('newsletter')) { ?>
		<div id="newsletter" class="wrapper gray-darker">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<jdoc:include type="modules" name="newsletter" />
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if ($helper->countModules('sitemap')) { ?>
		<div id="sitemap" class="wrapper gray-dark">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-md-9">
						<jdoc:include type="modules" name="footer" />
					</div>
					<div class="col-xs-12 col-sm-2 col-md-3">
						<a href="<?php echo JURI::base(); ?>"><img src="<?php echo JURI::base() ?>assets/img/logo_footer.png" /></a>
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