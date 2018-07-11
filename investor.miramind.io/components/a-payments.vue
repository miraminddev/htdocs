<template>
	<div class="b-lk__content-wrap b-lk__content-wrap_large">
		<h1>{{ lang.payments }}</h1>
		<p v-if="CONST.DEBUG" style="background:orange; color:#fff; padding:10px 20px; margin:0 0 10px 0; font-weight:bold;">В тестовом режиме оплата платежей происходит через <a :href="'https://develop.smartcontract.ru/paybear/?domain=' + location.host" target="_blank" style="color:#fff;">тестовый шлюз</a>.</p>
		<div class="i-block">
			<div class="i-block__head">
				<form class="i-flex i-flex__pad10" action="" method="POST" @submit="$event.preventDefault(); getPayments()">
					<div>
						<input type="date" class="i-inp" v-model="filter.date_from"/> — <input type="date" class="i-inp" v-model="filter.date_to"/>
					</div>
					<input class="i-inp" style="flex-grow:1" :placeholder="lang.search" v-model="filter.search"/>
					<select class="i-inp" v-model="filter.status">
						<option value="">{{ lang.status }}</option>
						<option value="pay">{{ lang.pay }}</option>
						<option value="accrued">{{ lang.accrued }}</option>
						<option value="wait">{{ lang.wait }}</option>
					</select>
					<button class="i-btn">{{ lang.find }}</button>
					<a :href="'/api/payments.searchCsvCallback/?' + $.param(filter)" style="padding:6px;" :title="lang.export" target="_blank"><i class="fa fa-fw fa-download"></i></a>
				</form>
			</div>
			<div class="i-block__body" style="overflow:auto;">
				<table class="i-table i-w-1-1">
					<tr>
						<th>#</th>
						<th>{{ lang.date }}</th>
						<th>{{ lang.user }}</th>
						<th>{{ lang.sum }}</th>
						<th>{{ lang.rate }}</th>
						<th>{{ lang.tokens }}</th>
						<th>{{ lang.status }}</th>
						<th>{{ lang.verify }}</th>
						<th width="20"></th>
					</tr>
					<tr v-for="(payment, k) in payments">
						<td :style="{paddingLeft: payments[k + 1] && payment.invoice == payments[k + 1].invoice + '_ref' ? '30px' : '10px'}">
							<i v-show="payments[k + 1] && payment.invoice == payments[k + 1].invoice + '_ref'" style="color:#50b1db" class="fa fa-arrow-up"></i>
							<span v-text="payment.id"></span>
						</td>
						<td><small class="i-c-g" v-text="new Date(payment.time_add * 1000).toLocaleDateString()"></small></td>
						<td>
							<div v-text="payment.fio"></div>
							<div><small class="i-c-g" v-text="payment.email"></small></div>
						</td>
						<td v-text="(payment.amount - 0).toFixed(4) + ' ' + payment.currency.toUpperCase()"></td>
						<td v-text="(payment.course_add - 0).toFixed(2) + ' USD'"></td>
						<td v-text="(payment.tokens - 0).toFixed(4) + ' ' + App.site.contract.token_symbol"></td>
						<td>
							<i :style="{color: payment.status == 'wait' ? '#50b1db' : (payment.status == 'pay' ? '#ff8e18' : '#69c848')}" :class="{'far fa-clock': payment.status == 'wait', 'fa fa-shopping-cart': payment.status == 'pay', 'fa fa-check': payment.status == 'accrued'}"></i>
							<small v-text="lang[payment.status]"></small>
						</td>
						<td>
							<i class="fa-fw" :style="{color: payment.verify == 'proccess' ? '#50b1db' : (payment.verify == 'yes' ? '#69c848' : (payment.verify == 'refuted' ? '#ff8e18' : '#f00'))}" :class="{'far fa-clock': payment.verify == 'proccess', 'fa fa-check': payment.verify == 'yes', 'fa fa-ban': payment.verify == 'refuted', 'fa fa-times': payment.verify == 'no'}"></i>
							<small v-text="lang[payment.verify]"></small>
						</td>
						<td><button class="i-btn i-btn_small" v-show="payment.time_pay > 0 && payment.time_accruals < 1" @click="accrueTokens(payment)">{{ lang.accrue_tokens }}</button></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('a-payments', {
			template: template,
			data: function() {
				return {
					filter: {
						date_from: '',
						date_to: '',
						search: '',
						status: ''
					},
					payments: []
				};
			},
			mounted: function() {
				this.getPayments();
			},
			methods: {
				getPayments: function() {
					var self = this;
					App.api('payments.search', self.filter, function(err, res) {
						if(err) return err;
						self.payments = res.payments;
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
				accrueTokens: function(payment) {
					var self = this;
					if(payment.wallet_address) {
						self.getCrowdsale(function(contract) {
							var amount = parseFloat(prompt(lang.amount_tokens_sending, payment.tokens));
							if(amount > 0) {
								contract.externalPurchase(payment.wallet_address, payment.tx, payment.currency, payment.amount, payment.course_pay, Math.round(amount * 1e8), {}, function(err, res) {
									if(err) return App.error(err);
									payment.time_accruals = 1;
									App.api('payments.accrueTokens', {
										id: payment.id,
										amount: amount
									});
								});
							}
						});
					}
					else App.error(lang.wallet_not_found);
				}
			}
		});
	});
</script>