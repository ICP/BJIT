<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined('_JEXEC') or die;

class J2storeTableApp extends F0FTable
{
  public function __construct($table, $key, &$db)
  {
  	$table = "#__extensions";
  	$key = "extension_id";
	parent::__construct($table, $key, $db);

  }


}