/* Links dates in HTML_FORMS so that the end date is always after the start_date */

function linkStartEndTimes(start, end, sameday) {
	var diff; // Remember previous difference between times
	var element = $(start);
	if (!element) return;

	var starts = element.up().childElements();

	element = $(end);
	if (!element) return;
	var ends = element.up().childElements();
	var count=0;
	function onChangeStart () {
		var st = getTimestamp(start);
		if (sameday && ((new Date(st + diff)).getDay() != (new Date(st)).getDay())) diff = 0; // result would straddle midnight
		setTimestamp(end, st + diff);
		// alert ("Start: " + diff);
	}
	function onChangeEnd() {
		var st = getTimestamp(start);
		var et = getTimestamp(end);
		// alert ("st " + st + ", et " + et);
		if (et - st >= 0) {
			diff = et - st;
		} else {
			st = et - diff;
			if (sameday && ((new Date(st)).getDay() != (new Date(et)).getDay())) diff = 0; // result would straddle midnight
			setTimestamp(start, et - diff);
		}
		// alert ("End: " + diff);
	}
	starts.each (function (el) {el.observe ('change', onChangeStart.bind(this));});
	ends.each (function (el) {el.observe ('change', onChangeEnd.bind(this));});
	diff = getTimestamp(end) - getTimestamp(start);
}

function getTimestamp(name) {
	var element = $(name);
	if (!element) return;
	var els = element.up().childElements();
	var year=0, month=0, day=0, hours=0, minutes=0, seconds=0, pm=false;
	els.each (function (el) {
		var name = el.readAttribute('name');
		var id = name.slice(1+name.indexOf("["), name.indexOf("]"));
		switch (id) {
			case 'Y': year = el.value; break;
			case 'n':
			case 'M':
			case 'm': month = el.value - 1; break;
			case 'j':
			case 'd': day = el.value; break;
			case 'H': hours = el.value; break;
			case 'g':
			case 'h': hours = el.value%12; break;
			case 'i': minutes = el.value; break;
			case 's': seconds = el.value; break;
			case 'a':
			case 'A': if (el.value.toLowerCase() == 'pm') pm=true; break;
		}
	});
	if (pm) hours += 12;
   	date = new Date(year, month, day, hours, minutes, seconds);
   	return date.valueOf();
}

function setTimestamp(name, value) {
	var element = $(name);
	if (!element) return;
	var els = element.up().childElements();
	var date = new Date(value);
	els.each (function (el) {
		var name = el.readAttribute('name');
		var id = name.slice(1+name.indexOf("["), name.indexOf("]"));
		switch (id) { // TODO: I DON'T TRUST ALL CASES OF THIS YET.
			case 'Y': el.value = date.getFullYear();
			case 'n':
			case 'M':
			case 'm': el.value = 1 + date.getMonth(); break;
			case 'j':
			case 'd': el.value = date.getDate(); break;
			case 'H': el.value = date.getHours(); break;
			case 'g': 
			case 'h': el.value = (11+date.getHours())%12+1; break;// convert 0-23 to 1-12
			case 'i': el.value = date.getMinutes(); break;
			case 's': el.value = date.getSeconds(); break;
			case 'a': el.value = (date.getHours() >= 12) ? 'pm' : 'am'; break;
			case 'A': el.value = (date.getHours() >= 12) ? 'PM' : 'AM'; break;
		}
	});
}
