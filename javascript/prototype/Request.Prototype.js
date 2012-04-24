/**
 * @fileOverview a request prototype.
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 0.5
 */

/**
 * Create a new Request object
 * 
 * @constructor
 */
function Request(adrD,adrDlabel, dateD, timeStrD, timeStpD,
				 adrA,adrAlabel, dateA, timeStrA, timeStpA, driver) {
	this.departure = adrD;
	this.departurelabel = adrDlabel;
	this.arrival = adrA;
	this.arrivallabel = adrAlabel;
	this.departureDate = dateD;
	this.arrivalDate = dateA;
	this.departureTimeStart = timeStrD;
	this.departureTimeStop = timeStpD;
	this.arrivalTimeStart = timeStrA;
	this.arrivalTimeStop = timeStpA;
	this.driver = driver;
}