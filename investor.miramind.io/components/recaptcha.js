define(['Vue', 'jQuery'], function(Vue) {
	if(CONST.RECAPTCHA_KEY) {
		jQuery.getScript('https://www.google.com/recaptcha/api.js');
	}

	Vue.component('recaptcha', {
		template: '<div ref="root"></div>',
		data: function() { return {}; },
		props: ['value'],
		mounted: function() {
			var self = this;
			if(CONST.RECAPTCHA_KEY) {
				(function() {
					if(window.recaptcha) {
						grecaptcha.render(self.$refs.root, {
							sitekey : CONST.RECAPTCHA_KEY,
							callback: function(code) {
								self.$emit('input', code);
							}
						});
					}
					else setTimeout(arguments.callee, 100);
				})();
			}
		}
	});
});