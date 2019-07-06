<?php
$pageOptions = JFactory::getApplication()->input->getArray();
if (isset($pageOptions['task'])) {
	if ($pageOptions['task'] === "user" ||
			stristr($pageOptions['task'], 'confirm')) {
		$isFrontpage = false;
	}
}
$titleTag = JFactory::getApplication()->input->get('view') === "item" ? ['<strong>', '</strong>'] : ['<h1>', '</h1>'];
$pagetitle = isset(JFactory::getApplication()->getMenu()->getActive()->title) ? JFactory::getApplication()->getMenu()->getActive()->title : $sitename;
?>
<body id="bd" class="<?php echo strtolower($helper->device) . ($isFrontpage ? ' home' : '') . (isset(JFactory::getApplication()->getMenu()->getActive()->alias) ? ' alias-' . JFactory::getApplication()->getMenu()->getActive()->alias : ''); ?>">
	<header id="header">
		<?php if ($isFrontpage) { ?><h1 style="display: none;"><?php echo $sitename; ?></h1><?php } ?>
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-6 logo-container">
					<?php if ($helper->countModules('logo')) { ?>
						<jdoc:include type="modules" name="logo" style="default" />
					<?php } ?>
					<div class="logo">
						<a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
					</div>
					<div class="date d-none"><?php echo str_replace(',', '،', JHTML::_('date', date('Y-m-d H:i:s', time()), JText::_('DATE_FORMAT_LC1'))); ?></div>
					<div class="menu-toggle d-md-none"><a href="#" data-toggle="come-in" data-target="#menu"><i class="icon-menu"></i></a></div>
					<a class="search-toggle d-lg-none" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i></a>
				</div>
				<!--<div class="col-lg-2"></div>-->
				<div class="col-12 col-md-12 col-lg-6 d-none d-lg-block d-xl-block">
					<?php if ($helper->countModules('header-left')) { ?>
						<jdoc:include type="modules" name="header-left" style="default" />
					<?php } ?>
					<section class="box ads">
						<div>
							<ul>
								<li>
									<div class="placeholder"></div>
								</li>
							</ul>
						</div>
					</section>
				</div>
			</div>
		</div>
		<nav id="menu" class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-10">
						<a href="<?php echo JURI::base(); ?>" class="logo-alt"></a>
						<?php if ($helper->countModules('menu')) { ?>
							<jdoc:include type="modules" name="menu" />
						<?php } ?>
					</div>
					<div class="col-md-2">
						<ul class="tools-menu">
							<li>
								<a class="search-toggle" href="<?php echo JURI::base() . 'search'; ?>" data-toggle="toggle" data-target="#search" data-focus="#search input[type='text']"><i class="icon-search"></i><span>جستجو</span></a>
							</li>
							<?php if ($lang != "en") { ?>
								<li>
									<a class="user-link" href="<?php echo JURI::base() . 'user/profile'; ?>"><i class="icon-user"></i><span>حساب کاربری</span></a>
								</li>
								<li>
									<a class="cart-link" href="<?php echo JURI::base() . 'shop/cart'; ?>"><i class="icon-basket"></i><span>سبد خرید</span></a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</header>
<?php if ($helper->countModules('search')) { ?><jdoc:include type="modules" name="search" /><?php } ?>
<?php /* if ($isFrontpage) { ?>
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
  <div class="col-12">
  <jdoc:include type="modules" name="top" style="default" />
  </div>
  </div>
  </div>
  <?php } ?>
  </aside>
  <?php } */ ?>
<main id="mainbody">
	<section data-identifier="main-top" class="wrapper content">
		<?php if (!$isFrontpage) { ?>
			<div class="page">
				<header class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<?php echo $titleTag[0] . $pagetitle . $titleTag[1]; ?>
							</div>
						</div>
					</div>
				</header>
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-7">
							<?php if (stristr($pageOptions['option'], 'store') || stristr($pageOptions['option'], 'user')) { ?><jdoc:include type="message" /><?php } ?>
							<jdoc:include type="component" />
							<div class="hide"><jdoc:include type="message" /></div>
						</div>
						<div id="sidebar" class="col-12 col-md-3">
							<jdoc:include type="modules" name="sidebar" style="default" />
						</div>
						<div class="col-12 col-md-2">
							<jdoc:include type="modules" name="ads" style="default" />
							<section class="box ads">
								<header>
									<h2>تبلیغات</h2>
								</header>
								<div>
									<ul>
										<li><div class="placeholder">[تبلیغات]</div></li>
										<li><div class="placeholder">[تبلیغات]</div></li>
										<li><div class="placeholder">[تبلیغات]</div></li>
										<li><div class="placeholder">[تبلیغات]</div></li>
										<li><div class="placeholder">[تبلیغات]</div></li>
									</ul>
								</div>
							</section>
						</div>
						<?php /*
						<div class="<?php echo (JFactory::getApplication()->getMenu()->getActive()->note === 'cols-9-3') ? "col-12 col-md-9" : "col-12"; ?>">
							<?php if (stristr($pageOptions['option'], 'store') || stristr($pageOptions['option'], 'user')) { ?><jdoc:include type="message" /><?php } ?>
							<jdoc:include type="component" />
							<div class="hide"><jdoc:include type="message" /></div>
						</div>
						<?php if (JFactory::getApplication()->getMenu()->getActive()->note === 'cols-9-3') { ?>
							<div id="sidebar" class="col-12 col-md-3">
								<jdoc:include type="modules" name="sidebar" style="default" />
							</div>
						<?php } ?>
						*/ ?>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<div class="container">
				<div id="main-top" class="row">
					<div class="col-12 col-md-8">
						<?php if ($helper->countModules('top')) { ?>
							<jdoc:include type="modules" name="top" style="default" />
						<?php } ?>
					</div>
					<div class="col-12 col-md-4">
						<?php if ($helper->countModules('top-left')) { ?>
							<jdoc:include type="modules" name="top-left" style="default" />
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</section>
	<?php if ($isFrontpage) { ?>
		<?php if ($helper->countModules('special')) { ?>
			<section id="special" data-identifier="main" class="wrapper gray">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<jdoc:include type="modules" name="special" style="default" />
						</div>
					</div>
				</div>
			</section>
		<?php } ?>
		<section data-identifier="main" class="wrapper">
			<div class="container">
				<div id="main" class="row">
					<div class="col-12 col-md-9">
						<jdoc:include type="modules" name="main" style="default" />
					</div>
					<div class="col-12 col-md-3">
						<jdoc:include type="modules" name="sidebar" style="default" />
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
	<?php if ($helper->countModules('ads-bot')) { ?>
		<section data-identifier="subscribe" class="wrapper gray">
			<div class="container">
				<div id="main-bot" class="row">
					<div class="col-12">
						<jdoc:include type="modules" name="ads-bot" style="default" />
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
	<?php if ($isFrontpage) { ?>
		<?php if ($helper->countModules('main-bot')) { ?>
			<section data-identifier="main-bot" class="wrapper">
				<div class="container">
					<div id="main-bot" class="row">
						<div class="col-12">
							<jdoc:include type="modules" name="main-bot" style="default" />
						</div>
					</div>
				</div>
			</section>
		<?php } ?>
	<?php } ?>
</main>
<footer id="footer">
	<?php if ($helper->countModules('subscribe')) { ?>
	<div id="subscribe" class="wrapper dark">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<jdoc:include type="modules" name="subscribe" />
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if ($helper->countModules('footer')) { ?>
		<div id="sitemap" class="wrapper">
			<div class="container">
				<div class="row _relative">
					<div class="col-12 col-md-4">
						<jdoc:include type="modules" name="footer" />
					</div>
					<div class="col-12 col-md-4">
						<div id="footer-signs">
							<div class="placeholder"></div>
							<div class="placeholder"></div>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<a href="<?php echo JURI::base(); ?>" id="footer-logo"><img src="<?php echo JURI::base() ?>assets/img/ngomag/logo.svg" /></a>
						<jdoc:include type="modules" name="footer-left" />
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if ($helper->countModules('copyright')) { ?>
		<div id="copyright" class="wrapper dark">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<jdoc:include type="modules" name="copyright" />
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</footer>
<?php /* <script src="<?php echo JURI::base(); ?>assets/js/jquery-1.11.1.min.js"></script> */ ?>
<script src="<?php echo JURI::base(); ?>assets/js/ngomag.min.js?_=20171022_3"  type="text/javascript"></script>

</body>