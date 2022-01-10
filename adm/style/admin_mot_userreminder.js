/**
*
* package User Reminder v1.4.0
* copyright (c) 2019 - 2021 Mike-on-Tour
* license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

	/*
	* Check the 'Remind sleeper' setting and hide or show the according settings
	*/
	$("input[name='mot_ur_remind_sleeper']").click(function() {
		if ($(this).val() == 1) {
			$("#mot_ur_sleeper_remind_settings").show();
		} else {
			$("#mot_ur_sleeper_remind_settings").hide();
		}
	});

	if ($("input[name='mot_ur_remind_sleeper']:checked").val() == 1) {
		$("#mot_ur_sleeper_remind_settings").show();
	}

	/*
	* Check the 'Autodelete sleeper' setting and hide or show the according setting
	*/
	$("input[name='mot_ur_sleeper_autodelete']").click(function() {
		if ($(this).val() == 1) {
			$("#mot_ur_sleeper_delete_settings").show();
		} else {
			$("#mot_ur_sleeper_delete_settings").hide();
		}
	});

	if ($("input[name='mot_ur_sleeper_autodelete']:checked").val() == 1) {
		$("#mot_ur_sleeper_delete_settings").show();
	}

	/*
	* Check whether input into the BCC or CC field is formally a valid e-mail address and empty the field if it is not
	*/
	$("#mot_ur_email_bcc, #mot_ur_email_cc").blur(function() {
		// Define the search patterns
		var emailMatch = /^([A-Za-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
		// Get the element value
		var elementValue = $(this).val();
		if (elementValue != '') {
			var result = elementValue.match(emailMatch);
			if (result == null) {
				$(this).val('');
			}
		}
	});

})(jQuery); // Avoid conflicts with other libraries
