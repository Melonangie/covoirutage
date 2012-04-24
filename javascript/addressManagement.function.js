/**
 * @fileOverview This file has functions related to the management of the
 *               addresses.
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 0.8
 */

/**
 * Initialisation
 */
var service = new google.maps.DirectionsService();
var arrayadresse;
var compter=0;
jQuery(document).ready(
		function() {
			jQuery("#addressesTable tr").click(function(event) {
				jQuery(oTable.fnSettings().aoData).each(function() {
					jQuery(this.nTr).removeClass('row_selected');
				});
				jQuery(event.target.parentNode).addClass('row_selected');
			});

			var oTable = jQuery('#addressesTable').dataTable( {
				"bJQueryUI" : true
			});

			jQuery("#departureBtn").click(function(event) {
				selectAddress("#departure", oTable);
				selectLocation("#departureid", oTable);
				
				if(jQuery("#arrivalid").val()!="")
					showDistance(jQuery("#departureid").val(), jQuery("#arrivalid").val(),
					"#distResult");
				
			});

			jQuery("#arrivalBtn").click(function(event) {
				selectAddress("#arrival", oTable);
				selectLocation("#arrivalid", oTable);
				
				if(jQuery("#departureid").val()!="")
				showDistance(jQuery("#departureid").val(), jQuery("#arrivalid").val(),
				"#distResult");
				
			});

			jQuery("#fillMatrixBtn").click(function(event) {
				jQuery.post("./BD/ODMatrix.sql.php", {
					getNullDistances : true
				}, setDistances);
			});

		});

/**
 * Try to put in the database all the wanted distances
 * 
 * @param res :
 *            a JSON of the wanted distances
 */

function setDistances(res) {
	var array = eval(res);
	arrayadresse=array;
	setDistance(array[compter][0], array[compter][1], array[compter][2], array[compter][3],array[compter][4], array[compter][5]);	
}



function nextAdresse()
{
	setDistance(arrayadresse[compter][0], arrayadresse[compter][1], arrayadresse[compter][2], arrayadresse[compter][3],
			arrayadresse[compter][4], arrayadresse[compter][5]);
}




/**
 * Get the distance between two places and put it in the database
 * 
 * @param startID :
 *            The ID of the starting place
 * @param start :
 *            The address of the starting place
 * @param endID :
 *            The ID of the ending place
 * @param end :
 *            The address of the ending place
 * @return
 */
function setDistance(startID, startlat, startlng, endID, endlat, endlng) {
	var start = new google.maps.LatLng(startlat, startlng);
	var end = new google.maps.LatLng(endlat, endlng);
	var request = {
		origin : start,
		destination : end,
		travelMode : google.maps.DirectionsTravelMode.DRIVING
	};
	this.service.route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			jQuery.post("./BD/ODMatrix.sql.php", {
				setDistance : true,
				idA : startID,
				idB : endID,
				distance : response.routes[0].legs[0].distance.value,
				time : response.routes[0].legs[0].duration.value				
			});
			document.getElementById("fillResult").innerHTML=response.routes[0].legs[0].distance.value+" m, "+response.routes[0].legs[0].duration.value+" sec";		
		}
		else
			{
			document.getElementById("fillResult").innerHTML="Erreur: de "+startID+" à "+endID;
			}
		compter++;
		if(compter<arrayadresse.length)
			nextAdresse();
	});
}

/**
 * Show the distance and time travel in a HTML component
 * 
 * @param addressA :
 *            the start address
 * @param addressB :
 *            the end address
 * @param output :
 *            a HTML component
 */
function showDistance(idA, idB, output) {

	jQuery.post("./BD/ODMatrix.sql.php", {
		getDistance : true,
		idA : idA,
		idB : idB
	}, function(res) {
		var obj = jQuery.parseJSON(res);
		if (obj.DISTANCE == null) {
			jQuery(output).html("Non évalué");
		} else {
			jQuery(output).html(
					"Distance : " + parseInt(obj.DISTANCE / 1000)
							+ " km - Temps : " + obj.DUREE);
		}
	});

}

/**
 * Select an address in the table and put it in the corresponding HTML component
 * 
 * @param htmlID :
 *            a HTML component
 * @param table :
 *            a table
 */
function selectAddress(htmlID, table) {
	var address = table.fnGetData(fnGetSelected(table)[0])[1];
	if (!jQuery.isArray(address)) {
		jQuery(htmlID).val(address);
	}
}

function selectLocation(htmlID, table) {
	var id = table.fnGetData(fnGetSelected(table)[0])[0];
	jQuery(htmlID).val(id);
}

/**
 * Get the selected row in a table.
 * 
 * @param oTableLocal :
 *            a table
 * @return the row {array}
 */
function fnGetSelected(oTableLocal) {
	var aReturn = new Array();
	var aTrs = oTableLocal.fnGetNodes();
	for ( var i = 0; i < aTrs.length; i++) {
		if ($(aTrs[i]).hasClass('row_selected')) {
			aReturn.push(aTrs[i]);
		}
	}
	return aReturn;
}

