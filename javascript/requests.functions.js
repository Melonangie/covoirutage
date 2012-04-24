/**
 * @fileOverview This file has functions related to the request page.
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 0.2
 */

document.favourites = new List();
document.requests = new Map();

/**
 * Initialise.
 */
jQuery(function() {
	var oTable = jQuery('#requestsTable').dataTable( {
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
	jQuery('#requestsTable tbody td img').live('click', function() {
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
	
	/* Hide the ID column */
	fnShowHide(4);

	jQuery("#departureDate, #departureDatePer, #endingDate").datepicker();
	jQuery("#departureTimeStart, #departureTimeStop").timePicker();
	jQuery("#arrivalTimeStart, #arrivalTimeStop").timePicker();
	jQuery("#departureTimeStartPer, #departureTimeStopPer").timePicker();
	jQuery("#arrivalTimeStartPer, #arrivalTimeStopPer").timePicker();

	initializeNewRequestDialog();
	jQuery("#newReqBtn").click(function(event) {
		$("#newRequest").dialog('open');
	});
});

/**
 * DepartureTimeStop update listener
 */
jQuery("#departureTimeStart").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		timeUpdate("#departureTimeStart", "#departureTimeStop");
		valueUpdate("#departureTimeStart", "#departureTimeStartPer");
	}
});

jQuery("#departureTimeStartPer").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		timeUpdate("#departureTimeStartPer", "#departureTimeStopPer");
		valueUpdate("#departureTimeStartPer", "#departureTimeStart");
	}

});

jQuery("#departureTimeStop").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		valueUpdate("#departureTimeStop", "#departureTimeStopPer");
	}
});

jQuery("#departureTimeStopPer").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		valueUpdate("#departureTimeStopPer", "#departureTimeStop");
	}
});

/**
 * ArrivalTimeStop listener
 */
jQuery("#arrivalTimeStart").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		timeUpdate("#arrivalTimeStart", "#arrivalTimeStop");
		valueUpdate("#arrivalTimeStart", "#arrivalTimeStartPer");
	}
});

jQuery("#arrivalTimeStartPer").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		timeUpdate("#arrivalTimeStartPer", "#arrivalTimeStopPer");
		valueUpdate("#arrivalTimeStartPer", "#arrivalTimeStart");
	}
});

jQuery("#arrivalTimeStop").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		valueUpdate("#arrivalTimeStop", "#arrivalTimeStopPer");
	}
});

jQuery("#arrivalTimeStopPer").change(function() {
	var b = checkTime(jQuery(this).val());
	if(!b) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		valueUpdate("#arrivalTimeStopPer", "#arrivalTimeStop");
	}
});

/**
 * RepeatEvery listener
 */
jQuery("#repeats").change(function() {
	repeatEveryUpdate(jQuery("#repeats").val());
});

/**
 * Favourite address listener
 */
jQuery("#departure").change(function() {
	var b = jQuery(this).val() == jQuery("#arrival").val();
	if(b) {
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").addClass("error");
	}
	else {
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").removeClass("error");
	}
	valueUpdate("#departure", "#departurePer");
});

jQuery("#departurePer").change(function() {
	var b = jQuery(this).val() == jQuery("#arrivalPer").val();
	if(b) {
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").addClass("error");
	}
	else {
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").removeClass("error");
	}
	valueUpdate("#departurePer", "#departure");
});

jQuery("#arrival").change(function() {
	var b = jQuery(this).val() == jQuery("#departure").val();
	if(b) {
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").addClass("error");
	}
	else {
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").removeClass("error");
	}
	valueUpdate("#arrival", "#arrivalPer");
});

jQuery("#arrivalPer").change(function() {
	var b = jQuery(this).val() == jQuery("#departurePer").val();
	if(b) {
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").addClass("error");
	}
	else {
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").removeClass("error");
	}
	valueUpdate("#arrivalPer", "#arrival");
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
		valueUpdate("#departureDate", "#departureDatePer");
	}
});

jQuery("#departureDatePer").change(function() {
	var date = formatAndCheckDate(jQuery(this).val());
	if(!date) {
		jQuery(this).addClass("error");
	} else {
		jQuery(this).removeClass("error");
		valueUpdate("#departureDatePer", "#departureDate");
	}
});

jQuery("#arrivalDate").change(function() {
	valueUpdate("#arrivalDate", "#arrivalDatePer");
});

jQuery("#arrivalDatePer").change(function() {
	valueUpdate("#arrivalDatePer", "#arrivalDate");
});

/**
 * Driver listener
 */

jQuery("#driver").change(function() {
	checkboxUpdate("#driver", "#driverPer");
});

jQuery("#driverPer").change(function() {
	checkboxUpdate("#driverPer", "#driver");
});

/**
 * Repeats listener
 */
jQuery("#repeats").change(function() {
	if (jQuery(this).val() == "Weekly") {
		jQuery("#repeatOn").show();
	} else {
		jQuery("#repeatOn").hide();
	}
});

/**
 * Initialize the newRequest Dialog box.
 * 
 * @return
 */
function initializeNewRequestDialog() {
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
	if(jQuery("#departure").val() == jQuery("#arrival").val())
		jQuery("#departure, #arrival, #departurePer, #arrivalPer").addClass("error");
	if(jQuery("#departureDate").val().length == 0) jQuery("#departureDate").addClass("error");
	if(jQuery("#departureDatePer").val().length == 0) jQuery("#departureDatePer").addClass("error");

	/** dialog box initialisation * */
	jQuery("#newRequest").dialog( {
		autoOpen : false,
		height : 400,
		width : 450,
		resizable : false,
		modal : true,
		buttons : {
			'Ajouter la requète' : function() {
				var b; // {Boolean}
				if (isPeriodic()) {
					b = addPeriodicRequest();
				} else {
					b = addSingleRequest();
				}
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
 * Update the second time to be one hour later than the first.
 * 
 * @param timeLabel1 :
 *            a time
 * @param timeLabel2 :
 *            the time which be updated
 * @return
 */
function timeUpdate(timeLabel1, timeLabel2) {
	if (jQuery(timeLabel2).val()) {
		var time = new Date($.timePicker(timeLabel1).getTime());
		time.setHours(time.getHours() + 1, time.getMinutes(), 0, 0);
		$.timePicker(timeLabel2).setTime(time);
	}
}

/**
 * Update the "repeat every" end label
 * 
 * @param value :
 *            the value to update with
 */
function repeatEveryUpdate(value) {
	switch (value) {
	case "Daily":
		jQuery("#repeatEveryLabel").html("jours");
		break;
	case "Weekly":
		jQuery("#repeatEveryLabel").html("semaines");
		break;
	case "Monthly":
		jQuery("#repeatEveryLabel").html("mois");
		break;
	case "Yearly":
		jQuery("#repeatEveryLabel").html("ans");
		break;
	default:
		break;
	}
}

/**
 * Update the second value to be the same the first one.
 * 
 * @param value1 :
 *            a component value
 * @param value2 :
 *            the component value which be updated
 * @return
 */
function valueUpdate(favourite1, favourite2) {
	jQuery(favourite2).val(jQuery(favourite1).val());
}

/**
 * Update the second checkbox to be in the same the first one.
 * 
 * @param cb1 :
 *            a checkbox
 * @param cb2 :
 *            the checkboxe which be updated
 * @return
 */
function checkboxUpdate(cb1, cb2) {
	if (jQuery(cb1).is(':checked')) {
		jQuery(cb2).attr('checked', true);
	} else {
		jQuery(cb2).attr('checked', false);
	}
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
	var requestID = aData[aData.length-3];
	var request = document.requests.get(requestID);
	var sOut = '';
	sOut += "<p>Départ entre " + request.departureTimeStart + " et " + request.departureTimeStop + " (" + request.departureDate + ")" + "</p>";
	sOut += "<p>Arrivée entre " + request.arrivalTimeStart + " et " + request.arrivalTimeStop + " (" + request.arrivalDate + ")" + "</p>";
	sOut += "<p>Départ de " + request.departure + " et Arrivée à " + request.arrival + "</p>";
	if(request.driver==0)
	sOut += "<p>Conducteur: non </p>";
	else
		sOut += "<p>Conducteur: oui </p>";	
	return sOut;
}

/**
 * Show or hide a column
 * 
 * @param iCol :
 *            the position of the column {Integer}
 * @return
 */
function fnShowHide(iCol) {
	var oTable = $('#requestsTable').dataTable();
	var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
	oTable.fnSetColumnVis( iCol, bVis ? false : true );
}


/**
 * Return true if the user send a periodic request
 * 
 * @return {Boolean}
 */
function isPeriodic() {
	return !jQuery("ul.tabNavigation li:first").hasClass('selected');
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
 * Change a today or tomorrow in a date
 * 
 * @param dateStr
 * @param variation
 * @return {String} or null if dateStr is not a date
 */
function formatVarDate(dateStr, variation) {
	if(dateStr.length == 0) return null;
	try {
		var date = jQuery.datepicker.parseDate("yy-mm-dd", dateStr);
		switch (variation) {
		case "sameDay":
			return jQuery.datepicker.formatDate("yy-mm-dd", date);
			break;
		case "followingDay":
			date.setDate(date.getDate() + 1);
			return jQuery.datepicker.formatDate("yy-mm-dd", date);
			break;
		default:
			break;
		}
	} catch (exeption) {
		return null;
	}
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
 * Add a new row
 * 
 * @param request :
 *            {Request}
 * @param id :
 *            the request ID {Integer}
 */
function addRow(request, id) {
	
	$('#requestsTable').dataTable().fnAddData([
		'<img src="./images/details_open.png">',
		request.departureDate,
		request.departurelabel,
		request.arrivallabel,
		id,
		"A prendre en charge",
		""]);
}

/**
 * Add a non-periodic request to the database
 * 
 * @return true if succes
 */
function addSingleRequest() {
	if(jQuery("#departure, #arrival," +
			"#departureDate, #departureTimeStart," +
			"#departureTimeStop, #arrivalTimeStart," +
			"#arrivalTimeStop").hasClass('error')) {
		return false;
	}
	var indexDptr = jQuery('#departure').val();
	var indexArvl = jQuery('#arrival').val();
	var dateDptr = formatAndCheckDate(jQuery("#departureDate").val());
	var dateArvl = formatVarDate(dateDptr, jQuery("#arrivalDate").val());
// alert("addressD : " + document.favourites.get(indexDptr).address + "\n" +
// "addressA : " + document.favourites.get(indexArvl).address + "\n" +
// "dateD : " + dateDptr + "\n" +
// "dateA : " + dateArvl + "\n" +
// "timeDStr : " + jQuery("#departureTimeStart").val() + "\n" +
// "timeDStp : " + jQuery("#departureTimeStop").val() + "\n" +
// "timeAStr : " + jQuery("#arrivalTimeStart").val() + "\n" +
// "timeAStp : " + jQuery("#arrivalTimeStop").val() + "\n" +
// "driver : " + (jQuery("#driver").is(':checked')? 1:0)
// );

	jQuery.post("./BD/requests.sql.php", {
		addSingleRequest : true,
		addressDlat : document.favourites.get(indexDptr).latitude,
		addressDlng : document.favourites.get(indexDptr).longitude,
		addressAlat : document.favourites.get(indexArvl).latitude,
		addressAlng : document.favourites.get(indexArvl).longitude,
		dateD : dateDptr,
		dateA : dateArvl,
		timeDStr : jQuery("#departureTimeStart").val(),
		timeDStp : jQuery("#departureTimeStop").val(),
		timeAStr : jQuery("#arrivalTimeStart").val(),
		timeAStp : jQuery("#arrivalTimeStop").val(),
		driver : (jQuery("#driver").is(':checked')? 1:0)
	}, function(res){
		var request = new Request(
				document.favourites.get(indexDptr).address+','+document.favourites.get(indexDptr).city+','+document.favourites.get(indexDptr).country,
				jQuery('#departure :selected').text(),
				dateDptr,
				jQuery("#departureTimeStart").val(),
				jQuery("#departureTimeStop").val(),
				document.favourites.get(indexArvl).address+','+document.favourites.get(indexArvl).city+','+document.favourites.get(indexArvl).country,
				jQuery("#arrival :selected").text(),
				dateArvl,
				jQuery("#arrivalTimeStart").val(),
				jQuery("#arrivalTimeStop").val(),
				(jQuery("#driver").is(':checked')? 1:0)
				);
		document.requests.put(res, request);
		
		addRow(request, res);
	});
	return true;
}

function addPeriodicRequest() {
	alert("LOL");
}
