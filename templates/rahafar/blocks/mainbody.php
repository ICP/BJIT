<?php
$pageOptions = JFactory::getApplication()->input->getArray();
if (isset($pageOptions['task'])) {
	if ($pageOptions['task'] === "user" ||
			stristr($pageOptions['task'], 'confirm')) {
		$isFrontpage = false;
	}
}
//if (isset($pageOptions['task']) && $pageOptions['task'] === "user")
//	$isFrontpage = false;
//print_r();
$titleTag = JFactory::getApplication()->input->get('view') === "item" ? ['<strong>', '</strong>'] : ['<h1>', '</h1>'];
$pagetitle = isset(JFactory::getApplication()->getMenu()->getActive()->title) ? JFactory::getApplication()->getMenu()->getActive()->title : $sitename;
?>
<body id="bd" class="dark <?php echo strtolower($helper->device) . ($isFrontpage ? ' home' : '') . ($isProgram ? ' home program' : '') . (isset(JFactory::getApplication()->getMenu()->getActive()->alias) ? ' alias-' . JFactory::getApplication()->getMenu()->getActive()->alias : ''); ?>" dir="<?php echo $this->direction; ?>">
	<header id="header">
		<?php if ($isFrontpage) { ?><h1 style="display: none;"><?php echo $sitename; ?></h1><?php } ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-6 col-md-6 logo-container">
					<?php if ($helper->countModules('logo')) { ?>
						<jdoc:include type="modules" name="logo" style="default" />
					<?php } ?>
					<div class="logo">
						<a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
					</div>
				</div>
				<div class="col-xs-6 col-md-6">
					<div class="menu-toggle hidden-md hidden-lg"><a href="#" data-toggle="menuslide" data-target=".menu"><i class="icon-menu"></i></a></div>
					<!--<a class="search-toggle hidden-md hidden-lg" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i></a>-->
					<?php if ($helper->countModules('menu')) { ?>
						<jdoc:include type="modules" name="menu" />
					<?php } ?>
				</div>
			</div>
		</div>
	</header>
	<?php /* if ($helper->countModules('search')) { ?><jdoc:include type="modules" name="search" /><?php } */ ?>
	<?php if ($isFrontpage) { ?>
		<?php if ($helper->countModules('showcase')) { ?>
			<section id="showcase">
				<div data-identifier="showcase" class="wrapper">
					<jdoc:include type="modules" name="showcase" style="default" />
				</div>
			</section>
		<?php } ?>
		<?php if ($helper->countModules('top')) { ?>
			<aside id="top" class="wrapper">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<jdoc:include type="modules" name="top" style="default" />
						</div>
					</div>
				</div>
			</aside>
		<?php } ?>
	<?php } ?>
	<main id="mainbody">
		<section data-identifier="main-top" class="wrapper content">
			<?php if (!$isFrontpage) { ?>
				<section id="breadcrumbs">
					<div class="container">
						<?php if ($helper->countModules('breadcrumbs')) { ?>
							<div class="row">
								<div class="col-xs-12">
									<jdoc:include type="modules" name="breadcrumbs" style="default" />
								</div>
							</div>
						<?php } ?>
					</div>
				</section>
				<div class="page">
					<jdoc:include type="component" />
				</div>
			<?php } ?>
			<?php if ($isFrontpage) { ?>
				<div class="container">
					<?php if ($helper->countModules('main-top')) { ?>
						<div id="main-top" class="row">
							<div class="col-xs-12">
								<jdoc:include type="modules" name="main-top" style="default" />
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</section>
		<?php if ($isFrontpage) { ?>
			<section data-identifier="main" class="wrapper content">
				<?php if ($helper->countModules('special')) { ?>
					<section id="special">
						<div class="wrapper purple-light">
							<div class="container">
								<div class="row">
									<div class="col-xs-12">
										<jdoc:include type="modules" name="special" style="default" />
									</div>
								</div>
							</div>
						</div>
					</section>
				<?php } ?>
			</section>
			<?php if ($helper->countModules('main')) { ?>
				<section data-identifier="main" class="wrapper content">
					<div class="container">
						<div id="main" class="row">
							<div class="col-xs-12">
								<jdoc:include type="modules" name="main" style="default" />
							</div>
						</div>
					</div>
				</section>
			<?php } ?>
		<?php } ?>
		<?php if ($helper->countModules('bot')) { ?>
			<section data-identifier="bot" class="wrapper">
				<jdoc:include type="modules" name="bot" style="default" />
			</section>
		<?php } ?>
		<div id="subscribe" class="wrapper gray-lighter">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<jdoc:include type="modules" name="subscribe" />
						<section class="box newsletter inline">
							<header>
								<h2><?php echo JText::_('SUBSCRIBE_TO_OUR_NEWSLETTER'); ?></h2>
							</header>
							<div>
								<form action="#" role="form" class="form-inline">
									<div class="form-group">
										<input class="form-control ltr" name="name" type="text" placeholder="Your Name" />
										<input class="form-control ltr" name="email" type="email" placeholder="Your Email Address" />
										<button type="submit" class="btn btn-warning"><?php echo JText::_('SUBSCRIBE'); ?></button>
									</div>
								</form>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
		<?php // } ?>
		<?php if ($isFrontpage) { ?>
			<?php if ($helper->countModules('main-bot')) { ?>
				<section data-identifier="main-bot" class="wrapper content">
					<div class="container">
						<div id="main-bot" class="row">
							<div class="col-xs-12">
								<jdoc:include type="modules" name="main-bot" style="default" />
							</div>
						</div>
					</div>
				</section>
			<?php } ?>
		<?php } ?>
	</main>
	<footer id="footer">
		<?php if ($helper->countModules('footer')) { ?>
			<div id="sitemap" class="wrapper gray-lightest">
				<div class="container">
					<div class="row _relative">
						<div class="col-xs-12 col-sm-10 col-md-6">
							<jdoc:include type="modules" name="footer" />
						</div>
						<div class="col-md-3">
							<div class="samandehi-holder">

							</div>
						</div>
						<div class="col-xs-12 col-sm-2 col-md-3">
							<a href="<?php echo JURI::base(); ?>" class="footer-logo"><img src="<?php echo JURI::base() ?>assets/img/logo_footer_gilgamesh<?php echo ($lang == "en") ? '_en' : ''; ?>.png" /></a>

						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($helper->countModules('copyright')) { ?>
			<div id="copyright" class="wrapper blue">
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
	<?php /* <script src="<?php echo JURI::base(); ?>assets/js/jquery-1.11.1.min.js"></script> */ ?>
	<script src="<?php echo JURI::base(); ?>assets/js/rahafar.min.js?_=20171006"  type="text/javascript"></script>
	<!-- Global Site Tag (gtag.js) - Google Analytics -->
	<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-63573054-2"></script>
	<script>
									window.dataLayer = window.dataLayer || [];
									function gtag() {
										dataLayer.push(arguments)
									}
									;
									gtag('js', new Date());
									gtag('config', 'UA-63573054-2');
	</script>-->
	<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=faridv"></script>--> 
</body>