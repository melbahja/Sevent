/**
 * Project: Sevent
 * Description: Server-sent Events jQuery Plugin
 * Author: Mohamed Elbahja
 * version: 1.0
 */
(function($) {

   $.sevent = {

   	isSupported: "EventSource" in window,

   	options: {
			url: false,
			notSupported: function () {
				console.error('this browser not supported EventSource');
			},	
			source: false
		},

   	init: function(options)
   	{
   		
   		this.options = $.extend({}, this.options, options);

   		if (this.isSupported === false) {
   			this.options.notSupported();	
   		}

   		this.options.source = new EventSource(this.options.url);
   	},
   	
   	on: function(event, func) {
   		this.options.source.addEventListener(event, func, false);
   	},

   	json: function(response) {

   		try {

   			response = $.parseJSON(response.data);
   		
   		} catch (e) {

   			response = false;
   		}	

   		return response;
   	},

   	exit: function() {
   		this.options.source.close();
   	}
   };

}(jQuery));
