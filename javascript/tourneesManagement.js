// JavaScript Document

document.begins = new Map();
document.ends = new Map();
document.waypts = new Map();

document.valuesini = new Map();
document.valuespre = new Map();

document.pts = new Array();

var COULEURS = new Array("#FF0000", "#495CFF", "#D400FF", "#B9121B", "#05966D",
		"#5EB6DD", "#8FCF3C", "#FFB6B8", "#FF5B2B", "#B78178", "#2F574D");
var couleur_compteur = 0;

var markers_depart = new Map();
var markers_pt = new Map();
var markers_arrivee = new Map();

var markers_showbegin = new Array();
var marker_arrivee = null;

var info_client = new Array();

document.infoClient_trajet = new Map();

document.pre_directionsDisplays = new Map();
document.rel_directionsDisplays = new Map();

document.map;
var directionsService = new google.maps.DirectionsService();


function g_map() {
	var centre = new google.maps.LatLng(INITIAL_POSITION_LAT,
			INITIAL_POSITION_LNG);
	var myOptions = {
		zoom : INITIAL_ZOOM_LEVEL,
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		center : centre
	};
	document.map = new google.maps.Map(document.getElementById("g_map"),
			myOptions);
	// document.getElementById('tout_pre').click();
	// document.getElementById('tout_reel').click();
}

function showWay_pre(key) {
	var cor_pre_id = key + "p_color";
	if (document.pre_directionsDisplays.get(key) == null) {
		var icon = './images/rien.png';
		var markerop = {
			icon : icon
		};
		// var couleur = document.getElementById(cor_pre_id).value;

		var couleur = COULEURS[couleur_compteur];
		if (couleur_compteur < 10)
			couleur_compteur++;
		else
			couleur_compteur = 0;
		var polylineOp = {
			strokeColor : couleur
		};
		var renderoptions = {
			polylineOptions : polylineOp,
			markerOptions : markerop
		};
		document.pre_directionsDisplays.put(key,
				new google.maps.DirectionsRenderer(renderoptions));
		document.pre_directionsDisplays.get(key).setMap(document.map);
		var request = {
			origin : document.begins.get(key),
			destination : document.ends.get(key),
			travelMode : google.maps.DirectionsTravelMode.DRIVING
		};

		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				document.pre_directionsDisplays.get(key)
						.setDirections(response);
			}
		});
		showDeparture(key, false);
		showArrivees(key);
	} else {
		// var couleur = document.getElementById(cor_pre_id).value;
		var couleur = COULEURS[couleur_compteur];
		if (couleur_compteur < 10)
			couleur_compteur++;
		else
			couleur_compteur = 0;
		var polylineOp = {
			strokeColor : couleur
		};
		var renderoptions = {
			polylineOptions : polylineOp
		};
		document.pre_directionsDisplays.get(key).setOptions(renderoptions);
		document.pre_directionsDisplays.get(key).setMap(document.map);
		showDeparture(key, false);
		showArrivees(key);
	}
}

function showWay_reel(key) {
	var cor_re_id = key + "r_color";
	if (document.rel_directionsDisplays.get(key) == null) {
		var icon = './images/rien.png';
		var markerop = {
			icon : icon
		};
		// var couleur = document.getElementById(cor_re_id).value;
		var couleur = COULEURS[couleur_compteur];
		if (couleur_compteur < 10)
			couleur_compteur++;
		else
			couleur_compteur = 0;
		var polylineOp = {
			strokeColor : couleur
		};
		var renderoptions = {
			polylineOptions : polylineOp,
			markerOptions : markerop
		};
		document.rel_directionsDisplays.put(key,
				new google.maps.DirectionsRenderer(renderoptions));
		document.rel_directionsDisplays.get(key).setMap(document.map);
		var request = {
			origin : document.begins.get(key),
			destination : document.ends.get(key),
			waypoints : document.waypts.get(key),
			optimizeWaypoints : false,
			travelMode : google.maps.DirectionsTravelMode.DRIVING
		};

		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				document.rel_directionsDisplays.get(key)
						.setDirections(response);
			}
		});
		showDeparture(key, false);
		showArrivees(key);
	} else {
		// var couleur = document.getElementById(cor_re_id).value;
		var couleur = COULEURS[couleur_compteur];
		if (couleur_compteur < 10)
			couleur_compteur++;
		else
			couleur_compteur = 0;
		var polylineOp = {
			strokeColor : couleur
		};
		var renderoptions = {
			polylineOptions : polylineOp
		};
		document.rel_directionsDisplays.get(key).setOptions(renderoptions);
		document.rel_directionsDisplays.get(key).setMap(document.map);
		showDeparture(key, false);
		showArrivees(key);
	}
}

function Gestion_Ways_Pre(element_id, key) {
	if (document.getElementById(element_id).checked) {
		showWay_pre(key);
	} else {
		document.pre_directionsDisplays.get(key).setMap(null);
		markers_depart.get(key).setMap(null);
		markers_arrivee.get(key).setMap(null);

	}
}

function Gestion_Ways_reel(element_id, key) {
	if (document.getElementById(element_id).checked) {
		showWay_reel(key);
	} else {
		document.rel_directionsDisplays.get(key).setMap(null);
		markers_depart.get(key).setMap(null);
		markers_arrivee.get(key).setMap(null);
		var ptsarr = markers_pt.get(key);
		for ( var a = 0; a < ptsarr.length; a++) {
			ptsarr[a].setMap(null);
		}
	}
}

function defineColor_pre(key, color) {
	if (color != 0) {
		var pre_route_id = key.slice(0, key.length - 6);
		var pre_key = key.slice(0, key.length - 7);
		if (document.getElementById(pre_route_id).checked) {
			var polylineOp = {
				strokeColor : color
			};
			var renderoptions = {
				polylineOptions : polylineOp
			};
			document.pre_directionsDisplays.get(pre_key).setOptions(
					renderoptions);
			document.pre_directionsDisplays.get(pre_key).setMap(document.map);
		}
	}
}

function defineColor_re(key, color) {
	if (color != 0) {
		var re_route_id = key.slice(0, key.length - 6);
		var re_key = key.slice(0, key.length - 7);
		if (document.getElementById(re_route_id).checked) {
			var polylineOp = {
				strokeColor : color
			};
			var renderoptions = {
				polylineOptions : polylineOp
			};
			document.rel_directionsDisplays.get(re_key).setOptions(
					renderoptions);
			document.rel_directionsDisplays.get(re_key).setMap(document.map);
		}
	}
}

function SelectAllPre_check(id) {
	if (document.getElementById(id).checked) {
		for ( var i = 0; i < document.waypts.size(); i++) {
			var keyArray = document.begins.keyArray();
			var key = keyArray[i];
			// document.getElementById(key + 'p').checked = true;
			showWay_pre(key);
		}
	} else {
		var keyArray = document.pre_directionsDisplays.keyArray();
		for ( var i = 0; i < document.pre_directionsDisplays.size(); i++) {
			var key = keyArray[i];
			// document.getElementById(key + 'p').checked = false;
			document.pre_directionsDisplays.get(key).setMap(null);
			markers_depart.get(key).setMap(null);
			markers_arrivee.get(key).setMap(null);
		}

	}
}

function SelectAllrel_check(id) {
	if (document.getElementById(id).checked) {
		for ( var i = 0; i < document.waypts.size(); i++) {
			var keyArray = document.begins.keyArray();
			var key = keyArray[i];
			// document.getElementById(key + 'r').checked = true;
			showWay_reel(key);
		}
	} else {
		var keyArray = document.rel_directionsDisplays.keyArray();
		for ( var i = 0; i < document.rel_directionsDisplays.size(); i++) {
			var key = keyArray[i];
			// document.getElementById(key + 'r').checked = false;
			document.rel_directionsDisplays.get(key).setMap(null);
			markers_depart.get(key).setMap(null);
			markers_arrivee.get(key).setMap(null);
			var ptsarr = markers_pt.get(key);
			for ( var a = 0; a < ptsarr.length; a++) {
				ptsarr[a].setMap(null);
			}
		}
	}
}

function detail_pre(id) {
	if (document.getElementById(id + 'p').checked) {
		document.getElementById("detail").innerHTML = "";
		document.pre_directionsDisplays.get(id).setPanel(
				document.getElementById("detail"));
		var result = document.pre_directionsDisplays.get(id).getDirections();
		var rout = result.routes;
		var legs = rout[0].legs;
		var dis = 0;
		var dur = 0;
		for ( var j = 0; j < legs.length; j++) {
			dis += legs[j].distance.value;
			dur += legs[j].duration.value;
		}
		dis = dis / 1000 + " km";
		dur = Math.round(dur / 60) + " min";
		document.getElementById("id_tournee").innerHTML = "Trajet réel " + id
				+ ": " + dis + ", " + dur;
	}
}

function detail_re(id) {
	if (document.getElementById(id + 'r').checked) {
		document.getElementById("detail").innerHTML = "";
		document.rel_directionsDisplays.get(id).setPanel(
				document.getElementById("detail"));
		var result = document.rel_directionsDisplays.get(id).getDirections();
		var rout = result.routes;
		var legs = rout[0].legs;
		var dis = 0;
		var dur = 0;
		for ( var j = 0; j < legs.length; j++) {
			dis += legs[j].distance.value;
			dur += legs[j].duration.value;
		}
		dis = dis / 1000 + " km";
		dur = Math.round(dur / 60) + " min";
		document.getElementById("id_tournee").innerHTML = "Trajet prévisionnel "
				+ id + ": " + dis + ", " + dur;
	}
}
/*
 * function calcul_Total() { var distan_pre = calcul_DistanceTotal("pre_total") /
 * 1000; var distan_re = calcul_DistanceTotal("rel_total") / 1000; var
 * distan_brute = calcul_Total_Brute("distance") / 1000;
 * document.getElementById("dispre").innerHTML = distan_pre;
 * document.getElementById("disrel").innerHTML = distan_re;
 * document.getElementById("disbrut").innerHTML = distan_brute; var dur_pre =
 * Math.round(calcul_DureeTotal("pre_total") / 60); var dur_re =
 * Math.round(calcul_DureeTotal("rel_total") / 60); var dur_brute =
 * Math.round(calcul_Total_Brute("duree") / 60);
 * document.getElementById("durpre").innerHTML = dur_pre;
 * document.getElementById("durrel").innerHTML = dur_re;
 * document.getElementById("durbrut").innerHTML = dur_brute; }
 * 
 * function calcul_Total_Brute(note) { var valeurini = 0; for ( var i = 0; i <
 * document.valuesini.size(); i++) { valuearr = document.valuesini.values; value =
 * valuearr[i]; if (note == "distance") result = value[0]; if (note == "duree")
 * result = value[1]; valeurini += result; } return valeurini; }
 * 
 * function Brute_Select() { var valuedis = calcul_Select_Brute("distance"); var
 * distan_bru_sel = valuedis / 1000 + ' km'; var valuedur =
 * calcul_Select_Brute("duree"); var dur_bru_sel =
 * Math.round(calcul_Select_Brute("duree") / 60) + ' minutes';
 * document.getElementById("brute_select").innerHTML = distan_bru_sel + "--" +
 * dur_bru_sel; }
 * 
 * function calcul_Select_Brute(note) { var value = 0; var key_arr =
 * document.valuesini.keyArray(); for ( var i = 0; i < key_arr.length; i++) { if
 * (document.getElementById(key_arr[i] + 'p').checked ||
 * document.getElementById(key_arr[i] + 'r').checked) { valuearr =
 * document.valuesini.get(key_arr[i]); if (note == "distance") result =
 * valuearr[0]; if (note == "duree") result = valuearr[1]; value += result; } }
 * return value; }
 * 
 * function calcul_Select() { var distan_pre =
 * calcul_DistanceSelect("pre_select") / 1000 + ' km'; var distan_re =
 * calcul_DistanceSelect("rel_select") / 1000 + ' km';
 * document.getElementById("dis_pre_select").innerHTML = distan_pre;
 * document.getElementById("dis_rel_select").innerHTML = distan_re; var dur_pre =
 * Math.round(calcul_DureeSelect("pre_select") / 60) + ' minutes'; var dur_re =
 * Math.round(calcul_DureeSelect("rel_select") / 60) + ' minutes';
 * document.getElementById("dur_pre_select").innerHTML = dur_pre;
 * document.getElementById("dur_rel_select").innerHTML = dur_re; }
 * 
 * function calcul_DistanceSelect(note) { if (note == "pre_select") { var
 * display = document.pre_directionsDisplays; var mar = 'p'; } if (note ==
 * "rel_select") { var display = document.rel_directionsDisplays; var mar = 'r'; }
 * var dis = 0; var key_arr = display.keyArray(); for ( var i = 0; i <
 * key_arr.length; i++) { if (document.getElementById(key_arr[i] + mar).checked) {
 * var result = display.get(key_arr[i]).getDirections(); var rout =
 * result.routes; var legs = rout[0].legs; for ( var j = 0; j < legs.length;
 * j++) { dis += legs[j].distance.value; } } } return dis; }
 * 
 * function calcul_DureeSelect(note) { if (note == "pre_select") { var display =
 * document.pre_directionsDisplays; var mar = 'p'; } if (note == "rel_select") {
 * var display = document.rel_directionsDisplays; var mar = 'r'; } var dur = 0;
 * var key_arr = display.keyArray(); for ( var i = 0; i < key_arr.length; i++) {
 * if (document.getElementById(key_arr[i] + mar).checked) { var result =
 * display.get(key_arr[i]).getDirections(); var rout = result.routes; var legs =
 * rout[0].legs; for ( var j = 0; j < legs.length; j++) { dur +=
 * legs[j].duration.value; } } } return dur; }
 * 
 * function calcul_DureeTotal(note) { if (note == "pre_total") var display =
 * document.pre_directionsDisplays; if (note == "rel_total") var display =
 * document.rel_directionsDisplays; var dur = 0; var rend = display.values; for (
 * var i = 0; i < rend.length; i++) { var result = rend[i].getDirections(); var
 * rout = result.routes; var legs = rout[0].legs; for ( var j = 0; j <
 * legs.length; j++) { dur += legs[j].duration.value; } } return dur; }
 * 
 * function calcul_DistanceTotal(note) { if (note == "pre_total") var display =
 * document.pre_directionsDisplays; if (note == "rel_total") var display =
 * document.rel_directionsDisplays; var dis = 0; var rend = display.values; for (
 * var i = 0; i < rend.length; i++) { var result = rend[i].getDirections(); var
 * rout = result.routes; var legs = rout[0].legs; for ( var j = 0; j <
 * legs.length; j++) { dis += legs[j].distance.value; } } return dis; }
 */
function createMarker(idpt, showall) {
	// keysarr = document.begins.keyArray();
	image = "./images/green-dot.png";
	// for ( var i = 0; i < keysarr.length; i++) {
	// idpt = keysarr[i];
	var localisation = document.begins.get(idpt);
	var lati = localisation.lat();
	var lngi = localisation.lng();
	lati = lati.toFixed(7);
	lngi = lngi.toFixed(7);
	for ( var j = 0; j < info_client.length; j++) {
		var nom = "";
		var prenom = "";
		if (info_client[j][2] == lati && info_client[j][3] == lngi) {
			if (info_client[j][0] == null) {
				prenom = info_client[j][4];
			} else {
				nom = info_client[j][0];
				prenom = info_client[j][1];
			}
			break;
		}
	}
	if (showall == false) {
		markers_depart.put(idpt, new google.maps.Marker({
			position : localisation,
			map : document.map,
			title : "Départ 0, ID trajet: " + idpt + ", " + prenom + " " + nom,
			icon : image
		}));
	} else {
		markers_showbegin.push(new google.maps.Marker({
			position : localisation,
			map : document.map,
			title : "Départ 0, ID trajet: " + idpt + ", " + prenom + " " + nom,
			icon : image
		}));
	}
	if (document.waypts.size() > 0) {
		var wyptarr = document.waypts.get(idpt);
		var arrptways = new Array();
		for ( var k = 0; k < wyptarr.length; k++) {
			var wayptlocal = wyptarr[k].location;
			var lati1 = wayptlocal.lat();
			var lngi1 = wayptlocal.lng();
			lati1 = lati1.toFixed(7);
			lngi1 = lngi1.toFixed(7);
			var ordre = k + 1;

			for ( var l = 0; l < info_client.length; l++) {
				var name = "";
				var firstname = "";
				if (info_client[l][2] == lati1 && info_client[l][3] == lngi1) {
					if (info_client[l][0] == null) {
						firstname = info_client[l][4];
					} else {
						name = info_client[l][0];
						firstname = info_client[l][1];
					}
					break;
				}
			}
			if (showall == false) {
				arrptways.push(new google.maps.Marker({
					position : wayptlocal,
					map : document.map,
					title : "WayPoint" + ordre + ", ID trajet: " + idpt + ", "
							+ firstname + " " + name,
					icon : image
				}));
			} else {
				markers_showbegin.push(new google.maps.Marker({
					position : wayptlocal,
					map : document.map,
					title : "WayPoint" + ordre + ", ID trajet: " + idpt + ", "
							+ firstname + " " + name,
					icon : image
				}));
			}
		}
		if (showall == false)
			markers_pt.put(idpt, arrptways);
	}
	// }
}

function showDeparture(keytrajet, showall) {
	if (markers_depart.get(keytrajet) != null && showall == false) {
		markers_depart.get(keytrajet).setMap(document.map);
		if (markers_pt.size() > 0) {
			var arrpts = markers_pt.get(keytrajet);
			for ( var l = 0; l < arrpts.length; l++) {
				arrpts[l].setMap(document.map);
			}
		}
	} else {
		if (info_client.length == 0) {
			jQuery.post("./BD/favourites.sql.php", {
				getinfo : true
			}, function(res) {
				var obj = jQuery.parseJSON(res);
				for ( var i = 0; i < obj.length; i++) {
					info_client[i] = new Array(5);
					info_client[i][0] = obj[i].NOM;
					info_client[i][1] = obj[i].PRENOM;
					info_client[i][2] = obj[i].LATITUDE;
					info_client[i][3] = obj[i].LONGITUDE;
					info_client[i][4] = obj[i].ALIAS;
				}
				createMarker(keytrajet, showall);
			});
		} else
			createMarker(keytrajet, showall);
	}
}

function showDepartures() {
	if (info_client.length == 0) {
		jQuery.post("./BD/favourites.sql.php", {
			getinfo : true
		}, function(res) {
			var obj = jQuery.parseJSON(res);
			for ( var i = 0; i < obj.length; i++) {
				info_client[i] = new Array(5);
				info_client[i][0] = obj[i].NOM;
				info_client[i][1] = obj[i].PRENOM;
				info_client[i][2] = obj[i].LATITUDE;
				info_client[i][3] = obj[i].LONGITUDE;
				info_client[i][4] = obj[i].ALIAS;
			}
			keysarr = document.begins.keyArray();
			for ( var i = 0; i < keysarr.length; i++) {
				idpt = keysarr[i];
				showDeparture(idpt, true);
			}
		});
	} else {
		keysarr = document.begins.keyArray();
		for ( var i = 0; i < keysarr.length; i++) {
			idpt = keysarr[i];
			showDeparture(idpt, true);
		}
	}
}

function showArrivee() {
	keysend = document.ends.keyArray();
	idpt = keysend[0];
	var localisation = document.ends.get(idpt);
	marker_arrivee = new google.maps.Marker({
		position : localisation,
		map : document.map,
		title : "Arrivée"
	});
}

function showArrivees(idtrajet) {
	if (markers_arrivee.get(idtrajet) != null) {
		markers_arrivee.get(idtrajet).setMap(document.map);
	} else {
		var localisation = document.ends.get(idtrajet);
		markers_arrivee.put(idtrajet, new google.maps.Marker({
			position : localisation,
			map : document.map,
			title : "Arrivée"
		}));
	}
}

function operateDiv2() {
	if (document.getElementById("itineraires").checked) {
		document.getElementById("operate_panel").style.visibility = "visible";
		document.getElementById("id_tournee").style.visibility = "visible";
		document.getElementById("detail").style.visibility = "visible";
	} else {
		document.getElementById("operate_panel").style.visibility = "hidden";
		document.getElementById("id_tournee").style.visibility = "hidden";
		document.getElementById("detail").style.visibility = "hidden";
	}

}

function operateDiv1() {
	if (document.getElementById("ptsarrivee").checked) {
		if (marker_arrivee == null) {
			showArrivee();
		} else {
			marker_arrivee.setMap(document.map);
		}
	} else {
		marker_arrivee.setMap(null);
	}
}

function operateDiv() {
	if (document.getElementById("ptsdepart").checked) {
		if (markers_showbegin.length == 0) {
			showDepartures();
		} else {
			for ( var k = 0; k < markers_showbegin.length; k++) {
				markers_showbegin[k].setMap(document.map);
			}
		}
	} else {
		for ( var k = 0; k < markers_showbegin.length; k++) {
			markers_showbegin[k].setMap(null);
		}
	}
}
/**
 * Initialise.
 */
jQuery(function() {
	var oTable = jQuery('#trajetTable').dataTable({
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
	jQuery('#trajetTable tbody td img').live('click', function() {
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
});

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
	var trajetID = aData[1];
	var valueprev = document.valuespre.get(trajetID);
	var dis_prv = valueprev[0];
	var dur_prv = valueprev[1];
	var valueinit = document.valuesini.get(trajetID);
	var dis_init = valueinit[0];
	var dur_init = valueinit[1];
	var sOut = "<table border='1'><tr><th></th><th>Distance(km)</th><th>Durée(min)</th></tr>";
	sOut += "<tr><th>Covoiturage</th><td>" + dis_prv + "</td><td>" + dur_prv
			+ "</td></tr>";
	sOut += "<tr><th>Sans Covoiturage</th><td>" + dis_init / 1000 + "</td><td>"
			+ Math.round(dur_init / 60) + "</td></tr>";
	sOut += "</table><br>";

	var info_cli = document.infoClient_trajet.get(trajetID);
	sOut += "<table border='1'><tr><th>Ordre</th><th>Nom Client</th><th>Distance Seule(km)</th><th>Gain</th><th>Durée</th></tr>";

	for ( var i = 0; i < info_cli.length; i++) {
		var infomarr = info_cli[i];
		var name = infomarr[0];
		var firstname = infomarr[1];
		var dist = infomarr[2];
		var dure = infomarr[3];
		var order = i + 1;
		var gain = Math.round((1 - dis_prv * 1000 / dis_init) * 100) + '%';
		sOut += "<tr><td>" + order + "</td><td>" + firstname + " " + name
				+ "</td><td>" + dist / 1000 + "</td><td>" + gain + "</td><td>"
				+ dure + "</td></tr>";
	}
	sOut += "</table>";
	return sOut;

}
