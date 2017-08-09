alert("test");
wp_adklick_click_handler(
	'wp-adklick-intextad-rules_categories_exceptions_button',
	'AdKlick : Category Exceptions',
	jQuery("body").width() * 0.8,
	jQuery("body").height() * 0.8,
	function() {
		jQuery('.wp_adklick_adwidgets_status').parent().css({'display': 'inline-block', 'margin': '5px 0 0'}).prependTo('.ui-dialog-buttonpane');
	},
	function() {
		var identifier = jQuery(".wp_adklick_adwidgets_identifier").val();
		var adwidgetLink = jQuery("<a></a>");
		adwidgetLink.attr("id", "wp_adklick_adwidgets_"+identifier);
		adwidgetLink.attr("href", "javascript:;");
		adwidgetLink.attr("onClick", "wp_adklick_adwidgets_click_handler(\'"+identifier+"\', \'"+jQuery("#wp_adklick_adwidgets_"+identifier+"_title").val()+"\')");
		adwidgetLink.html("Ad Widget : "+jQuery("#wp_adklick_adwidgets_"+identifier+"_title").val());
		var deleteButton = jQuery("<span></span>");
		deleteButton.attr("class", "dashicons dashicons-dismiss wp_adklick_delete_icon");
		deleteButton.attr("onClick", "wp_adklick_adwidgets_remove(\'"+identifier+"\')");
		jQuery("#wp_adklick_adwidgets_new").parent().before(jQuery("<p></p>").append(adwidgetLink, deleteButton));
		wp_adklick_adwidgets_update(identifier);
	},
	function() { }
);
	
function wp_adklick_click_handler(target, title, width, height, openAction, UpdateAction, closeAction) {
	jQuery('#'+target).click(function() {
		jQuery('<div id="'+target+'_dialog"></div>').html('<div class="wp_adklick_ajaxloader"></div>').dialog({
			'modal': true,
			'resizable': false,
			'width': width,
			'maxWidth': width,
			'maxHeight': height,
			'title': title,
			position: { my: 'center', at: 'center', of: window },
			open: function (event, ui) {
				jQuery('.ui-dialog').css({'z-index': 999999, 'max-width': '90%'});
				jQuery('.ui-widget-overlay').css({'z-index': 999998, 'opacity': 0.8, 'background': '#000000'});
				jQuery('.ui-dialog-buttonpane button:contains("Update")').button('disable');
				
				jQuery.post(
					jQuery('#wp_adklick_admin_ajax').val(), {
						'action': target+'_form_get_content',
						'wp_adklick_nonce': jQuery('#wp_adklick_nonce').val()
					}, function(response) {
						jQuery('.wp_adklick_ajaxloader').hide();
						jQuery('.ui-dialog-content').html(response);
						jQuery('.ui-accordion .ui-accordion-content').css('max-height', (jQuery("body").height() * 0.45));
						jQuery('.ui-dialog-buttonpane button:contains("Update")').button('enable');
						openAction();
						jQuery('.ui-dialog').css({'position': 'fixed'});
						jQuery('#'+target+'_dialog').delay(500).dialog({position: { my: 'center', at: 'center', of: window }});
						
					}			
				);
			},
			buttons: {
				'Update': function() {
					UpdateAction();
					jQuery(this).dialog('close');
				},
				Cancel: function() {
					jQuery(this).dialog('close');
				}
			},
			close: function() {
				closeAction();
				jQuery(this).dialog('destroy');
			}
		})
	});
}