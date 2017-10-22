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
		<div id="masthead" class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-3">
						<?php if ($helper->countModules('header-right')) { ?>
							<jdoc:include type="modules" name="header-right" style="default" />
						<?php } ?>
					</div>
					<div class="col-xs-12 col-md-6 logo-container">
						<?php if ($helper->countModules('logo')) { ?>
							<jdoc:include type="modules" name="logo" style="default" />
						<?php } ?>
						<div class="logo">
							<a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
						</div>
						<div class="menu-toggle hidden-md hidden-lg"><a href="#" data-toggle="menuslide" data-target=".menu"><i class="icon-menu"></i></a></div>
						<a class="search-toggle hidden-md hidden-lg" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i></a>

					</div>
					<div class="col-xs-12 col-md-3">
						<?php if ($helper->countModules('header-left')) { ?>
							<jdoc:include type="modules" name="header-left" style="default" />
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div id="navbar" class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<a href="<?php echo JURI::base(); ?>" class="logo-alt"></a>
						<?php if ($helper->countModules('menu')) { ?>
							<jdoc:include type="modules" name="menu" />
						<?php } ?>
						<div class="search hidden-sm hidden-xs">
							<a class="search-toggle" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i></a>
							<?php if ($lang != "en") { ?>
								<a class="user-link" href="<?php echo JURI::base() . 'user/profile'; ?>"><i class="icon-user"></i></a>
								<a class="cart-link" href="<?php echo JURI::base() . 'shop/cart'; ?>"><i class="icon-basket"></i></a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
<?php if ($helper->countModules('search')) { ?><jdoc:include type="modules" name="search" /><?php } ?>
<?php if ($isFrontpage) { ?>
	<?php if ($helper->countModules('showcase')) { ?>
		<section id="showcase">
			<div data-identifier="showcase" class="wrapper">
				<jdoc:include type="modules" name="showcase" style="basic" />
			</div>
		</section>
	<?php } ?>
	<aside id="top" class="wrapper">
		<?php if ($helper->countModules('top')) { ?>
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<jdoc:include type="modules" name="top" style="default" />
					</div>
				</div>
			</div>
		<?php } ?>
	</aside>
<?php } ?>
<main id="mainbody">
	<section data-identifier="main-top" class="wrapper content">
		<?php if (!$isFrontpage) { ?>
			<div class="page">
				<header class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<?php echo $titleTag[0] . $pagetitle . $titleTag[1]; ?>
							</div>
						</div>
					</div>
				</header>
				<div class="container">
					<div class="row">
						<div class="<?php echo (JFactory::getApplication()->getMenu()->getActive()->note === 'cols-9-3') ? "col-xs-12 col-md-9" : "col-xs-12"; ?>">
							<?php if (stristr($pageOptions['option'], 'store') || stristr($pageOptions['option'], 'user')) { ?><jdoc:include type="message" /><?php } ?>
							<!--<section class="page-content">-->
							<jdoc:include type="component" />
							<!--</section>-->
							<div class="hide"><jdoc:include type="message" /></div>
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
		<section data-identifier="main" class="wrapper content gray-lighter">
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
	<?php if ($helper->countModules('ads-bot')) { ?>
		<section data-identifier="subscribe" class="wrapper content gray-lighter">
			<div class="container">
				<div id="main-bot" class="row">
					<div class="col-xs-12">
						<jdoc:include type="modules" name="ads-bot" style="default" />
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
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
	<?php // if ($helper->countModules('newsletter')) { ?>
	<div id="subscribe" class="wrapper gray">
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
									<input class="form-control ltr" name="email" type="email" placeholder="ایمیل خود را وارد کنید" />
									<button type="submit" class="btn btn-default"><?php echo JText::_('SUBSCRIBE'); ?></button>
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
					<div class="col-xs-12 col-sm-10 col-md-6">
						<jdoc:include type="modules" name="footer" />
						<ul class="list-inline app-links">
							<li>
								<a href="https://play.google.com/store/apps/details?id=com.Mehrafarid.Gilgamesh">
									<img src="https://play.google.com/intl/en_us/badges/images/generic/<?php echo ($lang == "en") ? 'en_' : 'fa_'; ?>badge_web_generic.png" />
								</a>
							</li>
						</ul>
					</div>
					<div class="col-md-3">
						<div class="samandehi-holder">
							<img id="sizpnbqesizpesgtapfu" class="logo-samandehi" onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=92905&p=pfvluiwkpfvlobpddshw", "Popup", "toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt="logo-samandehi" src="https://logo.samandehi.ir/logo.aspx?id=92905&p=bsiyodrfbsiylymaujyn" />
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
<script src="<?php echo JURI::base(); ?>assets/js/gilgamesh.min.js?_=20171022_3"  type="text/javascript"></script>
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-63573054-2"></script>
<script>
                                window.dataLayer = window.dataLayer || [];
                                function gtag() {
                                    dataLayer.push(arguments)
                                }
                                ;
                                gtag('js', new Date());
                                gtag('config', 'UA-63573054-2');
</script>

</body>