<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.profile }}</h1>
		<div class="i-block">
			<div class="i-block__body">
				<ul class="i-tabs">
					<li class="i-tabs__item" :class="{active: tab == 'user'}" @click="tab = 'user'">{{ lang.my_information }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'pass'}" @click="tab = 'pass'">{{ lang.pass }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'sessions'}" @click="tab = 'sessions'">{{ lang.my_sessions }}</li>
				</ul>
				
				<form method="POST" action="" @submit.prevent="setUser('name|lastname|wallet_address'.split('|'))" class="i-block__body" v-show="tab == 'user'">
					<small class="i-f-r i-c-g">ID {{ App.user.id }}</small>
					<label class="i-label">
						<div class="i-label__title">E-mail</div>
						<input class="i-inp i-label__inp" size="45" disabled v-model="user.email"/>
					</label>
					<div class="i-separ"></div>
					<label class="i-label">
						<div class="i-label__title">{{ lang.name }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.name" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.lastname }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.lastname" required/>
					</label>
					<div class="i-separ"></div>
					<label class="i-label">
						<div class="i-label__title">{{ lang.my_invest_adress }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.wallet_address" placeholder="0x0000000000000000000000000000000000000000" required pattern="^0x[a-fA-F0-9]{40}$"/>
						<a href="javascript:" style="margin:0 0 0 10px;" @click="user.wallet_address = web3.eth.coinbase" v-show="App.web3_status > 1">{{ lang.from_metamask }}</a>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<form method="POST" action="" @submit.prevent="setPass()" class="i-block__body" v-show="tab == 'pass'">
					<label class="i-label" v-if="App.user.pass">
						<div class="i-label__title">{{ lang.old_pass }}</div>
						<input class="i-inp i-label__inp" type="password" size="45" v-model="pass.pass" required pattern=".{8,}"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.new_pass }}</div>
						<input class="i-inp i-label__inp" type="password" size="45" v-model="pass.new_pass" required pattern=".{8,}"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.repeat_pass }}</div>
						<input class="i-inp i-label__inp" type="password" size="45" v-model="pass.new_pass2" required pattern=".{8,}"/>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<div class="i-block__body" v-show="tab == 'sessions'" style="overflow:auto;">
					<table class="i-table i-w-1-1">
						<tr>
							<th>#</th>
							<th>{{ lang.date }}</th>
							<th>{{ lang.ip }}</th>
							<th>{{ lang.user_agent }}</th>
						</tr>
						<tr v-for="session in sessions">
							<td v-text="session.id"></td>
							<td><small class="i-c-g" v-text="new Date(session.time_add * 1000).toLocaleDateString()"></small></td>
							<td v-text="session.ip"></td>
							<td v-text="session.agent"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('profile', {
			template: template,
			data: function() {
				return {
					tab: 'user',
					user: {
						email: '',
						name: '',
						lastname: '',
						wallet_address: '',
					},
					pass: {
						pass: '',
						new_pass: '',
						new_pass2: ''
					},
					sessions: []
				};
			},
			mounted: function() {
				this.getUser();
				this.getSessions();
			},
			methods: {
				getUser: function() {
					var self = this;
					App.api('user.getChunk', {fields: Object.keys(self.user)}, function(err, res) {
						if(err) return err;
						self.user = res.user;
					});
				},
				setUser: function(fields) {
					App.api('user.setChunk', {fields: fields, data: this.user}, function(err, res) {
						if(err) return err;
						App.success(lang.data_save);
					});
				},
				setPass: function() {
					var self = this;
					if(self.pass.new_pass != self.pass.new_pass2) return App.error(lang.pass_not_equals);
					App.api('user.changePass', self.pass, function(err, res) {
						if(err) return err;
						App.success(lang.pass_changed);
					});
				},
				getSessions: function() {
					var self = this;
					App.api('user.getSessions', function(err, res) {
						if(err) return err;
						self.sessions = res.sessions;
					});
				},
			}
		});
	});
</script>