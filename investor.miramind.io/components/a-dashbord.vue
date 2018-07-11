<template>
	<div class="b-lk__content-wrap" style="max-width:1000px">
		<button class="i-btn i-btn_red i-f-r" style="margin:10px 0 0 0;" @click="web3CrowdsaleTx([['983c0a01', 8]])">{{ lang.close_ICO_button }}</button>
		<h1>{{ lang.dashbord }}</h1>
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
		<div class="i-mt20 i-flex i-flex__pad10">
			<div style="width:60%">
				<div class="i-block">
					<div class="i-block__body" style="padding:25px 20px;">
						<div class="i-f-r" style="text-align:right;">
							<div style="text-transform:uppercase; color:#0390f4; font-size:13px; margin:4px 0 10px 0;">{{ lang.enter_new_rate }}</div>
							<input class="i-inp" v-model="App.site.prices.price_rate" size="5"/>
							<button class="i-btn" @click="App.api('site.setSettings', {data: App.site.prices, section: 'prices'})">{{ lang.ok }}</button>
						</div>
						<div style="text-transform:uppercase; color:#6d8793;">{{ lang.current_token_price }}</div>
						<div style="font-size:40px; color:#6d8793;">1<sup style="font-size:24px;">{{ App.site.contract.token_symbol }}</sup> = {{ (1 / App.site.prices.price_rate).toFixed(4) }}<sup style="font-size:24px;">{{ App.site.prices.price_currency.toUpperCase() }}</sup></div>
					</div>
				</div>
				<div class="i-block i-mt20">
					<div class="i-block__body" style="padding:25px 20px;">
						<div class="i-f-r" style="padding-top:36px;">
							<button class="i-btn" v-show="App.user_eth.contract_in_pause" @click="web3CrowdsaleTx([['3f4ba83a', 8]])">{{ lang.play }}</button>
							<button class="i-btn" v-show="!App.user_eth.contract_in_pause" @click="web3CrowdsaleTx([['8456cb59', 8]])">{{ lang.stop }}</button>
						</div>
						<div style="text-transform:uppercase; color:#6d8793;">{{ lang.ico_status }}</div>
						<div style="font-size:40px; color:#ddab14;"><img src="/assets/status/pause_orange.svg" width="36" style="position:relative; top:1px;"/>&nbsp;{{ App.user_eth.contract_in_pause ? lang.pause : lang.active }}</div>
					</div>
				</div>
				<div class="i-mt20">
					<h3>{{ lang.private_sale_tokens }}</h3>
					<form method="POST" action="" style="border:1px dashed rgba(0,0,0,0.15); padding:20px;" @submit.prevent="accrue()">
						<div class="i-label i-label_large" style="margin:0 10px 0 0;">
							<div class="i-f-r">
								<label><input type="radio" v-model="form.type" value="new"/> {{ lang.new }}</label>
								<label style="margin:0 10px 0 20px"><input type="radio" v-model="form.type" value="isset"/> {{ lang.user_id }}</label>
							</div>
							<div class="i-label__title">{{ form.type == 'new' ? lang.email : lang.user_id }}</div>
							<input class="i-inp i-label__inp i-inp_large i-w-1-1" v-model="form.user" required :pattern="form.type == 'new' ? '^.+@.+\..+$' : '^[0-9]+$'"/>
						</div>
						<br/>
						<div v-if="form.type == 'new'" class="i-label i-label_large" style="margin:0 10px 0 0;">
							<div class="i-label__title">{{ lang.wallet_adress }}</div>
							<input class="i-inp i-label__inp i-inp_large i-w-1-1" v-model="form.address" required pattern="^0x[a-fA-F0-9]{40}$"/>
						</div>
						<br v-if="form.type == 'new'"/>
						<div class="i-label i-label_large" style="margin:0 10px 0 0; max-width:650px;">
							<div class="i-label__title">{{ lang.currency }}</div>
							<div class="i-currency" v-for="c in ['usd', 'eur', 'rub', 'eth', 'btc', 'ltc', 'bch', 'btg', 'dash', 'etc']" :class="{active: currency == c}" @click="currency = c; form.to = (form.from * (rates[currency] / rates[App.site.contract.token_symbol.toLowerCase()])).toFixed(4)">
								<div class="i-currency__name">{{ c.toUpperCase() }}</div>
								<img class="i-currency__image" :src="'/assets/currencies/' + c + '.svg'" @mouseover="$event.target.src = '/assets/currencies/' + c + '.a.svg'" @mouseout="$event.target.src = '/assets/currencies/' + c + '.svg'"/>
								<div class="i-currency__price">{{ parseFloat(rates[c]).toFixed(4) }} $</div>
							</div>
						</div>
						<br/>
						<div style="display:flex; align-items:flex-end;">
							<label class="i-label i-label_large" style="margin:0 10px 0 0;">
								<div class="i-label__title">{{ lang.sum }}</div>
								<input class="i-inp i-label__inp i-inp_large" size="14" v-model="form.from" @input="form.to = (form.from * (rates[currency] / rates[App.site.contract.token_symbol.toLowerCase()])).toFixed(4)"/>
								<div class="i-label__badge">{{ currency.toUpperCase() }}</div>
							</label>
							<label class="i-label i-label_large" style="margin:0 10px 0 0;">
								<div class="i-label__title">{{ App.site.contract.token_symbol }}</div>
								<input class="i-inp i-label__inp i-inp_large" size="14" v-model="form.to" @input="form.from = (form.to / (rates[currency] / rates[App.site.contract.token_symbol.toLowerCase()])).toFixed(4)"/>
								<div class="i-label__badge">{{ App.site.contract.token_symbol }}</div>
							</label>
							<label class="i-label i-label_large" style="margin:0 10px 0 0;">
								<button class="i-btn i-btn_large">{{ lang.accrue }}</button>
							</label>
						</div>
					</form>
				</div>
			</div>
			<div class="i-block" style="width:40%; align-self:flex-start">
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
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('a-dashbord', {
			template: template,
			data: function() {
				return {
					form: {
						type: 'new',
						from: 1,
						to: 0,
						user: '',
						address: ''
					},
					rates: {},
					currency: 'usd',
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
				getCrowdsale: function(cb) {
			        if(App.web3_status >= 2) {
			        	(function() {
			        		if(App.site.contract.crowdsale_address != undefined) {
					        	// Interface of contract Crowdsale.externalPurchase
			        			cb(web3.eth.contract([{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_tx","type":"string"},{"name":"_currency","type":"string"},{"name":"_value","type":"uint256"},{"name":"_rate","type":"uint256"},{"name":"_tokens","type":"uint256"}],"name":"externalPurchase","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"}]).at(App.site.contract.crowdsale_address));
			        		}
			        		else setTimeout(arguments.callee, 100);
			        	})();
			        }
			        else App.error(lang.metamask_not_found);
				},
				accrue: function() {
					if(App.user_eth.contract_in_pause) return App.error(lang.buy_stop_message);

					var self = this;
					App.api('payments.createAdmin', {
						user: self.form.user,
						address: self.form.address,
						currency: self.currency,
						amount: self.form.from
					}, function(err, res) {
						if(err) return err;
						App.success(lang.data_save);

						var p = res.payment;
						if(confirm(App.lang('send_to_address_tokens', p.tokens, p.wallet_address))) {
							if(p.wallet_address && p.tokens > 0) {
								self.getCrowdsale(function(contract) {
									contract.externalPurchase(p.wallet_address, p.tx, p.currency, p.amount, p.course_pay, Math.round(p.tokens * 1e8), {}, function(err, res) {
										if(err) return App.error(err);
										p.time_accruals = 1;
										App.api('payments.accrueTokens', {
											id: p.id,
											amount: p.tokens
										});
									});
								});
							}
							else App.error(lang.wallet_not_found);
						}
					});
				},
				web3CrowdsaleTx: function(data, cb) {
			        if(typeof web3 !== 'undefined') {
						web3.eth.sendTransaction({
							to: App.site.contract.crowdsale_address, 
							data: '0x' + (data || []).map(function(v) {
								return v instanceof Array ? web3.padLeft(v[0].replace('0x', ''), v[1]) : web3.padLeft(v.replace('0x', ''), 64);
							}).join('')
						}, cb || function(err, res) {});
			        }
			        else App.error(lang.metamask_not_found);
				}
			}
		});
	});
</script>