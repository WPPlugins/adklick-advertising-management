<?php
add_filter('the_content', 'wp_adklick_filter_the_content');
function wp_adklick_filter_the_content($content) {
if (!empty($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] !== 'off') $server='https://ssl.adklick.de'; else $server='http://partners.adklick.de';
	if(is_main_query()) {
		$options = get_option('wp_adklick_options');
		$banner = wp_adklick_sanitize_array($options['banner'], array('status', 'rules_user_status', 'rules_admin_status', 'settings_banner_id', 'settings_banner_select', 'settings_banner_location', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions'));
		
		$intextad = wp_adklick_sanitize_array($options['intextad'], array('status', 'rules_user_status', 'rules_admin_status', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions', 'settings_intext_id', 'settings_intext_select', 'settings_intext_color'));
		if(wp_adklick_get_ad_status($intextad)) {
			$content = '<!-- aeBeginAds -->'.$content.'<!-- aeEndAds -->';
		}
		
		if(wp_adklick_get_ad_status($banner)) {
			preg_match_all('!\d+!', $banner['settings_banner_select'], $matches);
			if($banner['settings_banner_location'] == 'above') {
				$content = '<div class="wp_adklick_banner" style="margin: 10px 0;"><script src="'.$server.'/multiad.php?id='.$banner['settings_banner_id'].'&data=wordpress&width='.$matches[0][0].'&height='.$matches[0][1].'&random='.rand(1, 5000).'" language="JavaScript"></script></div>'.$content;
			} else {
				$content .= '<div class="wp_adklick_banner" style="margin: 10px 0;"><script src="'.$server.'/multiad.php?id='.$banner['settings_banner_id'].'&data=wordpress&width='.$matches[0][0].'&height='.$matches[0][1].'&random='.rand(1, 5000).'" language="JavaScript"></script></div>';
			}
		}
	}
	return $content;
}
?>