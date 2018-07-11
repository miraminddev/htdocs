<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.referral_program }}</h1>
		<div class="i-block i-flex">
			<div class="i-block__icon" style="background-image:url(/assets/users.png); width:200px;"></div>
			<div class="i-block__body i-w-1-1" v-html="App.site.refferals.text"></div>
		</div>
		<div class="i-block i-mt20">
			<div class="i-block__title">{{ lang.referal_link }}</div>
			<div class="i-block__body">
				<div class="i-flex i-flex__pad10">
					<input class="i-inp i-w-1-1" :value="App.user.referral_link" readonly id="referralLink"/>
					<button class="i-btn" @click="copyReferral()">{{ lang.copy_button }}</button>
				</div>
			</div>
		</div>
		<div class="i-block i-mt20">
			<div class="i-block__title">{{ lang.my_referrals }}</div>
			<div class="i-block__body">
				<table class="i-table i-w-1-1">
					<tr>
						<th>#</th>
						<th>{{ lang.registration_date }}</th>
						<th>{{ lang.fio }}</th>
						<th>E-mail</th>
					</tr>
					<tr v-for="user in users">
						<td v-text="user.id"></td>
						<td><small class="i-c-g" v-text="new Date(user.time_add * 1000).toLocaleDateString()"></small></td>
						<td v-text="user.name + ' ' + user.lastname"></td>
						<td v-text="user.email"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('referral', {
			template: template,
			data: function() {
				return {
					users: []
				};
			},
			mounted: function() {
				this.getReferrals();
			},
			methods: {
				getReferrals: function() {
					var self = this;
					App.api('user.getReferrals', function(err, res) {
						if(err) return err;
						self.users = res.users;
					});
				},
				copyReferral: function() {
					jQuery('#referralLink')[0].select();
					try {
						App.success(document.execCommand('copy') ? lang.link_copy : lang.link_copy_error);
					}
					catch (err) {
						App.error(lang.link_copy_error);
					}
				}
			}
		});
	});
</script>