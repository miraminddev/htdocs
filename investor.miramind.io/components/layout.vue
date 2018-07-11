<template>
	<div class="b-lk" :class="{'b-lk-hide-nav': hide_nav}">
		<div class="b-lk__nav">
			<a href="/" class="b-lk__logo" :style="{backgroundImage: App.site.contact.logo ? 'url(' + App.site.contact.logo + ')' : ' '}"></a>
			<a href="/" class="b-lk__logo-box" :style="{backgroundImage: App.site.contact.logo_box ? 'url(' + App.site.contact.logo_box + ')' : ' '}"></a>
			<div class="b-toggle"><i class="fas fa-fw fa-bars" @click="changeNav()"></i></div>
			<ul class="b-nav">
				<li :class="{active: currentContent == 'purchase'}"><a href="#purchase"><i class="fas fa-fw fa-shopping-cart"></i> <span>{{ lang.purchase_tokens }}</span></a></li>
				<li :class="{active: currentContent == 'investments'}"><a href="#investments"><i class="fas fa-fw fa-briefcase"></i><span>{{ lang.my_invest }}</span></a></li>
				<li :class="{active: currentContent == 'referral'}" v-show="App.site.refferals.on == 1"><a href="#referral"><i class="fas fa-fw fa-globe"></i><span>{{ lang.referral_program }}</span></a></li>
				
			<li :class="{active: currentContent == 'kyc'}"><a href="#kyc"><i class="fas fa-fw fa-address-book"></i> <span :class="{msg: App.user.verify == 'refuted'}">{{ lang.kyc }}</span></a></li>
			
			
				<li :class="{active: currentContent == 'help'}"><a href="#help"><i class="fas fa-fw fa-question-circle"></i><span>{{ lang.help }}</span></a></li>
								
				<li :class="{active: currentContent == 'contacts'}"><a href="#contacts"><i class="fas fa-fw fa-phone-square"></i><span>{{ lang.contacts }}</span></a></li>
				<div class="b-nav__black" v-if="App.user.role == 'admin'">
					<li class="b-nav__separ"></li>
					<li :class="{active: currentContent == 'a-dashbord'}" :title="lang.only_admin"><a href="#a-dashbord"><i class="fas fa-fw fa-sliders-h"></i><span>{{ lang.dashbord }}</span></a></li>
					<li :class="{active: currentContent == 'a-managers'}" :title="lang.only_admin"><a href="#a-managers"><i class="fas fa-fw fa-briefcase"></i><span>{{ lang.managers }}</span></a></li>
					<li :class="{active: currentContent == 'a-users'}" :title="lang.only_manager"><a href="#a-users"><i class="fas fa-fw fa-users"></i><span>{{ lang.users }}</span></a></li>
					<li :class="{active: currentContent == 'a-payments'}" :title="lang.only_manager"><a href="#a-payments"><i class="fas fa-fw fa-shopping-cart"></i><span>{{ lang.payments }}</span></a></li>
					<li :class="{active: currentContent == 'a-settings'}" :title="lang.only_admin"><a href="#a-settings"><i class="fas fa-fw fa-cog"></i><span>{{ lang.settings }}</span></a></li>
					<li :class="{active: currentContent == 'a-lang'}" :title="lang.only_admin"><a href="#a-lang"><i class="fa-fw far fa-flag"></i><span>{{ lang.langs }}</span></a></li>
					<li :class="{active: currentContent == 'a-css'}" :title="lang.only_admin"><a href="#a-css"><i class="fa-fw fas fa-low-vision"></i><span>{{ lang.custom_css }}</span></a></li>
				</div>
			</ul>
			<div class="b-copyright">{{ App.site.contact.copyright }}</div>
		</div>
		<div class="b-lk__main">
			<ul class="b-header">
				<li><i class="fas fa-fw fa-gem"></i> {{ lang.your_tokens }}: <b>{{ (App.user_eth.tokens).toFixed(4) }} {{ App.site.contract.token_symbol }}</b></li>
				<li class="b-header__li_right">
					<a href="javascript:"><i class="fas fa-fw fa-user"></i> {{ App.user.email }}</a>
					<ul>
						<li><a href="#profile"><i class="fas fa-fw fa-cogs"></i> {{ lang.acc_settings }}</a></li>
						<li><a href="#kyc"><i class="fas fa-fw fa-address-book"></i> {{ lang.kyc }}</a></li>
						<li><a href="javascript:" @click="App.api('auth.logout', {}, function() { App.checkAuth(); })"><i class="fas fa-fw fa-sign-out-alt"></i> {{ lang.logout }}</a></li>
					</ul>
				</li>
				<li class="b-header__li_right" style="width:160px;">
					<a href="javascript:"><img :src="'/assets/flags/' + lang.symbol + '.svg'" width="20"/> {{ lang.lang }}</a>
					<ul>
						<li v-show="App.site.langs.ru == 1"><a href="javascript:" @click="App.getLang('ru')"><img src="/assets/flags/ru.svg" width="20"/> Русский</li>
						<li v-show="App.site.langs.en == 1"><a href="javascript:" @click="App.getLang('en')"><img src="/assets/flags/en.svg" width="20"/> English</li>
						<li v-show="App.site.langs.pt == 1"><a href="javascript:" @click="App.getLang('pt')"><img src="/assets/flags/pt.svg" width="20"/> Portuguese</li>
						<li v-show="App.site.langs.jp == 1"><a href="javascript:" @click="App.getLang('jp')"><img src="/assets/flags/jp.svg" width="20"/> 日本語</li>
						<li v-show="App.site.langs.fr == 1"><a href="javascript:" @click="App.getLang('fr')"><img src="/assets/flags/fr.svg" width="20"/> Français</li>
						<li v-show="App.site.langs.ch == 1"><a href="javascript:" @click="App.getLang('ch')"><img src="/assets/flags/ch.svg" width="20"/> 中国</li>
						<li v-show="App.site.langs.ko == 1"><a href="javascript:" @click="App.getLang('ko')"><img src="/assets/flags/ko.svg" width="20"/> 한국의</li>
						<li v-show="App.site.langs.sp == 1"><a href="javascript:" @click="App.getLang('sp')"><img src="/assets/flags/sp.svg" width="20"/> Español</li>
						<li v-show="App.site.langs.gr == 1"><a href="javascript:" @click="App.getLang('gr')"><img src="/assets/flags/gr.svg" width="20"/> Deutsch</li>
					</ul>
				</li>
				<li class="b-header__li_right">{{ App.user.role == 'admin' ? lang.admin : lang.user }}</li>
			</ul>
			<div class="b-lk__content">
				<div v-if="App.user.role == 'admin' && App.web3_status < 2" class="b-metamask">{{ lang.meta_mask_init }} <a href="https://metamask.io" target="_blank">metamask.io</a></div>


				<!-- <div v-if="lang.info_message" v-if="App.user.verify != 'yes'" class="b-inform" v-html="lang.info_message"></div> -->
				
				
				
				<component :is="currentContent"></component>
			</div>
			<ul class="b-footer">
				<li v-for="link in App.site.links"><a :href="link.url" target="_blank">{{ link.name }}</a></li>
			</ul>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('layout', {
			template: template,
			data: function() {
				return {
					currentContent: location.hash.replace(/^#\/?/, '') || 'purchase',
					hide_nav: /hide_nav=1/.test(document.cookie) ? true : false
				};
			},
			mounted: function() {
				var self = this;
				window.addEventListener('hashchange', function() {
					self.currentContent = location.hash.replace(/^#\/?/, '') || 'purchase';
				});
			},
			methods: {
				changeNav: function() {
					this.hide_nav = !this.hide_nav;
					document.cookie = 'hide_nav=' + (this.hide_nav ? 1 : 0) +'; Max-Age=2592000; path=/';
				}
			}
		});
	});
</script>