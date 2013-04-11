/**
 * Represents a Log.
 * A log object can
 * 	create a container/div for log messages if needed and
 * 	write log messages in this container.
 */
function Log() {
	this.message = null;
	this.target = null;
}
Log.prototype = {
	setTarget: function(elementId) {
		var defaultElementId = 'logContainer';
		elementId = elementId != null ? elementId : defaultElementId;
		var foundElement = jQuery('body').find('#' + elementId);
		if (foundElement.length != 0) {
			// alert(foundElement.attr('id') + '***');
			this.target = foundElement;
		} else {
			// alert('nothing found');
			this.target = jQuery('<div id="' + elementId +'"><h4 id="logHeader">Log</h4></div>');
			jQuery('body').prepend(this.target);
		}
		// jQuery('#' + elementId).css({'background' : '#00aa00', 'height' : '100'});
		return this;
	},
	log: function(message, logging, lineNumber) {
		if(logging != false) {
			if (this.target == null) {
				this.setTarget();
			}
			var displayedLineNumber;
			if(lineNumber != null) {
				displayedLineNumber = lineNumber;
			} else {
				displayedLineNumber = '...';
			}
			this.target.append(
				'<div class="logMessageContainer">' +
				'<span class="logLineNumber">' + displayedLineNumber + '</span>' +
				'<span class="logMessage">' + message + '</span>' +
				'</div>')
			;
		}
	}
}