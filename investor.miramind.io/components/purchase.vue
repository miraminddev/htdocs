<template>
	<div class="b-lk__content-wrap" style="max-width:1000px">
		<h1>{{ lang.purchase_tokens }}</h1>
		<div class="b-steps">
			<div class="b-steps__title">{{ lang.steps }}<span>ICO</span></div>
			<div class="b-steps__list">
				<div class="b-steps__step" :class="step.status" v-for="(step, key) in App.site.ico_steps">
					<div class="b-steps__step-number">{{ key + 1}}</div>
					<div class="b-steps__step-status"></div>
					<div class="b-steps__step-title">{{ step.name }}</div>
					<div class="b-steps__step-subtitle">{{ lang[step.status] }} {{ step.fees }}</div>
				</div>
			</div>
		</div>
		<div class="i-mt20 i-flex">
			<div style="flex-grow:1">
				<div class="b-price">
					<div class="b-price__title">{{ lang.token_price }}</div>
					<div class="b-price__wrap">
						<div class="b-price__left">
							<div class="b-price__value">1<sup> {{ App.site.contract.token_symbol }}</sup> = {{ (1 / App.site.prices.price_rate).toFixed(4) }}<sup> {{ App.site.prices.price_currency }}</sup></div>
						</div>
						<div class="b-price__right" v-show="App.site.prices.bonus_percent">
							<div class="b-price__gift"></div>
							<div class="b-price__sale">{{ lang.sale }} {{ App.site.prices.bonus_percent }}%</div>
						</div>
					</div>
				</div>
				<div class="i-mt20">
					<div class="i-label i-label_large" style="margin:0 10px 0 0;">
						<div class="i-label__title">{{ lang.currency }}
							<span style="margin:0 15px 0 0; font-size:12px;" class="i-f-r">{{ App.lang('purchase_tokens_refresh', rates_update.time) }}</span>
						</div>
						
						<!-- 'eth', 'btc', 'ltc', 'bch', 'btg', 'dash' -->
						
						<div class="i-currency" v-for="c in ['eth']" :class="{active: currency == c}" @click="currency = c; form.to = (form.from * (rates[currency] / rates[App.site.contract.token_symbol.toLowerCase()])).toFixed(4)">
							<div class="i-currency__name">{{ c.toUpperCase() }}</div>
							<img class="i-currency__image" :src="'/assets/currencies/' + c + '.svg'" @mouseover="$event.target.src = '/assets/currencies/' + c + '.a.svg'" @mouseout="$event.target.src = '/assets/currencies/' + c + '.svg'"/>
							<div class="i-currency__price">{{ parseFloat(rates[c]).toFixed(4) }} $</div>
						</div>
					</div>
					<br/>
					<div style="display:flex; align-items:flex-end;">
						<label class="i-label i-label_large" style="margin:0 10px 0 0;">
							<div class="i-label__title">{{ lang.sum }}</div>
							<input class="i-inp i-label__inp i-inp_large" type="number" step="1" min="0.1" size="20" v-model="form.from" @input="form.to = (form.from * (rates[currency] / rates[App.site.contract.token_symbol.toLowerCase()])).toFixed(4)"/>
							<div class="i-label__badge">{{ currency.toUpperCase() }}</div>
						</label>
						<label class="i-label i-label_large" style="margin:0 10px 0 0;">
							<div class="i-label__title">{{ App.site.contract.token_symbol }}</div>
							<input class="i-inp i-label__inp i-inp_large" type="number" step="1" min="0.1" size="20" v-model="form.to" @input="form.from = (form.to / (rates[currency] / rates[App.site.contract.token_symbol.toLowerCase()])).toFixed(4)"/>
							<div class="i-label__badge">{{ App.site.contract.token_symbol }}</div>
						</label>
						<label class="i-label i-label_large" style="margin:0 10px 0 0;">
							<button class="i-btn i-btn_large" @click="buy()" :disabled="App.site.prices.min_amount_tokens > 0 && App.site.prices.min_amount_tokens > form.to">{{ lang.buy }}</button>
						</label>
					</div>
				</div>
				<br/>
				<p style="color:grey;"><small>1 {{ currency.toUpperCase() }} = {{ (rates[currency] / rates[App.site.contract.token_symbol.toLowerCase()]).toFixed(4) }} {{ App.site.contract.token_symbol }}</small></p>
				<br/><br/>
			</div>
			<div class="i-block" style="width:312px; align-self:flex-start">
				<div class="i-block__body">
					<div class="b-spider">
						<div class="b-spider__title">{{ App.lang('ICO_fees', App.site.ico_steps.filter(v => v.status == 'active')[0].name) }}</div>
						<div class="b-spider__wrap">
							<div class="b-spider__line" :style="{transform: 'rotate(' + (((App.site.prices.collected_percent > 0 ? parseFloat(App.site.prices.collected_percent) : (App.site.prices.collected_value / App.site.prices.fees_usd * 100)) - 50) * 3) + 'deg) translate(0,-1.7em)'}"></div>
						</div>
						<div class="b-spider__value">USD {{ (App.site.prices.collected_percent > 0 ? (parseFloat(App.site.prices.fees_usd) / 100 * parseFloat(App.site.prices.collected_percent)) : App.site.prices.collected_value).toLocaleString() }}</div>
					</div>
					<div class="b-timer">
						<div class="b-timer__title">{{ App.lang('time_to_end_ico', App.site.ico_steps.filter(v => v.status == 'active')[0].name) }}</div>
						<div class="b-timer__wrap">
							<div class="b-timer__sect"><div>{{ timer.days }}</div><span>{{ lang.days }}</span></div> :
							<div class="b-timer__sect"><div>{{ timer.hours }}</div><span>{{ lang.hours }}</span></div> :
							<div class="b-timer__sect"><div>{{ timer.mins }}</div><span>{{ lang.mins }}</span></div> :
							<div class="b-timer__sect"><div>{{ timer.secs }}</div><span>{{ lang.secs }}</span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="b-paytx" v-show="show_pay" @click="show_pay = false">
			<div class="b-paytx__wrap" @click="$event.stopPropagation()">
				<div class="b-paytx__head">
					<b>{{ lang.waiting_payment }}</b><br/><span>{{ lang.rate_locked }} 1 {{ currency.toUpperCase() }}: {{ (rates[currency] / rates[App.site.contract.token_symbol.toLowerCase()]).toFixed(4) }} {{ App.site.contract.token_symbol }}</span>
				</div>
				<div class="b-paytx__body">
					<div class="b-paytx__title"><img class="i-currency__image" :src="'/assets/currencies/' + currency.toLowerCase() + '.svg'"/> {{ App.lang('pay_message', form.to + ' ' + App.site.contract.token_symbol, form.from + ' ' + currency.toUpperCase()) }}</div>
					<div class="b-paytx__sub-title">{{ App.lang('please_send_to_address', form.from + ' ' + currency.toUpperCase()) }}</div>
					<div class="b-paytx__address">{{ pay_address }}</div>
					<img  class="b-paytx__qr" :src="'https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=' + pay_address"/>
					<div class="b-paytx__tools">
						<button class="i-btn i-btn_large" @click="copy(pay_address)">{{ pay_address.replace(/^(.{6}).+/, '$1') }}...<span>{{ lang.copy_address }}</span></button>
						<button class="i-btn i-btn_large" @click="copy(form.from)">{{ form.from }}<span>{{ lang.copy_amount }}</span></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('purchase', {
			template: template,
			data: function() {
				return {
					form: {
						from: 1,
						to: 0
					},
					rates: {},
					currency: 'eth',
					pay_address: '',
					show_pay: false,
					rates_update: {
						timer: null,
						time: 60
					},
					timer: {
						id: 0,
						days: 0,
						hours: 0,
						mins: 0,
						secs: 0
					}
				};
			},
			mounted: function() {
				var self = this;
				self.getRates();

				self.rates_update.timer = setInterval(function() {
					if(self.rates_update.time <= 0) {
						self.rates_update.time = 60;
						self.getRates();
					}
					self.rates_update.time--;
				}, 1000);

				var time_last = new Date(App.site.prices.date_end);
				self.timer.id = setInterval(function() {
					var n = (time_last - (new Date()).getTime()) / 1000,
						c = function(v) { return Math.floor(v) > 0 ? Math.floor(v) : 0; },
						p = function(v) { return v >= 10 ? v : '0' + v; };
					self.timer.days = c(n / 86400);
					self.timer.hours = p(c((n % 86400) / 3600));
					self.timer.mins = p(c((n % 86400 % 3600) / 60));
					self.timer.secs = p(c(n % 86400 % 360 % 60));
				}, 1000);
			},
			destroyed: function() {
				clearInterval(this.rates_update.timer);
				clearInterval(this.timer.id);
			},
			methods: {
				getRates: function() {
					var self = this;
					App.api('payments.getRates', function(err, res) {
						if(err) return err;
						self.rates = res.rates;
						self.form.to = (self.form.from * (self.rates[self.currency] / self.rates[App.site.contract.token_symbol.toLowerCase()])).toFixed(4);
					});
				},
				buy: function() {
					if(App.user_eth.contract_in_pause) return App.error(lang.buy_stop_message);

					var self = this;
					App.api('payments.create', {currency: self.currency, amount: self.form.from}, function(err, res) {
						if(err) return err;
						self.show_pay = true;
						self.pay_address = res.address;
					});
				},
				copy: function(value) {
					var s = jQuery('<input/>', {value: value}).appendTo('body');
					s[0].select();
					try {
						App.success(document.execCommand('copy') ? lang.link_copy : lang.link_copy_error);
					}
					catch (err) {
						App.error(lang.link_copy_error);
					}
					s.remove();
				}
			}
		});
	});
</script>