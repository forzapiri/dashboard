function Flash () {
	this._swf = '';
	this._width = 0;
	this._height = 0;
	this._params = new Array();
}

Flash.prototype.setSWF = function (_swf, _width, _height) {
	this._swf 		= _swf;
	this._width 	= _width;
	this._height 	= _height;
}

Flash.prototype.setParam = function (paramName, paramValue) {
	this._params[this._params.length] = paramName+'|||'+paramValue;
}

Flash.prototype.display = function () {
	var _txt 	= '';
	var params = '';
	for ( i=0;i<this._params.length;i++ ) {
		_param = this._params[i].split ('|||');
		params += _param[0]+'="'+_param[1]+'" ';
	}
	if (navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) { // netscape plugin architecture
		_txt = '<embed type="application/x-shockwave-flash" src="'+ this._swf +'" width="'+ this._width +'" height="'+ this._height +'"';
		_txt += ' '+params+'>';
	} else { // PC IE
		_txt = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+ this._width +'" height="'+ this._height +'">';
		_txt += '<param name="movie" value="'+ this._swf +'" />';
		for ( i=0;i<this._params.length;i++ ) {
			_param = this._params[i].split ('|||');
			_txt += '<param name="'+_param[0]+'" value="'+_param[1]+'" />\n';
			params += _param[0]+'="'+_param[1]+'" ';
		}
		_txt += "</object>";
	}
	document.write (_txt);
}