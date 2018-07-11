<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.my_invest }}</h1>
		<div class="i-block i-flex">
			<div class="i-block__icon" style="background-image:url(/assets/wallet.png); height:150px; width:200px;">{{ lang.my_wallet }}</div>
			<div class="i-block__body i-w-1-1">
				<div class="i-c-g">{{ lang.my_invest_adress }}:</div>
				<div><big class="i-c-b">{{ App.user_eth.address }}</big></div>
				<br/>
				<div class="i-c-g">{{ lang.balance }}: </div>
				<div><big>{{ (App.user_eth.tokens).toFixed(4) }} {{ App.site.contract.token_symbol }}</big></div>
			</div>
		</div>
		<div class="i-block i-mt20">
			<div class="i-block__title">{{ lang.my_invest_transactions }}</div>
			<div class="i-block__body">
				<table class="i-table i-w-1-1">
					<tr>
						<th>{{ lang.date }}</th>
						<th>{{ lang.sum }}</th>
						<th>{{ lang.rate }}</th>
						<th>{{ lang.tokens }}</th>
						<th>{{ lang.status }}</th>
					</tr>
					<tr v-for="payment in payments">
						<td><small class="i-c-g" v-text="new Date(payment.time_add * 1000).toLocaleDateString()"></small></td>
						<td v-text="(payment.amount - 0).toFixed(4) + ' ' + payment.currency.toUpperCase()"></td>
						<td v-text="(payment.course_add - 0).toFixed(2) + ' USD'"></td>
						<td v-text="(payment.tokens - 0).toFixed(4) + ' ' + App.site.contract.token_symbol"></td>
						<td>
							<i :style="{color: payment.status == 'wait' ? '#50b1db' : (payment.status == 'pay' ? '#ff8e18' : '#69c848')}" :class="{'far fa-clock': payment.status == 'wait', 'fa fa-shopping-cart': payment.status == 'pay', 'fa fa-check': payment.status == 'accrued'}"></i>
							<small v-text="lang[payment.status]"></small>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('investments', {
			template: template,
			data: function() {
				return {
					//address: '0x0000000000000000000000000000000000000000',
					//balance: 0,
					payments: []
				};
			},
			mounted: function() {
				var self = this;
				self.getPayments();
				/*
	        	if(App.web3_status > 1) {
		        	self.address = web3.eth.coinbase;
		        	web3.eth.getBalance(self.address, function(err, res) {
		        		self.balance = res / 1e18;
		        	});
	        	}
	        	*/
			},
			methods: {
				getPayments: function() {
					var self = this;
					App.api('payments.get', {}, function(err, res) {
						if(err) return err;
						self.payments = res.payments;
					});
				}
			}
		});
	});
</script>