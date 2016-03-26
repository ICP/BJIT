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
					<h2>علاقه‌مندان</h2>
				</div>
				<div class="tiles">
					<ul class="list-unstyled list-inline text-center">
						<li>
							<a href="<?php echo JURI::base() . 'enthusiasts/nature?format=raw'; ?>" data-catid="5">
								<span class="icon">
									<i class="icon-placeholder"></i>
								</span>
								<span class="title">آشنایی</span>
							</a>
						</li>
						<li>
							<a href="<?php echo JURI::base() . 'enthusiasts/join?format=raw'; ?>" data-catid="19">
								<span class="icon">
									<i class="icon-placeholder"></i>
								</span>
								<span class="title">عضویت</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="itemlist" style="display: none;">
					<div class="close">&times;</div>
					<div class="inner" style="display: none"></div>
				</div>
			</div>
		</div>
	</div>
</div>