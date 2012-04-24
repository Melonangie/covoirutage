
document.requests = new Map();
document.relations = new Map();
document.favourites = new List();
/**
 * Initialise.
 */
jQuery(function() {
	var oTable = jQuery('#problemsTable').dataTable( {
		"bJQueryUI" : true,
		"aoColumnDefs" : [ {
			"bSortable" : false,
			"aTargets" : [ 0 ]
		} ],
		"aaSorting" : [ [ 1, 'asc' ] ]
	});

	/*
	 * Add event listener for opening and closing details Note that the
	 * indicator for showing which row is open is not controlled by DataTables,
	 * rather it is done here
	 */
	jQuery('#problemsTable tbody td img').live('click', function() {
		var nTr = this.parentNode.parentNode;
		if (this.src.match('details_close')) {
			/* This row is already open - close it */
			this.src = "./images/details_open.png";
			oTable.fnClose(nTr);
		} else {
			/* Open this row */
			this.src = "./images/details_close.png";
			oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
		}
	});
	
	

	jQuery("#departureDate, #departureDate1").datepicker();
	jQuery("#departureTimeStart").timePicker();
	jQuery("#departureTimeStart1").timePicker();
	

	initializeNewProblemDialog();
	jQuery("#newProBtn").click(function(event) {
		$("#newProblem").dialog('open');
	});
});



/**
 * DepartureTimeStart update listener
 */
jQuery("#departureTimeStart").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
	}
});




/**
 * DepartureTimeStart update listener
 */
jQuery("#departureTimeStart1").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
	}
});


/**
 * Date listener
 */

jQuery("#departureDate").change(function() {
	var date = formatAndCheckDate(jQuery(this).val());
	if(!date) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
	}
});

jQuery("#departureDate1").change(function() {
	var date = formatAndCheckDate(jQuery(this).val());
	if(!date) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
	}
});



/**
 * Initialize the newProblem Dialog box.
 * 
 * @return
 */
function initializeNewProblemDialog() {
	/** tab initialisation * */
	jQuery(".tabContent").hide();
	jQuery("ul.tabNavigation li:first").addClass("selected").show();
	jQuery(".tabContent:first").show();
	jQuery('ul.tabNavigation li').click(function() {
		jQuery("ul.tabNavigation li").removeClass("selected");
		jQuery(this).addClass("selected");
		jQuery(".tabContent").hide();
		var activeTab = jQuery(this).find("a").attr("href");
		$(activeTab).slideDown();
		return false;
	}).filter(':first').click();
	
	/** Error initialisation* */
	if(jQuery("#departureDate").val().length == 0) jQuery("#departureDate").addClass("error");
	if(jQuery("#departureDate1").val().length == 0) jQuery("#departureDate1").addClass("error");

	/** dialog box initialisation * */
	jQuery("#newProblem").dialog( {
		autoOpen : false,
		height : 400,
		width : 450,
		resizable : false,
		modal : true,
		buttons : {
			'OK' : function() {
				var b; // {Boolean}
				b = addProblem();
				if (b) jQuery(this).dialog('close');
			},
			'Annuler' : function() {
				jQuery(this).dialog('close');
			}
		},
		close : function() {
		}
	});
}



/**
 * Formating function for row details
 * 
 * @param oTable :
 *            a table
 * @param nTr :
 *            a table row
 * @return
 */
function fnFormatDetails(oTable, nTr) {
	var aData = oTable.fnGetData(nTr);
	var problemID = aData[1];
	var requestsID = document.relations.get(problemID);
	var sOut = "<table border='1'><tr><th>ID requête</th><th>Départ</th><th>Arrivée</th><th>Temps de départ</th><th>Temps d'arrivée</th></tr>";
			
		for(var i=0;i<requestsID.length;i++)
		{
			var timedepar="Départ entre " + document.requests.get(requestsID[i]).departureTimeStart + " et " + document.requests.get(requestsID[i]).departureTimeStop + " (" + document.requests.get(requestsID[i]).departureDate + ")";
			var timearriv="Arrivée entre " + document.requests.get(requestsID[i]).arrivalTimeStart + " et " + document.requests.get(requestsID[i]).arrivalTimeStop + " (" + document.requests.get(requestsID[i]).arrivalDate + ")";
			
			sOut +="<tr><td>"+requestsID[i]+"</td><td>"+document.requests.get(requestsID[i]).departure+"</td><td>"+document.requests.get(requestsID[i]).arrival+"</td><td>"+timedepar+"</td><td>"+timearriv+"</td></tr>";	

		}
	sOut+="</table>"; 
	return sOut;
}



/**
 * Parse the date in the YYYY-MM-DD format for MySQL
 * 
 * @param dateStr :
 *            a date string formated with "DD/MM/YYYY"
 * @return {String} null if dateStr is not a well formated date
 */
function formatAndCheckDate(dateStr) {
	var date;
	try {
		date = jQuery.datepicker.formatDate("yy-mm-dd", jQuery.datepicker
				.parseDate("dd/mm/yy", dateStr));
	} catch (exeption) {
		return null;
	}
	return date;
}



/**
 * Return true if the parameter is a well formated time
 * 
 * @param time
 * @return
 */
function checkTime(timeStr) {
	var separator = ':';
	var regex = /^(\d\d):(\d\d)$/;
	if(timeStr.match(regex)) {
		var array = timeStr.split(separator);
		hour = parseInt(array[0]);
		minute = parseInt(array[1]);
		if(hour > 23 || minute > 59) {
			return false;
		}
	} else {
		return false;
	}
	return true;
}



/**
 * Add a problem to the database
 * 
 * @return true if succes
 */
function addProblem() {
	if(jQuery("#departureDate, #departureTimeStart," +
			"#departureDate1,#departureTimeStart1," + "#arrival").hasClass('error')) {
		return false;
	}
	var dateDptr = formatAndCheckDate(jQuery("#departureDate").val());
	var dateDptr1 = formatAndCheckDate(jQuery("#departureDate1").val());
	var indexArvl = jQuery('#arrival').val();
	jQuery.post("./BD/requests.sql.php", {
		defineProblem : true,
		dateD : dateDptr,
		dateA : dateDptr1,
		timeDStr : jQuery("#departureTimeStart").val(),
		timeAStr : jQuery("#departureTimeStart1").val(),
		addressAlat : document.favourites.get(indexArvl).latitude,
		addressAlng : document.favourites.get(indexArvl).longitude
	}, function(){
	document.location="index.php?module=1&amp;action=problem";
	});
	return true;
}


/**
 * Add a favourites list to an HTML component
 * 
 * @param favourites :
 *            {List}
 * @param componentID :
 *            the ID of a HTML component
 */
function addFavouritesToHTML(favourites, componentID) {
	for ( var i = 0; i < favourites.size(); i++) {
		var favourite = favourites.get(i);
		document.getElementById(componentID).options.add(new Option(
				getFavListLabel(favourite), i));
	}
};


/**
 * Select the usefull information to show in the HTML favourites list.
 * 
 * @param favourite:
 *            a favourite {Favourite}
 * @return the text shown in the HTML favourites list
 */
function getFavListLabel(favourite) {
	var label = favourite.label;
	if (label.length == 0) {
		label = favourite.address;
	}
	return label;
}


function clicksimulation(idpro)
{
document.getElementById(idpro).click();
	}