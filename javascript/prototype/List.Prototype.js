/**
 * @fileOverview A List prototype
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 1.0
 */

/**
 * Create a new empty list
 * 
 * @constructor
 */
function List() {
	this.list = new Array();
}

/**
 * Appends the specified element to the end of this list.
 * 
 * @param elem:
 *            the element to add {Object}
 * @return this {List}
 */
List.prototype.add = function(elem) {
	this.list.push(elem);
	return this;
};

/**
 * Inserts all of the elements in the specified array into this list.
 * 
 * @param array
 *            {Array}
 * @return this {List}
 */
List.prototype.addAll = function(array) {
	for ( var i = 0; i < array.length; i++) {
		this.add(array[i]);
	}
	return this;
};

/**
 * Inserts the specified element at the specified position in this list
 * 
 * @param elem:
 *            the element to add {Object}
 * @return this {List}
 */
List.prototype.insert = function(index, elem) {
	if (index < this.list.length) {
		this.list.splice(index, 0, elem);
	}
	return this;
};

/**
 * Returns true if this list contains no elements.
 * 
 * @return false if contains elements {Boolean}
 */
List.prototype.isEmpty = function() {
	return this.list.length == 0;
};

/**
 * Removes the first occurrence of the specified element from this list, if it
 * is present.
 * 
 * @param elem:
 *            the element to remove {Object}
 * @return this {List}
 */
List.prototype.remove = function(elem) {
	for ( var i = 0; i < this.list.length; i++) {
		if (this.list[i] === elem) {
			this.list.splice(i, 1);
			break;
		}
	}
	return this;
};

/**
 * Removes the element at the specified position in this list.
 * 
 * @param index:
 *            the index of the element to remove {Integer}
 * @return this {List}
 */
List.prototype.removeIndex = function(index) {
	this.list.splice(index, 1);
	return this;
};

/**
 * Removes all of the elements from this list.
 * 
 * @return this {List}
 */
List.prototype.clear = function() {
	this.list.splice(0, this.list.length);
	return this;
};

/**
 * Returns the number of elements in this list.
 * 
 * @return {Integer}
 */
List.prototype.size = function() {
	return this.list.length;
};

/**
 * Returns the element at the specified position in this list.
 * 
 * @param index:
 *            the position of the element {Integer}
 * @return an element {Object}
 */
List.prototype.get = function(index) {
	if (index >= 0 && index < this.list.length) {
		return this.list[index];
	}
};

/**
 * Returns the index of the first occurrence of the specified element in this
 * list, or -1 if this list does not contain the element.
 * 
 * @param elem:
 *            an element in the List {Object}
 * @return -1 if the element is not in the list {Integer}
 */
List.prototype.indexOf = function(elem) {
	for ( var i = 0; i < this.list.length; i++) {
		if (this.list[i] === elem) {
			return i;
		}
	}
	return -1;
};

/**
 * Returns the index of the last occurrence of the specified element in this
 * list, or -1 if this list does not contain the element.
 * 
 * @param elem:
 *            an element in the List {Object}
 * @return -1 if the element is not in the list {Integer}
 */
List.prototype.lastIndexOf = function(elem) {
	for ( var i = this.list.length - 1; i >= 0; i--) {
		if (this.list[i] === elem) {
			return i;
		}
	}
	return -1;
};

/**
 * Replaces the element at the specified position in this list with the
 * specified element.
 * 
 * @param index:
 *            the position of the old elem {Integer}
 * @param elem:
 *            the new element to replace {Object}
 * @return this {List}
 */
List.prototype.set = function(index, elem) {
	if (index < this.list.length) {
		this.list.splice(index, 1, elem);
	}
	return this;
};
