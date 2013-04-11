/**
 * Represents a Google Map.
 * A GMap can create a Google Map.
 */
function GMap(address) {
	this.logger = new Log();
	this.logging = false;
	this.setAddress(address);
	this.map = null;
	this.geoLocation = null;
	this.idGMapCanvas = 'gMapCanvas';
	this.idGMapLink = 'gMapLink';
	this.idGMapAddress = 'gMapAddress';
}
GMap.prototype = {
	showMap: function() {
		this.logger.log('start showMap()', this.logging, (new Error).lineNumber);
		// Geocoding #start#
		this.logger.log('start generateLatLng()', this.logging, (new Error).lineNumber);
		var geocoder = new google.maps.Geocoder();
		var geoLocation;
		var thisObject = this;
		geocoder.geocode({'address': this.address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				geoLocation = results[0].geometry.location;
				thisObject.logger.log(geoLocation, thisObject.logging, (new Error).lineNumber);
				thisObject.setGeoLocation(geoLocation);
				thisObject.createMap();
				//jQuery('#' + thisObject.getIdGMapLink()).attr('href', thisObject.createGoogleMapsHref());
			} else {
				thisObject.logger.log('Geocode was not successful for the following reason: ' + status, thisObject.logging, (new Error).lineNumber);
				thisObject.createNoMap();
			}
			jQuery('#' + thisObject.getIdGMapCanvas()).after(thisObject.createGoogleMapsLink());
		});
		this.logger.log('stop generateLatLng()', this.logging, (new Error).lineNumber);
		// Geocoding #stop#
		this.logger.log('stop showMap()', this.logging, (new Error).lineNumber);
	},
	getLogging: function() {
		return this.logging;
	},
	setLogging: function(logging) {
		this.logging = logging;
	},
	getIdGMapCanvas: function() {
		return this.idGMapCanvas;
	},
	setIdGMapCanvas: function(id) {
		this.idGMapCanvas = id;
	},
	getIdGMapLink: function() {
		return this.idGMapLink;
	},
	setIdGMapLink: function(id) {
		this.idGMapLink = id;
	},
	getIdGMapAddress: function() {
		return this.idGMapAddress;
	},
	setIdGMapAddress: function(id) {
		this.idGMapAddress = id;
	},
	getAddress: function() {
		return this.address;
	},
	setAddress: function(address) {
		this.address = address || jQuery('#' + this.idGMapAddress).val() || null;
	},
	getGeoLocation: function() {
		return this.geoLocation;
	},
	setGeoLocation: function(geoLocation) {
		this.geoLocation = geoLocation;
	},
	createMap: function() {
		this.logger.log('start createMap()', this.logging, (new Error).lineNumber);
		var mapOptions = {
			backgroundColor: 'transparent',
			disableDefaultUI: true,
			zoom: 15,
			center: this.geoLocation,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		this.map = new google.maps.Map(document.getElementById(this.idGMapCanvas), mapOptions);
		this.addMarker();
		this.logger.log('stop createMap()', this.logging, (new Error).lineNumber);
		return this;
	},
	createNoMap: function() {
		this.logger.log('start createNoMap()', this.logging, (new Error).lineNumber);
		var gMapCanvas = document.getElementById(this.idGMapCanvas);
		jQuery('#' + this.idGMapCanvas).append(
				'<span>keine Karte verfürbar</span>'
		);
		this.logger.log('stop createNoMap()', this.logging, (new Error).lineNumber);
		return this;
	},
	createGoogleMapsLink: function() {
		this.logger.log('start createGoogleMapsHref()', this.logging, (new Error).lineNumber);
		var googleMapsLinkHref = null;
		var googleMapsLinkText = null;
		if (this.geoLocation) {
			googleMapsLinkHref = this.createGoogleMapsHref();
			googleMapsLinkText = this.address;
		} else {
			googleMapsLinkHref = 'http://maps.google.com';
			googleMapsLinkText = 'Google Map';
		}
		var googleMapsLink =
			'<a' +
			' id="' + this.idGMapLink + '"' +
			' href="' + googleMapsLinkHref + '"' +
			'title="' + googleMapsLinkText + '"' +
			' rel="nofollow" ' +
			'>' +
			googleMapsLinkText +
			'</a>'
		;
		this.logger.log('stop createGoogleMapsHref()', this.logging, (new Error).lineNumber);
		return googleMapsLink;
	},
	createGoogleMapsHref: function() {
		this.logger.log('start createGoogleMapsHref()', this.logging, (new Error).lineNumber);
		googleMapsHref = 'http://maps.google.de/maps?' +
			'q=' + this.address +
			' (@' + this.geoLocation.lat() + ',' + this.geoLocation.lng() + ')'
		;
		this.logger.log('stop createGoogleMapsHref()', this.logging, (new Error).lineNumber);
		return googleMapsHref;
	},
	addMarker: function() {
		this.logger.log('start addMarker()', this.logging, (new Error).lineNumber);
		this.marker = new google.maps.Marker({
			map: this.map,
			position: this.geoLocation
		});
		this.logger.log('stop addMarker()', this.logging, (new Error).lineNumber);
	}
}