/**
 * @fileOverview A Map prototype
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 1.0
 */

/**
 * Create a new empty map
 * 
 * @constructor
 */
function Map() {
	this.keys = new Array();
	this.values = new Array();
}

/**
 * Associates the specified value with the specified key in this map.
 * 
 * @param key:
 *            the key {Object}
 * @param value:
 *            the value {Object}
 */
Map.prototype.put = function(key, value) {
	var index = this.indexOf(key);
	if (index == (-1)) {
		this.keys.push(key);
		this.values.push(value);
	} else {
		this.values.splice(index, 1, value);
	}
};

/**
 * Returns the value to which the specified key is mapped, or null if this map
 * contains no mapping for the key.
 * 
 * @param key:
 *            the key {Object}
 * @return the value associated to the key {Object} or null
 */
Map.prototype.get = function(key) {
	var result = null;
	var index = this.indexOf(key);
	if (index != (-1)) {
		result = this.values[index];
	}
	return result;
};

/**
 * Returns true if this map contains no key-value mappings.
 * 
 * @return {Boolean}
 */
Map.prototype.isEmpty = function() {
	return this.keys.length == 0;
};

/**
 * Returns the number of key-value mappings in this map.
 * 
 * @return {Integer}
 */
Map.prototype.size = function() {
	return this.keys.length;
};

/**
 * Removes the mapping for a key from this map if it is present.
 * 
 * @param elem:
 *            the element to remove {Object}
 * @return this {List}
 */
Map.prototype.remove = function(key) {
	var index = this.indexOf(key);
	if (index != -1) {
		this.values.splice(index, 1);
		this.keys.splice(index, 1);
	}
};

/**
 * Returns the number of key-value mappings in this map.
 * 
 * @return {Integer}
 */
Map.prototype.clear = function() {
	this.keys.splice(0, this.keys.length);
	this.values.splice(0, this.values.length);
};

/**
 * Returns true if this map contains a mapping for the specified key.
 * 
 * @param key:
 *            a key {Object}
 * @return {Boolean}
 */
Map.prototype.containsKey = function(key) {
	return this.indexOf(key) > -1;
};

/**
 *  Returns true if this map maps one or more keys to the specified value.
 * 
 * @param value:
 *            a value {Object}
 * @return {Boolean}
 */
Map.prototype.containsValue = function(value) {
	var result = false;
	for (var i = 0; i < this.values.length; i++) {
		if (this.values[i] == value) {
			result = true;
			break;
		}
	}
	return result;
};

/**
 * Returns a Array view of the keys contained in this map.
 * 
 * @return {Array}
 */
Map.prototype.keyArray = function() {
	return this.keys;
};

/**
 * Return the position of the key.
 * 
 * @param key:
 *            the key {Object}
 * @param value:
 *            the value {Object}
 */
Map.prototype.indexOf = function(key) {
	var result = (-1);
	for (var i = 0; i < this.keys.length; i++) {
		if (this.keys[i] == key) {
			result = i;
			break;
		}
	}
	return result;
};
