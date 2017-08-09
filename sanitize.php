<?php
function wp_adklick_sanitize_array($masterArray, $parameters) {
	if(!is_array($masterArray)) {
		$masterArray = array();
	}
	if(isset($masterArray) && isset($parameters) && is_array($parameters)) {
		foreach($parameters as $parameter) {
			if(!isset($masterArray[$parameter])) {
				$masterArray[$parameter] = '';
			}
		}
	}
	return $masterArray;
}
?>