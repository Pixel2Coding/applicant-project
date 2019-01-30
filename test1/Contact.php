<?php
ini_set("display_errors", true);
require_once("./AbstractModel.php");
Class Contact extends AbstractModel
{
	protected $_table = "contacts";
	protected $_pk	  = "id";
}