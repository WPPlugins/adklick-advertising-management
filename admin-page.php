<?php
add_action('admin_menu', 'wp_adklick_add_main_menu');
function wp_adklick_add_main_menu() {	
	$subHandle = add_menu_page('AdKlick', 'AdKlick', 'manage_options', 'wp-adklick', 'wp_adklick_admin_page', WP_ADKLICK_URL.'/includes/images/adklick_16_ico.png');	
	add_action('admin_print_styles-'.$subHandle, 'wp_adklick_admin_styles');
}

function wp_adklick_admin_page() { ?>
    <div class="wrap wp-adklick-styles">
		<div id="icon-plugins" class="icon32" style="background: url(<?php echo WP_ADKLICK_URL; ?>/includes/images/adklick_32_ico.png) no-repeat scroll center center;"></div>
		<h2>AdKlick Setup</h2>
		<form method="post" action="options.php" name="wp_auto_commenter_form">
			<?php settings_fields('wp_adklick_options'); ?>
			<div id="poststuff" class="metabox-holder has-right-sidebar wp-insert-plugin">
				<div id="side-info-column" class="inner-sidebar">
					<p class="submit">
						<input type="submit" name="Submit" class="button-primary submit" value="<?php esc_attr_e('Save Changes') ?>" style="width: 100%; height: auto; padding: 10px; font-size: 1.5em;" />
					</p>
				</div>
				<div id="post-body" class="has-sidebar">				
					<div id="post-body-content" class="has-sidebar-content">
						<?php do_settings_sections('wp-adklick'); ?>
					</div>
				</div>
				<br class="clear"/>			
			</div>
			<?php
			wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
			wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
			?>
			<script type="text/javascript">
			jQuery(document).ready( function($) {
				jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				postboxes.add_postbox_toggles('<?php echo $sectionName; ?>');
			});
			</script>
		</form>
    </div>
<?php }

function wp_adklick_admin_styles() {	
	wp_enqueue_style('wp-adklick-styles', WP_ADKLICK_URL.'/includes/css/style.css', false);
	wp_enqueue_style('jquery-ui-styles', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/smoothness/jquery-ui.css');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('common');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('better-checkboxes', WP_ADKLICK_URL.'/includes/js/jquery.tzCheckbox.js', array('jquery'));
	wp_enqueue_script('jquery-vertical-tabs', WP_ADKLICK_URL.'/includes/js/jquery-jvert-tabs-1.1.4.js', array('jquery'));	
	wp_enqueue_script('iphone-checkboxes', WP_ADKLICK_URL.'/includes/js/iphone-style-checkboxes.js', array('jquery'));	
	wp_enqueue_script('colorbox', WP_ADKLICK_URL.'/includes/js/jquery.colorbox-min.js', array('jquery'));
	wp_enqueue_script('multiselect', WP_ADKLICK_URL.'/includes/js/ui.multiselect.js', array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-draggable'));
	wp_enqueue_script('', WP_ADKLICK_URL.'/includes/images/jscolor.js', array('jquery'));
}

add_action('admin_init', 'wp_adklick_admin_init');
function wp_adklick_admin_init() {	
	register_setting('wp_adklick_options', 'wp_adklick_options');
    add_settings_section('wp_adklick', '', 'wp_adklick_section', 'wp-adklick');
	$options = get_option('wp_adklick_options');
	add_meta_box('wp-adklick-intextad', 'InTextAd', 'wp_adklick_content_intext', 'wp-adklick', 'advanced', 'high',array('ad' => 'intextad', 'name' => 'wp_adklick_options', 'data' => $options));
	add_meta_box('wp-adklick-popdown', 'PopDown', 'wp_adklick_content_popunder', 'wp-adklick', 'advanced', 'high',array('ad' => 'popdown', 'name' => 'wp_adklick_options', 'data' => $options));
	add_meta_box('wp-adklick-layer', 'Layer', 'wp_adklick_content_layer', 'wp-adklick', 'advanced', 'high',array('ad' => 'layer', 'name' => 'wp_adklick_options', 'data' => $options));
	add_meta_box('wp-adklick-banner', 'Banner', 'wp_adklick_content_banner', 'wp-adklick', 'advanced', 'high',array('ad' => 'banner', 'name' => 'wp_adklick_options', 'data' => $options));
}

function wp_adklick_section() {
	do_meta_boxes('wp-adklick', 'advanced', null);
}


function wp_adklick_content_intext($post, $args){
	$ad = $args['args']['ad'];
	$data = $args['args']['data'];
	if(!$data) { $data = array(); }
	$id = $args['id'];
	$name = $args['args']['name'].'['.$ad.']';
	
	if(!isset($data[$ad])) { $data[$ad] = array(); }
	$data = wp_adklick_sanitize_array($data[$ad], array('status','rules_admin_status','rules_user_status', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions', 'settings_intext_id', 'settings_intext_select', 'settings_intext_color'));
	
	$controls = array();
	$controls['status'] = wp_adklick_get_control('tz-checkbox', false, $name.'[status]', $id.'-status', $data['status']);
	
	$controls['rules_admin_status'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_admin_status]', $id.'-rules_admin_status', $data['rules_admin_status']);
	$controls['rules_user_status'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_user_status]', $id.'-rules_user_status', $data['rules_user_status']);
	$controls['rules_exclude_home'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_home]', $id.'-rules_exclude_home', $data['rules_exclude_home'], '', '', '', '', '');
	$controls['rules_exclude_archives'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_archives]', $id.'-rules_exclude_archives', $data['rules_exclude_archives'], '', '', null, '', false);
	$controls['rules_exclude_categories'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_categories]', $id.'-rules_exclude_categories', $data['rules_exclude_categories'], '', '', null, '', false);
	$controls['rules_categories_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_categories_exceptions]', $id.'-rules_categories_exceptions', $data['rules_categories_exceptions'], '', '', array('type' => 'categories'), '', false);
	$controls['rules_exclude_search'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_search]', $id.'-rules_exclude_search', $data['rules_exclude_search'], '', '', null, '', false);
	$controls['rules_exclude_page'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_page]', $id.'-rules_exclude_page', $data['rules_exclude_page'], '', '', null, '', false);
	$controls['rules_page_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_page_exceptions]', $id.'-rules_page_exceptions', $data['rules_page_exceptions'], '', '', array('type' => 'pages'), '', false);
	$controls['rules_exclude_post'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_post]', $id.'-rules_exclude_post', $data['rules_exclude_post'], '', '', null, '', false);
	$controls['rules_post_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_post_exceptions]', $id.'-rules_post_exceptions', $data['rules_post_exceptions'], '', '', array('type' => 'posts'), '', false);
	
		
	$controls['settings_intext_id'] = wp_adklick_get_control('text', false, $name.'[settings_intext_id]', $id.'-settings_intext_id', $data['settings_intext_id'], __('ADKLICKPID:'));
	$max = array(
		array('value' => '1', 'text' => '1'),
		array('value' => '2', 'text' => '2'),
		array('value' => '3', 'text' => '3'),
		array('value' => '4', 'text' => '4'),
		array('value' => '5', 'text' => '5'),
		array('value' => '6', 'text' => '6'),
		array('value' => '7', 'text' => '7'),
		array('value' => '8', 'text' => '8'),
		array('value' => '9', 'text' => '9'),
		array('value' => '10', 'text' => '10'),
		array('value' => '11', 'text' => '12'),
		array('value' => '13', 'text' => '13'),
		array('value' => '14', 'text' => '14'),
		array('value' => '15', 'text' => '15'),
		array('value' => '16', 'text' => '16'),
	);
	$controls['settings_intext_select'] = wp_adklick_get_control('select', false, $name.'[settings_intext_select]', $id.'-settings_intext_select', $data['settings_intext_select'], __('Max Underline:'),' ',$max);
	$controls['settings_intext_color'] = wp_adklick_get_control('text', false, $name.'[settings_intext_color]', $id.'-settings_intext_color', $data['settings_intext_color'], __('Color:'),' ',' ','color');
	
	echo $controls['status']['html'];	
	$tabData = array(
		array(
			'title' => __('Settings'),
			'content' => $controls['settings_intext_id']['html'].$controls['settings_intext_select']['html'].$controls['settings_intext_color']['html']
		),
		array(
			'title' => __('Rules'),
			'content' => wp_adklick_rules_content($controls)
		)
	);
	$controls['vtab'] = wp_adklick_get_vtabs('vtab_'.$ad, $tabData);
	echo $controls['vtab']['html'];
	echo wp_adklick_get_script_tag($controls['vtab']['javascript'].$controls['status']['javascript'].$controls['rules_admin_status']['javascript'].$controls['rules_user_status']['javascript'].$controls['rules_exclude_home']['javascript'].$controls['rules_exclude_archives']['javascript'].$controls['rules_exclude_categories']['javascript'].$controls['exclude_posts']['javascript'].$controls['rules_exclude_search']['javascript'].$controls['rules_exclude_page']['javascript'].$controls['rules_exclude_post']['javascript'].$controls['rules_categories_exceptions']['javascript'].$controls['rules_page_exceptions']['javascript'].$controls['rules_post_exceptions']['javascript']);

}
function wp_adklick_content_popunder($post, $args){
	$ad = $args['args']['ad'];
	$data = $args['args']['data'];
	if(!$data) { $data = array(); }
	$id = $args['id'];
	$name = $args['args']['name'].'['.$ad.']';
	
	if(!isset($data[$ad])) { $data[$ad] = array(); }
	$data = wp_adklick_sanitize_array($data[$ad], array('status', 'settings_popunder_id','rules_admin_status','rules_user_status','rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions'));
	
	$controls = array();
	$controls['status'] = wp_adklick_get_control('tz-checkbox', false, $name.'[status]', $id.'-status', $data['status']);	
				
	$controls['settings_popunder_id'] = wp_adklick_get_control('text', false, $name.'[settings_popunder_id]', $id.'-settings_popunder_id', $data['settings_popunder_id'], __('ADKLICKPID:'));
	
	$controls['rules_admin_status'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_admin_status]', $id.'-rules_admin_status', $data['rules_admin_status']);
	$controls['rules_user_status'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_user_status]', $id.'-rules_user_status', $data['rules_user_status']);
	$controls['rules_exclude_home'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_home]', $id.'-rules_exclude_home', $data['rules_exclude_home'], '', '', '', '', '');
	$controls['rules_exclude_archives'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_archives]', $id.'-rules_exclude_archives', $data['rules_exclude_archives'], '', '', null, '', false);
	$controls['rules_exclude_categories'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_categories]', $id.'-rules_exclude_categories', $data['rules_exclude_categories'], '', '', null, '', false);
	$controls['rules_categories_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_categories_exceptions]', $id.'-rules_categories_exceptions', $data['rules_categories_exceptions'], '', '', array('type' => 'categories'), '', false);
	$controls['rules_exclude_search'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_search]', $id.'-rules_exclude_search', $data['rules_exclude_search'], '', '', null, '', false);
	$controls['rules_exclude_page'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_page]', $id.'-rules_exclude_page', $data['rules_exclude_page'], '', '', null, '', false);
	$controls['rules_page_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_page_exceptions]', $id.'-rules_page_exceptions', $data['rules_page_exceptions'], '', '', array('type' => 'pages'), '', false);
	$controls['rules_exclude_post'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_post]', $id.'-rules_exclude_post', $data['rules_exclude_post'], '', '', null, '', false);
	$controls['rules_post_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_post_exceptions]', $id.'-rules_post_exceptions', $data['rules_post_exceptions'], '', '', array('type' => 'posts'), '', false);
	
	echo $controls['status']['html'];	
	$tabData = array(
		array(
			'title' => __('Settings'),
			'content' => $controls['settings_popunder_id']['html']
		),
		array(
			'title' => __('Rules'),
			'content' => wp_adklick_rules_content($controls)
		)
	);
	$controls['vtab'] = wp_adklick_get_vtabs('vtab_'.$ad, $tabData);
	echo $controls['vtab']['html'];
	echo wp_adklick_get_script_tag($controls['vtab']['javascript'].$controls['status']['javascript'].$controls['rules_admin_status']['javascript'].$controls['rules_user_status']['javascript'].$controls['rules_exclude_home']['javascript'].$controls['rules_exclude_archives']['javascript'].$controls['rules_exclude_categories']['javascript'].$controls['exclude_posts']['javascript'].$controls['rules_exclude_search']['javascript'].$controls['rules_exclude_page']['javascript'].$controls['rules_exclude_post']['javascript'].$controls['rules_categories_exceptions']['javascript'].$controls['rules_page_exceptions']['javascript'].$controls['rules_post_exceptions']['javascript']);


	echo '<input type="hidden" id="wp_adklick_admin_ajax" name="wp_adklick_admin_ajax" value="'.admin_url('admin-ajax.php').'" />';
	echo '<input type="hidden" id="wp_adklick_nonce" name="wp_adklick_nonce" value="'.wp_create_nonce('wp-adklick').'" />';
}
function wp_adklick_content_layer($post, $args){
	$ad = $args['args']['ad'];
	$data = $args['args']['data'];
	if(!$data) { $data = array(); }
	$id = $args['id'];
	$name = $args['args']['name'].'['.$ad.']';
	
	if(!isset($data[$ad])) { $data[$ad] = array(); }
	$data = wp_adklick_sanitize_array($data[$ad], array('status', 'settings_layer_id','rules_admin_status','rules_user_status', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions'));
	
	$controls = array();
	$controls['status'] = wp_adklick_get_control('tz-checkbox', false, $name.'[status]', $id.'-status', $data['status']);	
	
	$controls['settings_layer_id'] = wp_adklick_get_control('text', false, $name.'[settings_layer_id]', $id.'-settings_layer_id', $data['settings_layer_id'], __('ADKLICKPID:'));
	
	$controls['rules_admin_status'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_admin_status]', $id.'-rules_admin_status', $data['rules_admin_status']);
	$controls['rules_user_status'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_user_status]', $id.'-rules_user_status', $data['rules_user_status']);
	$controls['rules_exclude_home'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_home]', $id.'-rules_exclude_home', $data['rules_exclude_home'], '', '', '', '', '');
	$controls['rules_exclude_archives'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_archives]', $id.'-rules_exclude_archives', $data['rules_exclude_archives'], '', '', null, '', false);
	$controls['rules_exclude_categories'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_categories]', $id.'-rules_exclude_categories', $data['rules_exclude_categories'], '', '', null, '', false);
	$controls['rules_categories_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_categories_exceptions]', $id.'-rules_categories_exceptions', $data['rules_categories_exceptions'], '', '', array('type' => 'categories'), '', false);
	$controls['rules_exclude_search'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_search]', $id.'-rules_exclude_search', $data['rules_exclude_search'], '', '', null, '', false);
	$controls['rules_exclude_page'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_page]', $id.'-rules_exclude_page', $data['rules_exclude_page'], '', '', null, '', false);
	$controls['rules_page_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_page_exceptions]', $id.'-rules_page_exceptions', $data['rules_page_exceptions'], '', '', array('type' => 'pages'), '', false);
	$controls['rules_exclude_post'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_post]', $id.'-rules_exclude_post', $data['rules_exclude_post'], '', '', null, '', false);
	$controls['rules_post_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_post_exceptions]', $id.'-rules_post_exceptions', $data['rules_post_exceptions'], '', '', array('type' => 'posts'), '', false);
	
	
	echo $controls['status']['html'];	
	$tabData = array(
		array(
			'title' => __('Settings'),
			'content' => $controls['settings_layer_id']['html']
		),
		array(
			'title' => __('Rules'),
			'content' => wp_adklick_rules_content($controls)
		)
	);
	$controls['vtab'] = wp_adklick_get_vtabs('vtab_'.$ad, $tabData);
	echo $controls['vtab']['html'];
	echo wp_adklick_get_script_tag($controls['vtab']['javascript'].$controls['status']['javascript'].$controls['rules_admin_status']['javascript'].$controls['rules_user_status']['javascript'].$controls['rules_exclude_home']['javascript'].$controls['rules_exclude_archives']['javascript'].$controls['rules_exclude_categories']['javascript'].$controls['exclude_posts']['javascript'].$controls['rules_exclude_search']['javascript'].$controls['rules_exclude_page']['javascript'].$controls['rules_exclude_post']['javascript'].$controls['rules_categories_exceptions']['javascript'].$controls['rules_page_exceptions']['javascript'].$controls['rules_post_exceptions']['javascript']);
}

function wp_adklick_content_banner($post, $args){
	$ad = $args['args']['ad'];
	$data = $args['args']['data'];
	if(!$data) { $data = array(); }
	$id = $args['id'];
	$name = $args['args']['name'].'['.$ad.']';
	
	if(!isset($data[$ad])) { $data[$ad] = array(); }
	$data = wp_adklick_sanitize_array($data[$ad], array('status', 'settings_banner_id', 'settings_banner_select','rules_admin_status','rules_user_status', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions'));
	
	$controls = array();
	$controls['status'] = wp_adklick_get_control('tz-checkbox', false, $name.'[status]', $id.'-status', $data['status']);	
	
	$controls['settings_banner_id'] = wp_adklick_get_control('text', false, $name.'[settings_banner_id]', $id.'-settings_banner_id', $data['settings_banner_id'], __('ADKLICKPID:'));
	$pick = array(
		array('value' => '468x60', 'text' => '468x60 banner'),
		array('value' => '728x90', 'text' => '728x90 banner'),
		array('value' => '160x600', 'text' => '160x600 banner'),
		array('value' => '300x250', 'text' => '300x250 banner'),
	);
	$controls['settings_banner_select'] = wp_adklick_get_control('select', false, $name.'[settings_banner_select]', $id.'-settings_banner_select', $data['settings_banner_select'], __('Banner Format:'),' ',$pick);
	
	$location = array(
		array('value' => 'above', 'text' => 'Above Content'),
		array('value' => 'below', 'text' => 'Below Content')
	);
	$controls['settings_banner_location'] = wp_adklick_get_control('select', false, $name.'[settings_banner_location]', $id.'-settings_banner_location', $data['settings_banner_location'], __('Banner Location:'),' ',$location);
	
	$controls['rules_admin_status'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_admin_status]', $id.'-rules_admin_status', $data['rules_admin_status']);
	$controls['rules_user_status'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_user_status]', $id.'-rules_user_status', $data['rules_user_status']);	
	$controls['rules_exclude_home'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_home]', $id.'-rules_exclude_home', $data['rules_exclude_home'], '', '', '', '', '');
	$controls['rules_exclude_archives'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_archives]', $id.'-rules_exclude_archives', $data['rules_exclude_archives'], '', '', null, '', false);
	$controls['rules_exclude_categories'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_categories]', $id.'-rules_exclude_categories', $data['rules_exclude_categories'], '', '', null, '', false);
	$controls['rules_categories_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_categories_exceptions]', $id.'-rules_categories_exceptions', $data['rules_categories_exceptions'], '', '', array('type' => 'categories'), '', false);
	$controls['rules_exclude_search'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_search]', $id.'-rules_exclude_search', $data['rules_exclude_search'], '', '', null, '', false);
	$controls['rules_exclude_page'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_page]', $id.'-rules_exclude_page', $data['rules_exclude_page'], '', '', null, '', false);
	$controls['rules_page_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_page_exceptions]', $id.'-rules_page_exceptions', $data['rules_page_exceptions'], '', '', array('type' => 'pages'), '', false);
	$controls['rules_exclude_post'] = wp_adklick_get_control('ip-checkbox', false, $name.'[rules_exclude_post]', $id.'-rules_exclude_post', $data['rules_exclude_post'], '', '', null, '', false);
	$controls['rules_post_exceptions'] = wp_adklick_get_control('popup', false, $name.'[rules_post_exceptions]', $id.'-rules_post_exceptions', $data['rules_post_exceptions'], '', '', array('type' => 'posts'), '', false);
	
	echo $controls['status']['html'];	
	$tabData = array(
		array(
			'title' => __('Settings'),
			'content' => $controls['settings_banner_id']['html'].$controls['settings_banner_select']['html'].$controls['settings_banner_location']['html']
		),
		array(
			'title' => __('Rules'),
			'content' => wp_adklick_rules_content($controls)
		)
	);
	$controls['vtab'] = wp_adklick_get_vtabs('vtab_'.$ad, $tabData);
	echo $controls['vtab']['html'];
	echo wp_adklick_get_script_tag($controls['vtab']['javascript'].$controls['status']['javascript'].$controls['rules_admin_status']['javascript'].$controls['rules_user_status']['javascript'].$controls['rules_exclude_home']['javascript'].$controls['rules_exclude_archives']['javascript'].$controls['rules_exclude_categories']['javascript'].$controls['exclude_posts']['javascript'].$controls['rules_exclude_search']['javascript'].$controls['rules_exclude_page']['javascript'].$controls['rules_exclude_post']['javascript'].$controls['rules_categories_exceptions']['javascript'].$controls['rules_page_exceptions']['javascript'].$controls['rules_post_exceptions']['javascript']);
}

function wp_adklick_rules_content($controls) {
	$rulesTable = array(
		'class' => 'rules',
		'rows' => array()
	);
	array_push(
		$rulesTable['rows'],
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Login status')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Non Admin Users'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_admin_status']['html'])
			)
		),
		array(
			'cells' => array(
				array('content' => 'Visitors<br><small>(Non Logged-In Users)</small>'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_user_status']['html'])
			)
		)		
	);
	array_push(
		$rulesTable['rows'],
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Home')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_home']['html'])
			)
		)		
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Archives')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_archives']['html'])
			)
		)		
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Categories')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_categories']['html'])
			)
		),		
		array(
			'cells' => array(
				array('content' => 'Exceptions'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_categories_exceptions']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Search Results')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_search']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Single Page')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_page']['html'])
			)
		),
		array(
			'cells' => array(
				array('content' => 'Exceptions'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_page_exceptions']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Single Blog Post')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_post']['html'])
			)
		),
		array(
			'cells' => array(
				array('content' => 'Exceptions'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_post_exceptions']['html'])
			)
		)
	);
	
	return wp_adklick_get_table($rulesTable);
}

?>