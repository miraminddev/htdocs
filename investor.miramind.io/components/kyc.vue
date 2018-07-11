<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.kyc }}</h1>
		<div class="i-block">
			<div class="i-block__body">
				<ul class="i-tabs">
					<li class="i-tabs__item" :class="{active: tab == 'personal_data'}" @click="tab = 'personal_data'">{{ lang.personal_data }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'address'}" @click="tab = 'address'">{{ lang.address }}</li>
					<li class="i-tabs__item" :class="{active: tab == 'photo'}" @click="tab = 'photo'">{{ lang.camera_photo }}</li>
				</ul>

				<div v-if="App.user.verify == 'refuted' && App.user.verify_msg" style="margin:20px 20px 0 20px; padding:10px 20px; background:#fcd4da; color:#f12644; border:1px solid rgba(0,0,0,0.1)">{{ App.user.verify_msg }}</div>

				<form method="POST" action="" @submit.prevent="setUser('name|lastname|patronymic|sex|birthday|doc_number|doc_city|doc_date|doc_scans'.split('|'))" class="i-block__body" v-show="tab == 'personal_data'">
					<label class="i-label">
						<div class="i-label__title">{{ lang.name }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.name" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.lastname }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.lastname" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.patronymic }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.patronymic" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.sex }}</div>
						<select class="i-inp i-label__inp" v-model="user.sex" required>
							<option value="">{{ lang.sex }}</option>
							<option value="male" selected>{{ lang.male }}</option>
							<option value="female">{{ lang.female }}</option>
						</select>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.birthday }}</div>
						<input class="i-inp i-label__inp" type="date" v-model="user.birthday" required/>
					</label>
					<div class="i-separ"></div>
					<label class="i-label">
						<div class="i-label__title">{{ lang.doc_number }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.doc_number" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.doc_city }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.doc_city" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.doc_date }}</div>
						<input class="i-inp i-label__inp" type="date" v-model="user.doc_date" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.doc_scan }}</div>
						<div v-if="user.doc_scans.length">
							<div v-for="(doc, key) in user.doc_scans">
								<a :href="doc.url" target="_blank">{{ doc.name }} ({{ lang.open }})</a>
								<a href="javascript:" @click="user.doc_scans.splice(key, 1)"><i class="fa fa-trash" :title="lang.del"></i></a>
							</div>
							<br/>
						</div>
						<a class="i-btn i-btn_white" href="javascript:" @click="App.upload(f => user.doc_scans.push(f), 'image/*', true)"><i class="fa fa-upload"></i> {{ lang.upload }}</a>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>

				<form method="POST" action="" @submit.prevent="setUser('city|address|zipcode|address_scans'.split('|'))" class="i-block__body" v-show="tab == 'address'">
					<label class="i-label">
						<div class="i-label__title">{{ lang.city }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.city" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.address }}</div>
						<input class="i-inp i-label__inp" size="45" v-model="user.address" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.zipcode }}</div>
						<input class="i-inp i-label__inp" size="10" v-model="user.zipcode" required/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.doc_scan }}</div>
						<div v-if="user.address_scans.length">
							<div v-for="(doc, key) in user.address_scans">
								<a :href="doc.url" target="_blank">{{ doc.name }} ({{ lang.open }})</a>
								<a href="javascript:" @click="user.address_scans.splice(key, 1)"><i class="fa fa-trash" :title="lang.del"></i></a>
							</div>
							<br/>
						</div>
						<a class="i-btn i-btn_white" href="javascript:" @click="App.upload(f => user.address_scans.push(f), 'image/*', true)"><i class="fa fa-upload"></i> {{ lang.upload }}</a>
					</label>
					<br/>
					<button class="i-btn">{{ lang.save_button }}</button>
				</form>
				
				<div class="i-block__body" v-show="tab == 'photo'">
					<p v-show="user.verify == 'no'">{{ lang.verify_no }}</p>
					<p v-show="user.verify == 'refuted'">{{ lang.verify_refuted }}</p>
					<p v-show="user.verify == 'proccess'">{{ lang.verify_proccess }}</p>
					<p v-show="user.verify == 'yes'">{{ lang.verify_yes }}</p>
					<div v-show="user.verify == 'no' || user.verify == 'refuted'">
						<br/>
						<button v-show="!photo.camera" class="i-btn" @click="showCamera()">{{ lang.verifycate }}</button>
						<div v-show="photo.camera">
							<video v-if="photo.camera" id="video" width="720" height="540" autoplay="autoplay"></video>
							<button v-show="photo.camera" class="i-btn" @click="toggleCamera()">{{ photo.pause ? lang.reship : lang.make_photo }}</button>
							<button v-show="photo.pause" class="i-btn" @click="sendPhoto()">{{ lang.submit }}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('kyc', {
			template: template,
			data: function() {
				return {
					tab: 'personal_data',
					user: {
						name: '',
						lastname: '',
						patronymic: '',
						sex: '',
						birthday: '',
						city: '',
						address: '',
						zipcode: '',
						doc_city: '',
						doc_number: '',
						doc_date: '',
						doc_scans: [],
						address_scans: [],
						photo: '',
						verify: 'no'
					},
					photo: {
						camera: false,
						pause: false
					}
				};
			},
			mounted: function() {
				this.getUser();
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

				showCamera: function() {
					var self = this;
					self.photo.camera = true;
					self.photo.pause = false;

					navigator.getUserMedia({video: true, audio: false}, function(localMediaStream) {
						jQuery('#video')[0].src = window.URL.createObjectURL(localMediaStream);
					}, function(e) {
						App.notice({title: e.name, body: e.message, type: 'error', lifetime: 10000});
						self.photo.camera = false;
					});
				},
				toggleCamera: function() {
					this.photo.pause = !this.photo.pause;
					jQuery('#video')[0][this.photo.pause ? 'pause' : 'play']();
				},

				sendPhoto: function() {
					var self = this,
						canvas = document.createElement('canvas'),
						video = jQuery('#video')[0];

					canvas.height = video.videoHeight;
					canvas.width = video.videoWidth;

					canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

					canvas.toBlob(function(blob) {
						var form = new FormData();
						form.append('file', blob, 'kyc-photo.jpg');

						$.ajax({url: '/api/site.uploadFile/', type: 'POST', data: form, cache: false, dataType: 'JSON', processData: false, contentType: false}).then(function(res) {
							if(typeof res == 'object' && res != null && res.file.url) {
								App.api('user.setChunk', {fields: ['photo'], data: {photo: res.file.url}}, function(err, res) {
									if(err) return err;
									App.success(lang.data_save);
								});
							}
							else App.error(lang.file_upload_error);
						});
					}, 'image/jpeg', 1);
				},
			}
		});
	});
</script>