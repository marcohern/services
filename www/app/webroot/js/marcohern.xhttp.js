
window.marcohern = (window.marcohern || {});
window.marcohern.xhttp = (function (xh){

	var settings = {
		log: true,
		timeout: 10000,
		baseUrl: 'http://services.marcohern.com'
	}

	var def = {
		mode: "get",
		url: "",
		data: {}
	}

	var log = function(string) {
		if (!settings.log) { return; }
		if (console) {
			if (console.log) {
				console.log(string);
			}
		}
	}

	var extend = function (array1, array2) {
		var r = array1;
		for (var attr in array2) {
			r[attr] = array2[attr];
		}
		return r;
	}

	var createXhttp = function() {
		log("createXhttp");
		if (XMLHttpRequest) {
			return new XMLHttpRequest();
		} else {
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
	}

	var parseJSON = function (txt) {
		try {
			return eval("(" + txt + ")");
		} catch (e) {
			log(e);
		}
	}

	var readyStateChange = function(xhttp) {
		log(xhttp);
		if (xhttp.readyState != 4) return;
		xh.onCompleted(xhttp.status, xhttp);
		if (xhttp.readyState == 4 && xhttp.status === 200) {
			var data = parseJSON(xhttp.response);
			xh.onSuccess(data, xhttp.status, xhttp);
		} else {
			xh.onFail(xhttp.status, xhttp.statusText, xhttp);
		}
	}

	xh.call = function(s) {
		log("call");
		var options = extend(def, s);
		var xhttp = createXhttp();
		xhttp.onreadystatechange = function() { readyStateChange(xhttp); };
		xhttp.ontimeout = function() {
			xh.onFail(0, "Call Timed out", xhttp);
		};
		xhttp.onerror = function() {
			xh.onFail(0, "Error", xhttp);
		};

		xhttp.onabort = function() {
			xh.onFail(0,"Aborted!", xhttp);
		};

		log(s.mode + " " + s.url);
		xhttp.open(s.mode, s.url, false);
		
		//xhttp.setRequestHeader("Access-Control-Request-Headers","x-json");
		//xhttp.setRequestHeader("Access-Control-Request-Methods","GET");
		xhttp.send(s.data);
	}

	xh.onSuccess = function(data, status, xhttp) {
		log("onSuccess("+status+",data)");
		log(data);
	}

	xh.onFail = function(status, error, xhttp) {
		log("onFail(" + status + ", '" + error + "')");
	}

	xh.onCompleted = function(status, xhttp) {
		log("onCompleted(" + status + ")");
	}

	xh.test = function() {
		var s = {
			mode: "get",
			url: "http://services.marcohern.com/countries"
		};

		xh.call(s);
		return false;
	}

	return xh;
})(window.marcohern.xhttp || {});