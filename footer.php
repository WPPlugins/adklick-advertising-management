<?php
function wp_adklick_wp_footer(){
if (!empty($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] !== 'off') $server='https://ssl.adklick.de'; else $server='http://partners.adklick.de';
	$options = get_option('wp_adklick_options');

	$intextad = wp_adklick_sanitize_array($options['intextad'], array('status', 'rules_user_status', 'rules_admin_status', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions', 'settings_intext_id', 'settings_intext_select', 'settings_intext_color'));
	if(wp_adklick_get_ad_status($intextad)) {
		echo '<script src="'.$server.'/intext.php?id='.$intextad['settings_intext_id'].'&data=wordpress&color='.$intextad['settings_intext_color'].'&maxunderline='.$intextad['settings_intext_select'].'" language="JavaScript"></script>';
	}

	$popdown = wp_adklick_sanitize_array($options['popdown'], array('status', 'rules_user_status', 'rules_admin_status', 'settings_popunder_id', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions'));
	if(wp_adklick_get_ad_status($popdown)){
		echo '<script src="'.$server.'/multiad.php?id='.$popdown['settings_popunder_id'].'&mode=popdown" language="JavaScript"></script>';
	}

	$layer = wp_adklick_sanitize_array($options['layer'], array('status', 'rules_user_status', 'rules_admin_status', 'settings_layer_id', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions'));
	if(wp_adklick_get_ad_status($layer)){
		echo '<script src="'.$server.'/multiad.php?id='.$layer['settings_layer_id'].'&mode=layer" language="JavaScript"></script>';
	}
}

add_action('wp_footer', 'wp_adklick_wp_footer');
?>