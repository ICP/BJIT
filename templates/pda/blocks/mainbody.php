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
<body id="bd" class="<?php echo strtolower($helper->device) . ($isFrontpage ? ' home' : '') . ($isProgram ? ' home program' : '') . (isset(JFactory::getApplication()->getMenu()->getActive()->alias) ? ' alias-' . JFactory::getApplication()->getMenu()->getActive()->alias : ''); ?>" dir="<?php echo $this->direction; ?>">
	<header id="header">
		<?php if ($isFrontpage) { ?><h1 style="display: none;"><?php echo $sitename; ?></h1><?php } ?>
		<div class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-4">
						<?php if ($helper->countModules('logo')) { ?>
							<jdoc:include type="modules" name="logo" style="default" />
						<?php } ?>
						<a class="logo" href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
<!--						<button type="button" data-toggle="toggle" data-target="#header .search" class="d-md-none btn">
							<i class="icon-search"></i>
						</button>-->
						<button type="button" data-toggle="toggle" data-target="#menu > ul" class="d-md-none btn" data-pt="home">
							<i class="icon-menu"></i>
						</button>
					</div>
					<div class="col-12 col-sm-8">
						<?php if ($helper->countModules('menu')) { ?>
							<nav id="menu">
								<jdoc:include type="modules" name="menu" />
							</nav>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</header>
<?php if ($helper->countModules('search')) { ?><jdoc:include type="modules" name="search" /><?php } ?>
<?php if ($isFrontpage) { ?>
	<?php if ($helper->countModules('showcase')) { ?>
		<section id="showcase">
			<div data-identifier="showcase">
				<jdoc:include type="modules" name="showcase" style="basic" />
			</div>
		</section>
	<?php } ?>
	<section id="top-wrapper" class="wrapper">
		<div class="container">
			<?php if ($helper->countModules('top')) { ?>
				<div id="top" class="row">
					<div class="col-12">
						<jdoc:include type="modules" name="top" style="default" />
					</div>
				</div>
			<?php } ?>
			<?php if ($helper->countModules('left') || $helper->countModules('right')) { ?>
				<div class="row">
					<div class="col-6">
						<jdoc:include type="modules" name="right" style="default" />
					</div>
					<div class="col-6">
						<jdoc:include type="modules" name="left" style="default" />
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
	<?php if ($isFrontpage) { ?>
		<?php if ($helper->countModules('special-right') || $helper->countModules('main-special')) { ?>
			<div class="wrapper bg-primary">
				<div class="container">
					<div class="row">
						<div id="special-right" class="col-12 col-md-6 bg-accent">
							<jdoc:include type="modules" name="special-right" style="default" />
						</div>
						<div id="special-left" class="col-12 col-md-6">
							<jdoc:include type="modules" name="special-left" style="default" />
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($helper->countModules('main')) { ?>
			<section data-identifier="main" class="wrapper">
				<div class="container">
					<div id="main" class="row">
						<div class="col-12">
							<jdoc:include type="modules" name="main" style="default" />
						</div>
					</div>
				</div>
			</section>
		<?php } ?>
		<?php if ($helper->countModules('main-right') || $helper->countModules('main-left')) { ?>
			<div class="wrapper gray">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<section class="box header-lg header-center header-clean ">
								<header>
									<h2>حمایت</h2>
								</header>
							</section>
						</div>
					</div>
					<div class="row">
						<div id="main-right" class="col-12 col-md-6">
							<jdoc:include type="modules" name="main-right" style="default" />
						</div>
						<div id="main-left" class="col-12 col-md-6">
							<jdoc:include type="modules" name="main-left" style="default" />
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
	<?php if ($helper->countModules('bot-top')) { ?>
		<div id="bot-top">
			<jdoc:include type="modules" name="bot-top" style="default" />
		</div>
	<?php } ?>
<?php } ?>
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
						<div class="col-12">
							<div class="component-container">
								<div class="row">
									<div class="<?php echo (JFactory::getApplication()->getMenu()->getActive()->note === 'cols-8-4') ? "col-12 col-md-8" : "col-12"; ?>">
										<?php if (stristr($pageOptions['option'], 'store') || stristr($pageOptions['option'], 'user')) { ?><jdoc:include type="message" /><?php } ?>
										<!--<section class="page-content">-->
										<jdoc:include type="component" />
										<!--</section>-->
										<div class="hide"><jdoc:include type="message" /></div>
									</div>
									<?php if (JFactory::getApplication()->getMenu()->getActive()->note === 'cols-8-4') { ?>
										<div id="sidebar" class="col-12 col-md-4">
											<jdoc:include type="modules" name="sidebar" style="default" />
											<?php if ($helper->countModules('sidebar-bot')) { ?>
												<div id="sidebar-bot">
													<section class="box header-lg header-center header-clean ">
														<header>
															<h2>حمایت</h2>
														</header>
													</section>
													<jdoc:include type="modules" name="sidebar-bot" style="default" />
												</div>
											<?php } ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($isFrontpage) { ?>
			<div class="container">
				<?php if ($helper->countModules('main-top')) { ?>
					<div id="main-top" class="row">
						<div class="col-12">
							<jdoc:include type="modules" name="main-top" style="default" />
						</div>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</section>
	<?php if ($helper->countModules('subscribe')) { ?>
		<section id="subscribe" class="content">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<jdoc:include type="modules" name="subscribe" style="default" />
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
	<?php if ($helper->countModules('bot')) { ?>
		<div id="bot" class="wrapper">
			<div class="container">
				<div class="row">
					<div id="bot" class="col-12">
						<jdoc:include type="modules" name="bot" style="default" />
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</main>
<footer id="footer">
	<?php if ($helper->countModules('footer')) { ?>
		<div id="sitemap" class="wrapper gray-lightest">
			<div class="container">
				<div class="row _relative">
					<div class="col-12">
						<jdoc:include type="modules" name="footer" />
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if ($helper->countModules('copyright')) { ?>
		<div id="copyright" class="wrapper">
			<div class="container">
				<div class="row">
					<jdoc:include type="modules" name="copyright" />
				</div>
			</div>
		</div>
	<?php } ?>
</footer>
<?php /* <script src="<?php echo JURI::base(); ?>assets/js/jquery-1.11.1.min.js"></script> */ ?>
<script src="<?php echo JURI::base(); ?>assets/js/pda.min.js?_=20170805"  type="text/javascript"></script>
</body>