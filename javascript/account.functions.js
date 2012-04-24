
jQuery(function() {
	newDialog("#passwordDialog");
	newDialog("#emailDialog");
	jQuery("#passwordBtn").click(function(event) {
		$("#passwordDialog").dialog('open');
	});
	jQuery("#emailBtn").click(function(event) {
		$("#emailDialog").dialog('open');
	});
});

/**
 * Initialize a new dialog box
 * @param componentID
 * 			: a HTML component ID
 */
function newDialog(componentID) {
	jQuery(componentID).dialog( {
		autoOpen : false,
		height : 200,
		width : 350,
		resizable : false,
		modal : true,
		buttons : {
			'Valider' : function() {
				jQuery(this).dialog('close');
			},
			'Annuler' : function() {
				jQuery(this).dialog('close');
			}
		},
		close : function() {
		}
	});
}
