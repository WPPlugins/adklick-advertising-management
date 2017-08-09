<?php 
add_action('wp_ajax_wp_adklick_pages_form_get_content', 'wp_adklick_pages_form_get_content');
function wp_adklick_pages_form_get_content() {
	check_ajax_referer('wp-adklick', 'wp_adklick_nonce');
	$id = uniqid("adklicks_pages_submit_");
	$selected = null;
	if(isset($_POST['wp_adklick_selected'])) {
		$selected = explode(',', urldecode((string)$_POST['wp_adklick_selected']));
	}
	echo '<div id="adklicks_pages_popup" style="padding: 10px; height: 382px;">';
		$popupPages = get_pages('numberposts=100');
		echo '<select id="adklicks_pages_popup_picker" class="multiselect" multiple="multiple" >';
			foreach($popupPages as $popupPage) {
				if($selected && in_array($popupPage->ID, $selected)) {
					echo '<option value="'.$popupPage->ID.'" selected="selected">'.$popupPage->post_title.'</option>';
				} else {
					echo '<option value="'.$popupPage->ID.'">'.$popupPage->post_title.'</option>';
				}
			}
		echo '</select>';
		echo '<input id="'.$id.'" type="image" src="'.WP_ADKLICK_URL.'/includes/images/check.png" style="float: right; margin: 2px 12px 0 0;" />';
	echo '</div>';
	echo '<script type="text/javascript">';
	echo 'jQuery(function(){';
		echo 'jQuery(".multiselect").multiselect({dividerLocation: 0.5});';
		
		echo 'jQuery("#'.$id.'").click(function() {';
			if(isset($_POST['wp_adklick_target'])) {
				echo 'var selectedItems = new Array();';
				echo 'var pagePicker = document.getElementById("adklicks_pages_popup_picker");';
				echo 'while (pagePicker.selectedIndex != -1) {';
					echo 'selectedItems.push(pagePicker.options[pagePicker.selectedIndex].value);';
					echo 'pagePicker.options[pagePicker.selectedIndex].selected = false;';
				echo '}';
				
				echo 'jQuery("#'.((string)$_POST['wp_adklick_target']).'").val(selectedItems.join(","));';
			}
			echo 'jQuery.colorbox.close();';
		echo '});';
	echo '});';
	echo '</script>';
	die();
}

add_action('wp_ajax_wp_adklick_posts_form_get_content', 'wp_adklick_posts_form_get_content');
function wp_adklick_posts_form_get_content() {
	check_ajax_referer('wp-adklick', 'wp_adklick_nonce');
	$id = uniqid("adklicks_pages_submit_");
	$selected = null;
	if(isset($_POST['wp_adklick_selected'])) {
		$selected = explode(',', urldecode((string)$_POST['wp_adklick_selected']));
	}
	echo '<div id="adklicks_pages_popup" style="padding: 10px; height: 382px;">';
		$popupPosts = get_posts('numberposts=100');
		echo '<select id="adklicks_pages_popup_picker" class="multiselect" multiple="multiple" >';
			foreach($popupPosts as $popupPost) {
				if($selected && in_array($popupPost->ID, $selected)) {
					echo '<option value="'.$popupPost->ID.'" selected="selected">'.$popupPost->post_title.'</option>';
				} else {
					echo '<option value="'.$popupPost->ID.'">'.$popupPost->post_title.'</option>';
				}
			}
		echo '</select>';
		echo '<input id="'.$id.'" type="image" src="'.WP_ADKLICK_URL.'/includes/images/check.png" style="float: right; margin: 2px 12px 0 0;" />';
	echo '</div>';
	echo '<script type="text/javascript">';
	echo 'jQuery(function(){';
		echo 'jQuery(".multiselect").multiselect({dividerLocation: 0.5});';
		
		echo 'jQuery("#'.$id.'").click(function() {';
			if(isset($_POST['wp_adklick_target'])) {
				echo 'var selectedItems = new Array();';
				echo 'var pagePicker = document.getElementById("adklicks_pages_popup_picker");';
				echo 'while (pagePicker.selectedIndex != -1) {';
					echo 'selectedItems.push(pagePicker.options[pagePicker.selectedIndex].value);';
					echo 'pagePicker.options[pagePicker.selectedIndex].selected = false;';
				echo '}';
				
				echo 'jQuery("#'.((string)$_POST['wp_adklick_target']).'").val(selectedItems.join(","));';
			}
			echo 'jQuery.colorbox.close();';
		echo '});';
	echo '});';
	echo '</script>';
	die();
}

add_action('wp_ajax_wp_adklick_category_form_get_content', 'wp_adklick_category_form_get_content');
function wp_adklick_category_form_get_content() {
	check_ajax_referer('wp-adklick', 'wp_adklick_nonce');
	$id = uniqid("adklicks_pages_submit_");
	$selected = null;
	if(isset($_POST['wp_adklick_selected'])) {
		$selected = explode(',', urldecode((string)$_POST['wp_adklick_selected']));
	}
	echo '<div id="adklicks_pages_popup" style="padding: 10px; height: 382px;">';
		$popupCategories = get_categories('number=100');
		echo '<select id="adklicks_pages_popup_picker" class="multiselect" multiple="multiple" >';
			foreach($popupCategories as $popupCategory) {
				if($selected && in_array($popupCategory->term_id, $selected)) {
					echo '<option value="'.$popupCategory->term_id.'" selected="selected">'.esc_html(substr($popupCategory->name, 0, 35)).'</option>';
				} else {
					echo '<option value="'.$popupCategory->term_id.'">'.esc_html(substr($popupCategory->name, 0, 35)).'</option>';
				}
			}
		echo '</select>';
		echo '<input id="'.$id.'" type="image" src="'.WP_ADKLICK_URL.'/includes/images/check.png" style="float: right; margin: 2px 12px 0 0;" />';
	echo '</div>';
	echo '<script type="text/javascript">';
	echo 'jQuery(function(){';
		echo 'jQuery(".multiselect").multiselect({dividerLocation: 0.5});';
		
		echo 'jQuery("#'.$id.'").click(function() {';
			if(isset($_POST['wp_adklick_target'])) {
				echo 'var selectedItems = new Array();';
				echo 'var pagePicker = document.getElementById("adklicks_pages_popup_picker");';
				echo 'while (pagePicker.selectedIndex != -1) {';
					echo 'selectedItems.push(pagePicker.options[pagePicker.selectedIndex].value);';
					echo 'pagePicker.options[pagePicker.selectedIndex].selected = false;';
				echo '}';
				
				echo 'jQuery("#'.((string)$_POST['wp_adklick_target']).'").val(selectedItems.join(","));';
			}
			echo 'jQuery.colorbox.close();';
		echo '});';
	echo '});';
	echo '</script>';
	die();
}
?>