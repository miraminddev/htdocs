<template>
	<div class="b-auth">
		<div class="b-auth__body">
			<a href="/" class="b-auth__logo" :style="{backgroundImage: App.site.contact.logo ? 'url(' + App.site.contact.logo + ')' : ' '}"></a>
			<div class="b-auth__subtitle">{{ lang.lk_investor }}</div>
			<form method="POST" action="" class="b-auth__wrap" @submit="submit($event)">
				<div class="b-auth__title" v-show="action == 'login'">{{ lang.login }} &nbsp;/&nbsp; <a href="javascript:" @click="action = 'register'">{{ lang.register }}</a></div>
				<div class="b-auth__title" v-show="action == 'register'">{{ lang.register }} &nbsp;/&nbsp; <a href="javascript:" @click="action = 'login'">{{ lang.login }}</a></div>
				<div class="b-auth__title" v-show="action == 'restore'">{{ lang.restore }}</div>
				<br/>
				<label class="i-label">
					<div class="i-label__title">{{ lang.email }}</div>
					<input type="email" class="i-inp i-inp_large i-label__inp i-w-1-1" required v-model="form.email"/>
				</label>
				<div v-if="action == 'register'">
					<label class="i-label">
						<div class="i-label__title">{{ lang.name }}</div>
						<input class="i-inp i-inp_large i-label__inp i-w-1-1" required v-model="form.name"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.lastname }}</div>
						<input class="i-inp i-inp_large i-label__inp i-w-1-1" required v-model="form.lastname"/>
					</label>
				</div>
				<label class="i-label" v-if="action != 'restore'">
					<div class="i-label__title">{{ lang.pass }}</div>
					<input type="password" class="i-inp i-inp_large i-label__inp i-w-1-1" required v-model="form.pass"/>
					<div style="color:gray; font-size:12px; margin:5px 0 0 0;" v-show="action == 'register'">{{ lang.pass_rules }}</div>
				</label>
				<div v-if="action == 'register'">
					<label class="i-label" v-for="(link, key) in App.site.links" v-if="link.in_regis == '1'">
						<input type="checkbox" v-model="form.rules[key]" required :true-value="1" :false-value="0"/>
						<span v-html="App.lang('your_accept', link.url, link.name)"></span>
					</label>
					<br/>
				</div>
				<recaptcha v-if="!form.captcha" v-model="form.captcha"></recaptcha>
				<br/>
				<ulogin v-if="action == 'register'" class="b-auth__soc" params="display=panel;theme=flat;fields=first_name,last_name,email;providers=google,facebook;hidden=;mobilebuttons=0;" @callback="fill"></ulogin>
				<button class="i-btn i-btn_large" v-text="action == 'register' ? lang.regis : (action == 'restore' ? lang.restore_min : lang.enter)"></button>
				<a href="javascript:" class="i-f-r i-mt10" @click="action = action == 'login' ? 'restore' : 'login'" v-show="action == 'login' || action == 'restore'" v-text="action == 'login' ? lang.restore : lang.login"></a>
			</form>
			<ul class="b-auth__lang">
				<li>
					<a href="javascript:" @click="App.getLang(App.site.langs.default)">{{ {ru: 'Русский', en: 'English', pt: 'Portuguese', jp: '日本語', fr: 'Français', ch: '中国', ko: '한국의', sp: 'Español', gr: 'Deutsch'}[App.site.langs.default] }}</a>
				</li>
				<li v-for="(v, k) in ({ru: 'Русский', en: 'English', pt: 'Portuguese', jp: '日本語', fr: 'Français', ch: '中国', ko: '한국의', sp: 'Español', gr: 'Deutsch'})" v-show="App.site.langs[k] == 1 && App.site.langs.default != k">
					<a href="javascript:" @click="App.getLang(k)">{{ v }}</a>
				</li>
			</ul>
		</div>
		<ul class="b-auth__footer">
			<li v-for="link in App.site.links"><a :href="link.url" target="_blank">{{ link.name }}</a></li>
		</ul>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('auth', {
			template: template,
			data: function() {
				var referral = location.search.match(/referral=(\d+:[a-z0-9]+)/i);
				var hash = location.hash.replace(/^#\/?/, '');
				
				return {
					form: {
						email: '',
						name: '',
						lastname: '',
						pass: '',
						captcha: '',
						referral: referral ? referral[1] : '',
						rules: {}
					},
					action: ['login', 'register', 'restore'].indexOf(hash) >= 0 ? hash : 'login'
				};
			},
			methods: {
				submit: function(event) {
					var self = this;
					App.api('auth.' + self.action, self.form, function(err, res) {
						self.form.captcha = '';
						if(err) return err;
						if(self.action == 'restore') {
							App.success(lang.instruction_send_to_mail);
							self.form = {email: '', pass: ''};
						}
						else App.checkAuth();
					});
					event.preventDefault();
				},
				fill: function(data) {
					this.form.email = data.email;
					this.form.name = data.first_name;
					this.form.lastname = data.last_name;
				}
			}
		});
	});
</script>