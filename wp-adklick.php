<?php
/*
Plugin Name: AdKlick Advertising Management
Plugin URI: http://media.adklick.net/tools/
Description: AdKlick Advertising Management
Version: 1.3
Author: Krusenstern Media GmbH
Author URI: http://www.adklick.net
AdKlick Advertising Management Plugin
*/
/*Definitions*/
if(!defined('WP_ADKLICK_URL'))
	define('WP_ADKLICK_URL',WP_PLUGIN_URL.'/adklick-advertising-management');
if(!defined('WP_ADKLICK_DIR'))
	define('WP_ADKLICK_DIR',WP_PLUGIN_DIR.'/adklick-advertising-management');

/*Includes*/
require_once (dirname(__FILE__).'/admin-page.php');
require_once(dirname(__FILE__).'/controls.php');
require_once (dirname(__FILE__).'/content.php');
require_once (dirname(__FILE__).'/footer.php');
require_once (dirname(__FILE__).'/sanitize.php');
require_once (dirname(__FILE__).'/status.php');
require_once (dirname(__FILE__).'/ajax.php');
?>