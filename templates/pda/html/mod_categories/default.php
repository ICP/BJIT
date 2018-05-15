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
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel tiles">
				<div class="panel-heading text-center">
					<h2>هفت اقلیم گردشگری</h2>
				</div>
				<div class="tiles">
					<ul class="list-unstyled list-inline text-center">
						<li>
							<a href="<?php echo JURI::base() . 'categories/nature?format=raw'; ?>" data-catid="5">
								<span class="icon">
									<i class="icon-nature"></i>
								</span>
								<span class="title">طبیعت</span>
							</a>
						</li>
						<li>
							<a href="<?php echo JURI::base() . 'categories/pilgrimage?format=raw'; ?>" data-catid="6">
								<span class="icon">
									<i class="icon-mosque"></i>
								</span>
								<span class="title">زیارت</span>
							</a>
						</li>
						<li>
							<a href="<?php echo JURI::base() . 'categories/health?format=raw'; ?>" data-catid="7">
								<span class="icon">
									<i class="icon-health"></i>
								</span>
								<span class="title">سلامت</span>
							</a>
						</li>
						<li>
							<a href="<?php echo JURI::base() . 'categories/music?format=raw'; ?>" data-catid="8">
								<span class="icon">
									<i class="icon-music"></i>
								</span>
								<span class="title">موسیقی</span>
							</a>
						</li>
						<li>
							<a href="<?php echo JURI::base() . 'categories/ancient-relics?format=raw'; ?>" data-catid="9">
								<span class="icon">
									<i class="icon-history"></i>
								</span>
								<span class="title">آثار باستانی</span>
							</a>
						</li>
						<li>
							<a href="<?php echo JURI::base() . 'categories/traditions?format=raw'; ?>" data-catid="10">
								<span class="icon">
									<i class="icon-society"></i>
								</span>
								<span class="title">آداب و سنن</span>
							</a>
						</li>
						<li>
							<a href="<?php echo JURI::base() . 'categories/foods?format=raw'; ?>" data-catid="11">
								<span class="icon">
									<i class="icon-food"></i>
								</span>
								<span class="title">خوراک</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="itemlist" style="display: none;">
					<div class="close">&times;</div>
					<div class="inner" style="display: none">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>