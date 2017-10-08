<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Sasi varna kumar - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

class J2StoreTableProductprice extends F0FTable
{
	public function __construct($table, $key, &$db)
	{
		$table = "#__j2store_product_prices";
		$key = "j2store_productprice_id";
		parent::__construct($table, $key, $db);
	}
	public function check()
	{
		$date = new JDate($this->date_from);
		$this->date_from = $date->toSql();
		$date1= new JDate($this->date_to);
		$this->date_to = $date1->toSql();
		return parent::check();
	}


}
