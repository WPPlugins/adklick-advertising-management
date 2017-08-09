<?php
function wp_adklick_get_control($type = 'text', $returnHTML = false, $name = '', $id='', $value = '', $label = '', $info = '', $data = null, $class = '', $useParagraph = true, $dummy = '') {
	$control = array(
		'html' => '',
		'javascript' => ''
	);
	if($useParagraph) { $control['html'] .= '<p>'; }
	switch($type) {
		case 'hidden':
			if($value == '') { $value = 0; }
			if($class == '') { $class = 'input widefat'; }
			if($label != '') { $control['html'] .= '<label for="'.$id.'"  >'.$label.' <span id="label_'.$id.'">'.$value.'</span></label><br />'; }	
			$control['html'] .= '<input type="hidden" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
			break;
		case 'text':
			if($class == '') { $class = 'input widefat'; }
			if($label != '') { $control['html'] .= '<label for="'.$id.'">'.$label.'</label><br />'; }	
			$control['html'] .= '<input type="text" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
			break;
		case 'checkbox':
			if($class == '') { $class = 'input'; }
			$control['html'] .= '<input type="checkbox" id="'.$id.'" name="'.$name.'" value="1" class="'.$class.'" '.checked($value, 1, false).' />';
			if($label != '') { $control['html'] .= '&nbsp;<label for="'.$id.'">'.$label.'</label>'; }	
			break;
		case 'select':
			if($class == '') { $class = 'input widefat'; }
			if($label != '') { $control['html'] .= '<label for="'.$id.'">'.$label.'</label><br />'; }	
			$control['html'] .= '<select  id="'.$id.'" name="'.$name.'"  class="'.$class.'">';
			if($data) {
				foreach($data as $option) {
					$control['html'] .= '<option value='.(($option['value'] == '')?$option['text']:$option['value']).' '.selected($value, (($option['value'] == '')?$option['text']:$option['value']), false).'>'.$option['text'].'</option>';
				}
			}
			$control['html'] .= '</select>';
			break;
		case 'textarea':
			if($class == '') { $class = 'input widefat'; }
			if($label != '') { $control['html'] .= '<label for="'.$id.'">'.$label.'</label><br />'; }	
			$control['html'] .= '<textarea id="'.$id.'" name="'.$name.'" class="'.$class.'">'.$value.'</textarea>';
			break;
		case 'upload':
			if($class == '') { $class = 'input widefat'; }
			if($label != '') { $control['html'] .= '<label for="'.$id.'">'.$label.'</label><br />'; }	
			$control['html'] .= '<input type="text" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="'.$class.'" style="width: 74%;" />';
			$control['html'] .= '<input type="button" value="Upload Image" class="wp_adklick_uploader_button" id="upload_image_button" style="width: 25%;" />';
			break;
		case 'tz-checkbox':
			if($class == '') { $class = 'input betterCheckbox'; }
			if($label != '') { $control['html'] .= '<label for="'.$id.'">'.$label.'</label><br />'; }	
			$control['html'] .= '<input type="checkbox" id="'.$id.'" name="'.$name.'" class="'.$class.'" value="1" '.checked($value, 1, false).' />';
			$control['javascript'] .= 'jQuery("#'.$id.'").tzCheckbox({labels: ["ON", "OFF"]});';
			break;
		case 'ip-checkbox':
			if($class == '') { $class = 'input iphoneCheckbox'; }
			if($label != '') { $control['html'] .= '<label for="'.$id.'">'.$label.'</label><br />'; }	
			$control['html'] .= '<input type="checkbox" id="'.$id.'" name="'.$name.'" class="'.$class.'" value="1" '.checked($value, 1, false).' />';	
			$control['javascript'] .= 'jQuery("#'.$id.'").iphoneStyle({checkedLabel: "Hide Ads", uncheckedLabel: "Show Ads", resizeContainer: false, resizeHandle: false});';
			break;
		case 'popup':
			if($class == '') { $class = 'input narrowfat'; }
			if($label != '') { $control['html'] .= '<label for="'.$id.'">'.$label.'</label><br />'; }	
			$control['html'] .= '<input type="text" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="'.$class.'" />';
			$control['html'] .= '<a id="'.$id.'_button" href="#"><img style="width: 16px; height: 16px; margin: 0 0 -3px 5px;" src="'.WP_ADKLICK_URL.'/includes/images/pointer.png" /></a>';
			if($data) {
				switch($data['type']) {
					case 'pages':						
						$control['javascript'] .= 'jQuery("#'.$id.'_button").click(function() {';
							$control['javascript'] .= 'jQuery.colorbox({';
								$control['javascript'] .= 'overlayClose: false,';
								$control['javascript'] .= 'scrolling: false,';
								$control['javascript'] .= 'transition: "fade",';
								$control['javascript'] .= 'innerWidth: "577px",';
								$control['javascript'] .= 'innerHeight: "402px",';
								$control['javascript'] .= 'html: "<div style=\'width: 577px; height: 402px;\'></div>",';
								$control['javascript'] .= 'cbox_load : function() {';
									$control['javascript'] .= 'jQuery.post(';
										$control['javascript'] .= 'jQuery("#wp_adklick_admin_ajax").val(), {';
											$control['javascript'] .= '"action": "wp_adklick_pages_form_get_content",';
											$control['javascript'] .= '"wp_adklick_nonce": jQuery("#wp_adklick_nonce").val(),';
											$control['javascript'] .= '"wp_adklick_selected": jQuery("#'.$id.'").val(),';
											$control['javascript'] .= '"wp_adklick_target": "'.$id.'",';
										$control['javascript'] .= '}, function(response) { jQuery("#cboxLoadedContent").html(response); }';		
									$control['javascript'] .= ');';
								$control['javascript'] .= '}';
							$control['javascript'] .= '});';
							$control['javascript'] .= 'return false;';
						$control['javascript'] .= '});';
						break;
					case 'posts':
						$control['javascript'] .= 'jQuery("#'.$id.'_button").click(function() {';
							$control['javascript'] .= 'jQuery.colorbox({';
								$control['javascript'] .= 'overlayClose: false,';
								$control['javascript'] .= 'scrolling: false,';
								$control['javascript'] .= 'transition: "fade",';
								$control['javascript'] .= 'innerWidth: "577px",';
								$control['javascript'] .= 'innerHeight: "402px",';
								$control['javascript'] .= 'html: "<div style=\'width: 577px; height: 402px;\'></div>",';
								$control['javascript'] .= 'cbox_load : function() {';
									$control['javascript'] .= 'jQuery.post(';
										$control['javascript'] .= 'jQuery("#wp_adklick_admin_ajax").val(), {';
											$control['javascript'] .= '"action": "wp_adklick_posts_form_get_content",';
											$control['javascript'] .= '"wp_adklick_nonce": jQuery("#wp_adklick_nonce").val(),';
											$control['javascript'] .= '"wp_adklick_selected": jQuery("#'.$id.'").val(),';
											$control['javascript'] .= '"wp_adklick_target": "'.$id.'",';
										$control['javascript'] .= '}, function(response) { jQuery("#cboxLoadedContent").html(response); }';		
									$control['javascript'] .= ');';
								$control['javascript'] .= '}';
							$control['javascript'] .= '});';
							$control['javascript'] .= 'return false;';
						$control['javascript'] .= '});';
						break;
					case 'categories':	
						$control['javascript'] .= 'jQuery("#'.$id.'_button").click(function() {';
							$control['javascript'] .= 'jQuery.colorbox({';
								$control['javascript'] .= 'overlayClose: false,';
								$control['javascript'] .= 'scrolling: false,';
								$control['javascript'] .= 'transition: "fade",';
								$control['javascript'] .= 'innerWidth: "577px",';
								$control['javascript'] .= 'innerHeight: "402px",';
								$control['javascript'] .= 'html: "<div style=\'width: 577px; height: 402px;\'></div>",';
								$control['javascript'] .= 'cbox_load : function() {';
									$control['javascript'] .= 'jQuery.post(';
										$control['javascript'] .= 'jQuery("#wp_adklick_admin_ajax").val(), {';
											$control['javascript'] .= '"action": "wp_adklick_category_form_get_content",';
											$control['javascript'] .= '"wp_adklick_nonce": jQuery("#wp_adklick_nonce").val(),';
											$control['javascript'] .= '"wp_adklick_selected": jQuery("#'.$id.'").val(),';
											$control['javascript'] .= '"wp_adklick_target": "'.$id.'",';
										$control['javascript'] .= '}, function(response) { jQuery("#cboxLoadedContent").html(response); }';		
									$control['javascript'] .= ');';
								$control['javascript'] .= '}';
							$control['javascript'] .= '});';
							$control['javascript'] .= 'return false;';
						$control['javascript'] .= '});';
						break;
				}
			}
			break;
	}
	if($info != '') {
		$control['html'] .= '<small>'.$info.'</small>';
		$control['html'] .= '<div class="clear"></div>';
	}
	if($useParagraph) { $control['html'] .= '</p>'; }
	
	if($returnHTML) {
		return $control['html'];
	} else {
		return $control;
	}
}

function wp_adklick_get_vtabs($id, $args) {
	$control = array(
		'html' => '',
		'javascript' => ''
	);
	$control['html'] .= '<div id="'.$id.'">';
		$control['html'] .= '<div>';
			$control['html'] .= '<ul>';
			foreach($args as $tab) {
				$control['html'] .= '<li><a href="#'.str_replace(array(' ', '-'), '_', strtolower($tab['title'])).'">'.$tab['title'].'</a></li>';
			}
			$control['html'] .= '</ul>';
		$control['html'] .= '</div>';
		$control['html'] .= '<div>';
			foreach($args as $tab) {
				$control['html'] .= '<div id="#'.str_replace(array(' ', '-'), '_', strtolower($tab['title'])).'">'.$tab['content'].'</div>';
			}
		$control['html'] .= '</div>';
	$control['html'] .= '</div>';
	$control['javascript'] .= 'jQuery("#'.$id.'").jVertTabs({equalHeights: false});';
	return $control;
}

function wp_adklick_get_script_tag($content) {
	$script = '';
	if(is_array($content)) {
		foreach($content as $control) {
			$script .= $control['javascript'];
		}
	} else {
		$script = $content;
	}
	$output = '<script type="text/javascript">';
		$output .= 'jQuery(document).ready(function(){'.$script.'});';
	$output .= '</script>';
	return $output;
}


function wp_adklick_get_table($args) {
	$output = '<table'.(($args['id'] != '')?' id="'.$args['id'].'"':'').(($args['class'] != '')?' class="'.$args['class'].'"':'').(($args['style'] != '')?' style="'.$args['style'].'"':'').'>';
		foreach($args['rows'] as $row) {
		$output .= '<tr'.(($row['id'] != '')?' id="'.$row['id'].'"':'').(($row['class'] != '')?' class="'.$row['class'].'"':'').(($row['style'] != '')?' style="'.$row['style'].'"':'').'>';
		foreach($row['cells'] as $cell) {
			if($cell['type'] == '') { $cell['type'] = 'td'; }
			$output .= '<'.$cell['type'].(($cell['colspan'] != '')?' colspan="'.$cell['colspan'].'"':'').(($cell['id'] != '')?' id="'.$cell['id'].'"':'').(($cell['class'] != '')?' class="'.$cell['class'].'"':'').(($cell['style'] != '')?' style="'.$cell['style'].'"':'').'>';
				$output .= $cell['content'];
			$output .= '</'.$cell['type'].'>';
		}
		$output .= '</tr>';
	}
	$output .= '</table>';
	return $output;
}
?>