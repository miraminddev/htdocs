<template>
	<div class="b-lk__content-wrap b-lk__content-wrap_large">
		<h1>{{ lang.settings }}</h1>
		<div class="i-block">
			<div class="i-block__body">
				<ul class="i-tabs">
					<li class="i-tabs__item" :class="{active: tab == 'contact'}" @click="tab = 'contact'">{{ lang.common }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'links'}" @click="tab = 'links'">{{ lang.links }} <i class="far fa-flag" :title="lang.setting_by_all_langs"></i></li>
					<li class="i-tabs__item" :class="{active: tab == 'social'}" @click="tab = 'social'">{{ lang.social_net }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'prices'}" @click="tab = 'prices'">{{ lang.prices }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'notices'}" @click="tab = 'notices'">{{ lang.notifications }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'refferals'}" @click="tab = 'refferals'">{{ lang.ref_program }} <i class="far fa-flag" :title="lang.setting_by_all_langs"></i></li>
					<li class="i-tabs__item" :class="{active: tab == 'help'}" @click="tab = 'help'">{{ lang.help }} <i class="far fa-flag" :title="lang.setting_by_all_langs"></i></li>
					<li class="i-tabs__item" :class="{active: tab == 'ico_steps'}" @click="tab = 'ico_steps'">{{ lang.ico_steps }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'contract'}" @click="tab = 'contract'">{{ lang.contract }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'langs'}" @click="tab = 'langs'">{{ lang.langs }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'country_access'}" @click="tab = 'country_access'">{{ lang.country_access }}</li>
					<li class="i-tabs__item"><a href="/api/site.exportConfigCallback/" target="_blank" :title="lang.export"><i class="fa fa-download"></i></a></li>
				</ul>

				<form method="POST" action="" @submit="setSettings($event, 'contact')" class="i-block__body" v-if="tab == 'contact'">
					<label class="i-label">
						<div class="i-label__title">E-mail</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.contact.email" required pattern=".+@.+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.tel_number }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.contact.phone" pattern=".+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.copyright }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.contact.copyright" pattern=".+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.site_title }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.contact.title" pattern=".+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.logo }} (230х90)</div>
						<input class="i-inp i-label__inp" size="38" v-model="settings.contact.logo"/>
						<button class="i-btn i-btn_white" style="margin-left:-5px;" @click.prevent="App.upload(function(res) { settings.contact.logo = res.url; }, 'image/*')" :title="lang.upload_file"><i class="fa fa-download"></i></button>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.logo }} (90х90)</div>
						<input class="i-inp i-label__inp" size="38" v-model="settings.contact.logo_box"/>
						<button class="i-btn i-btn_white" style="margin-left:-5px;" @click.prevent="App.upload(function(res) { settings.contact.logo_box = res.url; }, 'image/*')" :title="lang.upload_file"><i class="fa fa-download"></i></button>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.counters }} (Yandex.Metrika, Google Analytics..)</div>
						<textarea class="i-inp i-label__inp" style="width:410px;" v-model="settings.contact.counters"></textarea>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<div class="i-block__body" v-if="tab == 'links'">
					<div class="i-flex i-flex__pad10" v-for="(link, key) in settings.links">
						<label class="i-label">
							<div class="i-label__title">{{ lang.title }}</div>
							<input class="i-inp i-label__inp" size="28" v-model="link.name"/>
							<div><input type="checkbox" v-model="link.in_regis" :true-value="1" :false-value="0"/> {{ lang.show_in_regis }}</div>
						</label>
						<label class="i-label">
							<div class="i-label__title">{{ lang.link }}</div>
							<input class="i-inp i-label__inp" size="28" v-model="link.url"/>
							<button class="i-btn" style="margin-left:-4px;" @click="App.upload(function(res) { link.url = res.url; }, '*', false, link.name)" :title="lang.upload_file"><i class="fa fa-download"></i></button>
						</label>
						<label class="i-label">
							<div class="i-label__title">&nbsp;</div>
							<button class="i-label__inp i-btn" @click="settings.links.splice(key, 1)" :title="lang.delete"><i class="fa fa-trash"></i></button>
						</label>
					</div>
					<a href="javascript:" @click="settings.links.push({})">{{ lang.add_link }}</a>
					<br/><br/>
					<button class="i-btn" @click="setSettings($event, 'links')">{{ lang.save_button }}</button>
				</div>

				<form method="POST" action="" @submit="setSettings($event, 'social')" class="i-block__body" v-if="tab == 'social'">
					<label class="i-label">
						<div class="i-label__title">Facebook</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.facebook" pattern=".+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">Twitter</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.twitter" pattern=".+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">Instagram</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.instagram" pattern=".+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">YouTube</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.youtube" pattern=".+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">Telegram</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.telegram" pattern=".+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">GitHub</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.github" pattern=".+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">Bitcointalk</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.bitcointalk" pattern=".+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">Reddit</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.reddit" pattern=".+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">Medium</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.social.medium" pattern=".+\..+"/>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<form method="POST" action="" @submit="setSettings($event, 'prices')" class="i-block__body" v-if="tab == 'prices'">
					<div class="i-label">
						<div class="i-label__title">{{ lang.token_rate }}</div>
						<select class="i-inp i-label__inp" v-model="settings.prices.price_currency">
							<option v-for="c in ['eth', 'btc', 'bch', 'btg', 'ltc', 'dash', 'etc', 'usd', 'eur', 'rub']" :value="c">1 {{ c.toUpperCase() }}</option>
						</select>
						&nbsp; = &nbsp;
						<input class="i-inp i-label__inp" size="8" v-model="settings.prices.price_rate"/>
						{{ App.site.contract.token_symbol }}
					</div>
					<label class="i-label">
						<div class="i-label__title">{{ lang.min_buy_tokens_amount }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.prices.min_amount_tokens"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.bonus }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.prices.bonus_percent"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.collected_percent }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.prices.collected_percent"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.fees_usd }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.prices.fees_usd"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.date_end_ico }}</div>
						<input class="i-inp i-label__inp" type="datetime-local" size="45" v-model="settings.prices.date_end"/>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<form method="POST" action="" @submit="setSettings($event, 'notices')" class="i-block__body" v-if="tab == 'notices'">
					<label class="i-label">
						<div class="i-label__title">{{ lang.email_contact }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.notices.feedback" required pattern=".+@.+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.email_error }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.notices.errors" required pattern=".+@.+\..+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.email_from_user }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.notices.from" required pattern=".+@.+\..+"/>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<form method="POST" action="" @submit="setSettings($event, 'refferals')" class="i-block__body" v-if="tab == 'refferals'">
					<label class="i-label">
						<input type="checkbox" v-model="settings.refferals.on" :true-value="1" :false-value="0"/>
						<span class="i-label__title">{{ lang.referral_program_on }}</span>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.bonus }}</div>
						<input class="i-inp i-label__inp" size="10" v-model="settings.refferals.bonus" :disabled="settings.refferals.on != 1" required pattern="[0-9]+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.referral_text }}</div>
						<textarea class="i-inp i-label__inp i-w-1-1" :disabled="settings.refferals.on != 1" size="10" v-model="settings.refferals.text"></textarea>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<div class="i-block__body" v-if="tab == 'help'">
					<div v-for="(q, key) in settings.help">
						<label class="i-label">
							<div class="i-label__title">{{ lang.question }}</div>
							<input class="i-inp i-label__inp" size="120" v-model="q.title"/>
							<button class="i-label__inp i-btn" @click="settings.help.splice(key, 1)" :title="lang.delete"><i class="fa fa-trash"></i></button>
						</label>
						<label class="i-label">
							<div class="i-label__title">{{ lang.answer }}</div>
							<textarea class="i-inp i-label__inp i-w-1-1" size="5" v-model="q.text"></textarea>
						</label>
						<label class="i-label">
							<div class="i-label__title">&nbsp;</div>
						</label>
					</div>
					<a href="javascript:" @click="settings.help.push({})">{{ lang.add_question }}</a>
					<br/><br/>
					<button class="i-btn" @click="setSettings($event, 'help')">{{ lang.save_button }}</button>
				</div>

				<div class="i-block__body" v-if="tab == 'ico_steps'">
					<div class="i-flex i-flex__pad10" v-for="(ico, key) in settings.ico_steps">
						<label class="i-label">
							<div class="i-label__title">{{ lang.title }}</div>
							<input class="i-inp i-label__inp" size="28" v-model="ico.name"/>
						</label>
						<label class="i-label">
							<div class="i-label__title">{{ lang.cap }}</div>
							<input class="i-inp i-label__inp" size="28" v-model="ico.cap"/>
						</label>
						<label class="i-label">
							<div class="i-label__title">{{ lang.fees }}</div>
							<input class="i-inp i-label__inp" size="28" v-model="ico.fees"/>
						</label>
						<label class="i-label">
							<div class="i-label__title">{{ lang.status }}</div>
							<select class="i-inp i-label__inp" v-model="ico.status">
								<option value="await">{{ lang.ico_status_wait }}</option>
								<option value="pause">{{ lang.ico_status_pause }}</option>
								<option value="active">{{ lang.ico_status_active }}</option>
								<option value="finish">{{ lang.ico_status_stop }}</option>
							</select>
						</label>
						<label class="i-label">
							<div class="i-label__title">&nbsp;</div>
							<button class="i-label__inp i-btn" @click="settings.ico_steps.splice(key, 1)" :title="lang.delete"><i class="fa fa-trash"></i></button>
						</label>
					</div>
					<a href="javascript:" v-show="settings.ico_steps.length < 5" @click="settings.ico_steps.push({name: 'ICO', cap: '0', fees: '0', status: 'active'})">{{ lang.add_step }}</a>
					<br/><br/>
					<button class="i-btn" @click="setSettings($event, 'ico_steps')">{{ lang.save_button }}</button>
				</div>

				<form method="POST" action="" @submit="setSettings($event, 'contract')" class="i-block__body" v-if="tab == 'contract'">
					<label class="i-label">
						<div class="i-label__title">{{ lang.token_name }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.contract.token_name" required pattern=".+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.token_symbol }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.contract.token_symbol" required pattern=".+"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.token_adress }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.contract.token_address" required pattern="^0x[a-fA-F0-9]{40}$"/>
						&nbsp; <a target="_blank" :href="'http://etherscan.io/address/' + settings.contract.token_address"><i class="fa fa-link"></i> Etherscan.io</a>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.crowdsale_adress }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="settings.contract.crowdsale_address" required pattern="^0x[a-fA-F0-9]{40}$"/>
						&nbsp; <a target="_blank" :href="'http://etherscan.io/address/' + settings.contract.crowdsale_address"><i class="fa fa-link"></i> Etherscan.io</a>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<form method="POST" action="" @submit="setSettings($event, 'langs')" class="i-block__body" v-if="tab == 'langs'">
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.ru" :true-value="1" :false-value="0"/>
						<span class="i-label__title">Русский</span>
						(<input type="radio" v-model="settings.langs.default" value="ru"/> {{ lang.default }})
					</label>
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.en" :true-value="1" :false-value="0"/>
						<span class="i-label__title">English</span>
						(<input type="radio" v-model="settings.langs.default" value="en"/> {{ lang.default }})
					</label>
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.pt" :true-value="1" :false-value="0"/>
						<span class="i-label__title">Portuguese</span>
						(<input type="radio" v-model="settings.langs.default" value="pt"/> {{ lang.default }})
					</label>
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.jp" :true-value="1" :false-value="0"/>
						<span class="i-label__title">日本語</span>
						(<input type="radio" v-model="settings.langs.default" value="jp"/> {{ lang.default }})
					</label>
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.fr" :true-value="1" :false-value="0"/>
						<span class="i-label__title">Français</span>
						(<input type="radio" v-model="settings.langs.default" value="fr"/> {{ lang.default }})
					</label>
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.ch" :true-value="1" :false-value="0"/>
						<span class="i-label__title">Chinese</span>
						(<input type="radio" v-model="settings.langs.default" value="ch"/> {{ lang.default }})
					</label>
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.ko" :true-value="1" :false-value="0"/>
						<span class="i-label__title">Korean</span>
						(<input type="radio" v-model="settings.langs.default" value="ko"/> {{ lang.default }})
					</label>
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.sp" :true-value="1" :false-value="0"/>
						<span class="i-label__title">Español</span>
						(<input type="radio" v-model="settings.langs.default" value="sp"/> {{ lang.default }})
					</label>
					<label class="i-label">
						<input type="checkbox" v-model="settings.langs.gr" :true-value="1" :false-value="0"/>
						<span class="i-label__title">Deutsch</span>
						(<input type="radio" v-model="settings.langs.default" value="gr"/> {{ lang.default }})
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<form method="POST" action="" @submit="setSettings($event, 'country_access')" class="i-block__body" v-if="tab == 'country_access'">
					<label class="i-label">
						<input type="checkbox" v-model="settings.country_access.on" :true-value="1" :false-value="0"/>
						<span class="i-label__title">{{ lang.country_access_on }}</span>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.countries_codes }}</div>
						<input class="i-inp i-label__inp" size="10" v-model="settings.country_access.codes" :disabled="settings.country_access.on != 1" placeholder="US CH SG"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.countries_message }}</div>
						<textarea class="i-inp i-label__inp i-w-1-1" :disabled="settings.country_access.on != 1" size="10" v-model="settings.country_access.message"></textarea>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('a-settings', {
			template: template,
			data: function() {
				return {
					tab: 'contact',
					settings: {
						links: [],
						ico_steps: [],
						contact: {},
						contract: {},
						notices: {},
						social: {},
						refferals: {},
						prices: {},
						help: [],
						langs: {}
					}
				};
			},
			mounted: function() {
				this.getSettings();
			},
			methods: {
				getSettings: function() {
					var self = this;
					App.api('site.get', {}, function(err, res) {
						if(err) return err;
						self.settings = res.site;
					});
				},
				setSettings: function(event, section) {
					var self = this;
					App.api('site.setSettings', {data: self.settings[section], section: section}, function(err, res) {
						if(err) return err;
						App.success(lang.data_save);
						App.api('site.get', function(err, res) {
							App.site = (res || {}).site || {};
						});
					});
					event.preventDefault();
				}
			}
		});
	});
</script>