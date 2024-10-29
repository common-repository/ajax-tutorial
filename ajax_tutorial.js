// Creating the JS Object
var AJAX_Tutorial = {
	get: function(post_id) {
		// action is what hook is being called "wp_ajax_" + action
		jQuery.post(ajaxurl, { action: 'ajaxtutorial_get', post_id: post_id }, function(response) {
			// check repsonse
			if (response.status == 'OK') {
				// debug data, you should see all post data
				console.log(response.data);
				//alert('POST title: ' + response.data.post_title);
			} else {
				// something didn't go well
				console.log(response.status);
			}
		}, 'json');		
	},
	save: function(post_id) {
		// action is what hook is being called "wp_ajax_" + action
		jQuery.post(ajaxurl, { action: 'ajaxtutorial_save', post_id: post_id }, function(response) {
			// check repsonse
			if (response.status == 'SAVED') {
				// debug data, you should see all post data
				console.log(response.data);
			} else {
				// something didn't go well
				console.log(response.status);
			}
		}, 'json');		
	},
	init: function() {
		// add triggers to the buttons
		jQuery('button.AJAX_Tutorial_Get').click(function() {
			AJAX_Tutorial.get(jQuery(this).attr('rel'));
		});
		jQuery('button.AJAX_Tutorial_Save').click(function() {
			AJAX_Tutorial.save(jQuery(this).attr('rel'));
		});
	}
}
// Load script when document is ready
jQuery(document).ready(function(){AJAX_Tutorial.init()});