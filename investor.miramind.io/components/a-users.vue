<template>
	<div class="b-lk__content-wrap b-lk__content-wrap_large">
		<h1>{{ lang.users }}</h1>
		<div class="i-block">
			<div class="i-block__head">
				<form class="i-flex i-flex__pad10" action="" method="POST" @submit="$event.preventDefault(); getUsers()">
					<div>
						<input type="date" class="i-inp" v-model="filter.date_from"/> — <input type="date" class="i-inp" v-model="filter.date_to"/>
					</div>
					<input class="i-inp" style="flex-grow:1" :placeholder="lang.search" v-model="filter.search"/>
					<select class="i-inp" v-model="filter.role">
						<option value="">{{ lang.role }}</option>
						<option value="user">{{ lang.user }}</option>
						<option value="admin">{{ lang.admin }}</option>
					</select>
					<select class="i-inp" v-model="filter.verify">
						<option value="">{{ lang.verify }}</option>
						<option value="no">{{ lang.no }}</option>
						<option value="refuted">{{ lang.refuted }}</option>
						<option value="proccess" disabled>{{ lang.proccess }}</option>
						<option value="yes">{{ lang.yes }}</option>
					</select>
					<button class="i-btn">{{ lang.find }}</button>
					<a :href="'/api/user.searchCsvCallback/?' + $.param(filter)" style="padding:6px;" :title="lang.export" target="_blank"><i class="fa fa-fw fa-download"></i></a>
				</form>
			</div>
			<div class="i-block__body" style="overflow:auto;">
				<table class="i-table i-w-1-1">
					<tr>
						<th>#</th>
						<th>{{ lang.registration_date }}</th>
						<th>{{ lang.fio }}/{{ lang.email }}</th>
						<th>{{ lang.role }}</th>
						<th>{{ lang.wallet_adress }}</th>
						<th>{{ lang.tokens }}</th>
						<th>{{ lang.verify }}</th>
						<th></th>
					</tr>
					<tr v-for="u in users">
						<td v-text="u.id"></td>
						<td>
							<small class="i-c-g" v-text="new Date(u.time_add * 1000).toLocaleDateString()"></small>
							<b><small v-text="u.lang.toUpperCase()"></small></b>
						</td>
						<td>
							<div v-text="u.lastname + ' ' + u.name + ' ' + u.patronymic"></div>
							<div><a :href="'mailto:' + u.email"><small class="i-c-g" v-text="u.email"></small></a></div>
						</td>
						<td>
							<i class="fa fa-fw" :style="{color: u.role == 'admin' ? '#ff8e18' : '#ccc'}" :class="{'fa-lock': u.role == 'admin', 'fa-user': u.role == 'user'}"></i>
							<small v-text="lang[u.role]"></small>
						</td>
						<td>
							<a target="_blank" :href="'http://etherscan.io/address/' + u.wallet_address" v-show="u.wallet_address" :title="u.wallet_address"><i class="fab fa-ethereum"></i> {{ u.wallet_address.replace(/0x(.{4}).+(.{4})/, '0x$1..$2') }}</a>
						</td>
						<td v-text="(u.tokens - 0).toFixed(4) + ' ' + App.site.contract.token_symbol"></td>
						<td>
							<i class="fa-fw" :style="{color: u.verify == 'proccess' ? '#50b1db' : (u.verify == 'yes' ? '#69c848' : (u.verify == 'refuted' ? '#ff8e18' : '#f00'))}" :class="{'far fa-clock': u.verify == 'proccess', 'fa fa-check': u.verify == 'yes', 'fa fa-ban': u.verify == 'refuted', 'fa fa-times': u.verify == 'no'}"></i>
							<small v-text="lang[u.verify]"></small>
						</td>
						<td>
							<button class="i-btn i-btn_small" @click="user = u; user_modal = true; selImg = (user.doc_scans[0] || {}).url || null;">{{ lang.open }}</button>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<i-modal v-model="user_modal">
			<div class="b-usercard">
				<div>
					<button class="i-btn i-btn_small b-usercard__role" @click="setRole(user, user.role == 'admin' ? 'user' : 'admin')" v-show="user.id != App.user.id">{{ user.role == 'admin' ? lang.bust : lang.as_admin }}</button>
					<div class="b-usercard__id">ID: {{ user.id }}</div>
					<div class="b-usercard__title">
						<span>{{ user.lastname + ' ' + user.name + ' ' + user.patronymic }}</span>
						<i class="fa-fw" :style="{color: user.verify == 'proccess' ? '#50b1db' : (user.verify == 'yes' ? '#69c848' : (user.verify == 'refuted' ? '#ff8e18' : '#f00'))}" :class="{'far fa-clock': user.verify == 'proccess', 'fa fa-check': user.verify == 'yes', 'fa fa-ban': user.verify == 'refuted', 'fa fa-times': user.verify == 'no'}"></i>
					</div>
				</div>
				<ul class="b-usercard__info">
					<li><span>{{ lang.registration_date }}</span> {{ new Date(user.time_add * 1000).toLocaleDateString() }}</li>
					<li><span>{{ lang.email }}</span> <a :href="'mailto:' + user.email" v-text="user.email"></a></li>
					<li><span>{{ lang.birthday }}</span> {{ user.birthday != '0000-00-00' ? user.birthday : '—' }}</li>
					<li><span>{{ lang.sex }}</span> {{ lang[user.sex] || '—' }}</li>
				</ul>
				<div class="b-usercard__main">
					<ul class="b-usercard__params">
						<li>{{ lang.city }} <span>{{ user.city || '—' }}</span></li>
						<li>{{ lang.address }} <span>{{ user.address || '—' }}</span></li>
						<li>{{ lang.zipcode }} <span>{{ user.zipcode > 0 ? user.zipcode : '—' }}</span></li>
					</ul>
					<ul class="b-usercard__params">
						<li>{{ lang.doc_number }} <span>{{ user.doc_number || '—' }}</span></li>
						<li>{{ lang.doc_date }} <span>{{ user.doc_date != '0000-00-00' ? user.doc_date : '—' }}</span></li>
						<li>{{ lang.doc_city }} <span>{{ user.doc_city || '—' }}</span></li>
					</ul>
				</div>
				<div class="b-usercard__images">
					<ul>
						<li v-for="(doc,k) in user.doc_scans"><a :href="doc.url" @click.prevent="selImg = doc.url" target="_blank" :title="doc.name" :style="{backgroundImage: 'url(' + doc.url + ')'}"></a></li>
						<li v-for="(doc,k) in user.address_scans"><a :href="doc.url" @click.prevent="selImg = doc.url" target="_blank" :title="doc.name" :style="{backgroundImage: 'url(' + doc.url + ')'}"></a></li>
						<li v-if="user.photo"><a :href="user.photo" target="_blank" @click.prevent="selImg = user.photo" title="photo.jpg" :style="{backgroundImage: 'url(' + user.photo + ')'}"></a></li>
					</ul>
					<div class="b-usercard__images__preview" v-show="selImg">
						<img v-loupe :src="selImg"/>
					</div>
				</div>
				<div class="b-usercard__footer">
					<textarea class="i-inp" v-if="user.verify == 'refuted'" v-model="user.verify_msg" :placeholder="lang.rejection_reason" @change="setVerifyMsg(user, user.verify_msg)"></textarea>
					<button class="i-btn i-btn_success" :disabled="user.verify == 'yes'" @click="setVerify(user, 'yes')"><i class="fa fa-check"></i> {{ lang.verify_ok }}</button>
					<button class="i-btn i-btn_white" :disabled="user.verify == 'no'" @click="setVerify(user, 'no')"><i class="fa fa-times" style="color:#f00"></i> {{ lang.verify_wait }}</button>
					<button class="i-btn i-btn_white i-f-r" :disabled="user.verify == 'refuted'" @click="setVerify(user, 'refuted')"><i class="fa fa-ban" style="color:#ff8e18"></i> {{ lang.verify_cancel }}</button>
				</div>
			</div>
		</i-modal>
	</div>
</template>

<style>
	.b-usercard { padding:15px 20px; }
		.b-usercard__title { font-size:24px; line-height:1.5em; }
		.b-usercard__role { float:right; margin:11px 0 0 0; }
		.b-usercard__id { float:right; font-size:14px; text-transform:uppercase; color:#929292; margin:13px 25px 0 0; }
		.b-usercard__info { list-style:none; background:#f1f3f4; padding:20px 25px; margin:15px 0 0 0; color:#000; font-size:14px; display:flex; }
			.b-usercard__info li { flex-grow:1; padding:0 30px 0 0; }
				.b-usercard__info li:last-child { padding:0; }
			.b-usercard__info span { display:block; font-size:11px; text-transform:uppercase; color:#405159; list-style:1.4; }
		.b-usercard__main { display:flex; margin:20px -10px 0; }
		.b-usercard__params { list-style:none; flex-grow:1; padding:0 10px; width:50%; }
			.b-usercard__params li { display:block; font-size:13px; color:#405159; padding:8px 0; border-bottom:1px solid #e7ebed; }
				.b-usercard__params li:last-child { border:0; }
			.b-usercard__params span { color:#000; font-size:14px; float:right; }
		.b-usercard__images { border-top:3px solid #f1f3f4; margin:7px 0 0 0; padding:20px 0 0; display:flex; }
			.b-usercard__images ul { list-style:none; width:50%; font-size:0; }
			.b-usercard__images li { display:inline-block; margin:0 10px 10px 0; }
			.b-usercard__images li a { display:inline-block; width:108px; height:81px; background:#eee no-repeat center / cover; }
			.b-usercard__images__preview { height:285px; background:#f5f5f5; width:50%; margin:0 0 0 10px; position:relative; }
				.b-usercard__images__preview img { max-width:100%; max-height:100%; position:absolute; margin:auto; left:0; top:0; bottom:0; right:0; }
		.b-usercard__footer { margin:20px 0 0 0; padding:20px 0 0 0; border-top:3px solid #f1f3f4; }
			.b-usercard__footer textarea { width:100%; resize:vertical; margin:0 0 10px 0; }
</style>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('a-users', {
			template: template,
			data: function() {
				var search = location.search.match(/search=([^&]+)/i);

				return {
					selImg: null,
					filter: {
						date_from: '',
						date_to: '',
						search: search ? (search[1] || '') : '',
						role: '',
						verify: ''
					},
					users: [],
					user_modal: false,
					user: {
						id: false
					}
				};
			},
			mounted: function() {
				this.getUsers();
			},
			methods: {
				getUsers: function() {
					var self = this;
					App.api('user.search', self.filter, function(err, res) {
						if(err) return err;
						self.users = res.users;
					});
				},
				setRole: function(user, role) {
					App.api('user.setChunk', {fields: ['role'], data: {role: role}, id: user.id}, function(err, res) {
						if(err) return err;
						user.role = role;
					});
				},
				setVerify: function(user, verify) {
					App.api('user.setChunk', {fields: ['verify'], data: {verify: verify}, id: user.id}, function(err, res) {
						if(err) return err;
						user.verify = verify;
					});
				},
				setVerifyMsg: function(user, verify_msg) {
					App.api('user.setChunk', {fields: ['verify_msg'], data: {verify_msg: verify_msg}, id: user.id}, function(err, res) {
						if(err) return err;
						user.verify_msg = verify_msg;
					});
				}
			}
		});
	});
</script>