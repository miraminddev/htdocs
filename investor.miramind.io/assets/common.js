window.lang = {};

requirejs.config({
    urlArgs: '?' + CONST.VERSION,
	baseUrl: './components/',
	paths: {
		jQuery: 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min',
		Vue: 'https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.1/vue.min',
		vue: '/assets/require-vuejs.min'
	}
});

require([
	'Vue',
	'jQuery',
	'recaptcha',
	'ulogin',
	'loupe',
	'vue!i-modal',
	'vue!auth',
	'vue!layout',
	'vue!kyc',
	'vue!purchase',
	'vue!investments',
	'vue!referral',
	'vue!help',
	'vue!contacts',
	'vue!profile',
	'vue!a-users',
	'vue!a-payments',
	'vue!a-settings',
	'vue!a-dashbord',
	'vue!a-lang', 
	'vue!a-css',
	'vue!a-managers' 
], function(Vue) {
	window.App = new Vue({
		el: '#App',
		data: {
			site: {
				contact: {},
				contract: {},
				links: [],
				refferals: {},
				social: {},
				prices: {},
				ico_steps: [],
				langs: {},
				help: []
			},
			user: {},
			user_eth: {address: '0x0000000000000000000000000000000000000000', tokens: 0, contract_in_pause: false},
			currentView: 'auth',
			web3_status: 0,

			chunk_loaded: {
				lang: false,
				user: false,
				site: false
			}
		},
		computed: {
			page_loaded: function() {
				return this.chunk_loaded.lang && this.chunk_loaded.user && this.chunk_loaded.site;
			}
		},
		mounted: function() {
			jQuery.ajaxSetup({headers: {'X-CSRF-Token': CONST.CSRF}});
			this.getLang(CONST.LANG);
			this.checkAuth();
			this.web3_status = typeof web3 !== 'undefined' ? (web3.eth.coinbase ? 2 : 1) : 0;
		},
		methods: {
			notice: function(params) {
				var notice = $('<div class="b-notice"><div class="b-notice__close">✖</div><div class="b-notice__title"></div><div class="b-notice__body"></div></div>');
				notice.find('.b-notice__title').html(params.title);
				notice.find('.b-notice__body').html(params.body);
				notice.find('.b-notice__close').on('click', function() { notice.remove(); });
				notice.addClass('b-notice_' + params.type);
				setTimeout(function() { notice.find('.b-notice__close').trigger('click'); }, params.lifetime);
				$('.b-notices').prepend(notice);
			},
			success: function(msg) {
				this.notice({title: '', body: msg, type: 'success', lifetime: 10000});
			},
			warning: function(msg) {
				this.notice({title: '', body: msg, type: 'warning', lifetime: 10000});
			},
			error: function(msg) {
				this.notice({title: '', body: msg, type: 'error', lifetime: 10000});
			},

			api: function(method, data, cb) {
				var cb = typeof cb == 'function' ? cb : (typeof data == 'function' ? data : function(err, res) {
					if(err) App.error(App.lang(res));
					if((res || {}).success) App.success(App.lang('Operation completed'));
				});
				var data = typeof data == 'object' ? (data || {}) : {};

				return jQuery.post('/api/' + method + '/', data, function(res) {
					if(res.error) {
						var err = cb(res.error, null);
						if(err && typeof err == 'string') App.error(App.lang(err));
					}
					else if(res.success) cb(null, res);
					else if(res.prompt) {
						var message = jQuery.trim(prompt(res.prompt));
						if(message) jQuery.post('/api/' + method + '/', jQuery.extend(data, {prompt: message}), arguments.callee);
					}
				});
			},
			upload: function(cb, accept, multiple, name) {
				var err = function(err) { alert(typeof err == 'string' && err ? err : lang.file_upload_error); };
				$('<input type="file"/>').attr({accept: accept || '*', multiple: multiple || false}).on('change', function() {
					$.each(this.files, function(k, file) {
						var form = new FormData();
						form.append('file', file);
						form.append('name', name || '');

						$.ajax({url: '/api/site.uploadFile/', type: 'POST', data: form, cache: false, dataType: 'JSON', processData: false, contentType: false}).then(function(res) {
							if(typeof res == 'object' && res != null) {
								if(res.file.url) cb(res.file);
								else err(res.error);
							}
							else err();
						}, err);
					});
			    }).trigger('click');
			},

			lang: function(key) {
				var args = arguments;
				if(args.length > 1) {
					return (window.lang[key] || key).replace(/{(\d+)}/g, function(m, n) { 
						return typeof args[parseInt(n) + 1] != undefined ? args[parseInt(n) + 1] : m;
					});
				}
				else return window.lang[key] || key;
			},
			getLang: function(lang) {
				var self = this;

				self.chunk_loaded.lang = false;

				$.getJSON('/langs/' + lang + '.json?' + CONST.VERSION, function(res) {
					if((res || {}).lang) {
						window.lang = res;
						document.cookie = 'lang=' + lang +'; Max-Age=2592000; path=/';
						CONST.LANG = lang;
						self.chunk_loaded.lang = true;
						self.chunk_loaded.site = false;

						self.api('site.get', function(err, res) {
							self.site = (res || {}).site || {};
							self.chunk_loaded.site = true;
						});
					}
				});
			},

			checkAuth: function() {
				var self = this;

				self.chunk_loaded.site = false;
				self.chunk_loaded.user = false;

				self.api('site.get', function(err, res) {
					self.site = (res || {}).site || {};
					self.chunk_loaded.site = true;
				});

				self.api('user.get', function(err, res) {
					self.user = (res || {}).user || {id: 0};
					self.currentView = self.user.id > 0 ? 'layout' : 'auth';

					if(self.user.id > 0) {
						self.api('user.getEth', function(err, res) {
							self.user_eth = (res || {}).user_eth || {};
						});
					}
					else self.user_eth + {};

					self.chunk_loaded.user = true;
				});
			},
		}
	});
});