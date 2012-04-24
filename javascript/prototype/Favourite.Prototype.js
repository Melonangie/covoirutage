/**
 * @fileOverview a favourite prototype.
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 1.0
 */

/**
 * Create a new Favourite object
 * @param address : the address (eg. : 606 Washington Avenue Southeast, Minneapolis, MN).
 * @param lat : the latitude (eg. 44.973413).
 * @param lng : the longitude (eg. -93.229680).
 * @param label : a name for the address (eg. Big 10 Sandy's favorite restaurant).
 * @constructor
 */
function Favourite(address, lat, lng, country, city,cp,label, comment,predefine) {
	this.address = address;
	this.latitude = lat;
	this.longitude = lng;
	this.country = country;
	this.city = city;
	this.cp = cp;
	this.label = label;
	this.comment = comment;
	this.predefine = predefine;
}
