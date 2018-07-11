define(['Vue', 'jQuery'], function(Vue) {
	Vue.component('ulogin', {
		template: '<div ref="root" :data-ulogin="params + \';redirect_uri=;callback=\' + callback_id"></div>',
		data: function() {
			return {
				callback_id: 'uLogin_' + (new Date()).getTime()
			};
		},
		props: ['params'],
		mounted: function() {
			var self = this;

			if(!window.uLogin) jQuery.getScript('https://ulogin.ru/js/ulogin.js');

			window[self.callback_id] = function(token) {
				jQuery.getJSON('https://ulogin.ru/token.php?host=' + encodeURIComponent(location.toString()) + '&token=' + token + '&callback=?', function(res) {
					self.$emit('callback', jQuery.parseJSON(res) || {});
				});
			};
			
			(function() {
				if(window.uLogin) uLogin.customInit(self.$refs.root);
				else setTimeout(arguments.callee, 100);
			})();
		}
	});
});