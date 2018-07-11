<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.contacts }}</h1>
		<div class="i-flex i-flex__pad10">
			<div class="i-w-1-2">
				<div class="i-block i-flex i-mb20" v-if="App.site.contact.phone">
					<div class="i-block__icon" style="background:#cfd8dc url(/assets/phone.png) no-repeat center; width:100px;"></div>
					<div class="i-block__body i-w-1-1">
						<div><small style="text-transform:uppercase;">{{ lang.telephone }}</small></div>
						<div><big><big class="i-c-b">{{ App.site.contact.phone }}</big></big></div>
					</div>
				</div>
				<div class="i-block i-flex i-mb20" v-if="App.site.contact.email">
					<div class="i-block__icon" style="background:#cfd8dc url(/assets/mail.png) no-repeat center; width:100px;"></div>
					<div class="i-block__body i-w-1-1">
						<div><small style="text-transform:uppercase;">E-mail</small></div>
						<div><big><big><a :href="'mailto:' + App.site.contact.email" class="i-c-b">{{ App.site.contact.email }}</a></big></big></div>
					</div>
				</div>
				<div class="i-block i-flex">
					<div class="i-block__icon" style="background:#cfd8dc url(/assets/globe.png) no-repeat center; width:100px;"></div>
					<div class="i-block__body i-w-1-1">
						<div><small style="text-transform:uppercase;">{{ lang.social_net }}</small></div>
						<div><big><big class="i-c-b">
							<span v-if="App.site.social.facebook"><a class="i-c-b" :href="App.site.social.facebook" target="_blank"><i class="fab fa-fw fa-facebook"></i></a> &nbsp;&nbsp;</span>
							<span v-if="App.site.social.twitter"><a class="i-c-b" :href="App.site.social.twitter" target="_blank"><i class="fab fa-fw fa-twitter"></i></a> &nbsp;&nbsp;</span>
							<span v-if="App.site.social.instagram"><a class="i-c-b" :href="App.site.social.instagram" target="_blank"><i class="fab fa-fw fa-instagram"></i></a> &nbsp;&nbsp;</span>
							<span v-if="App.site.social.youtube"><a class="i-c-b" :href="App.site.social.youtube" target="_blank"><i class="fab fa-fw fa-youtube"></i></a> &nbsp;&nbsp;</span>
							<span v-if="App.site.social.telegram"><a class="i-c-b" :href="App.site.social.telegram" target="_blank"><i class="fab fa-fw fa-telegram"></i></a> &nbsp;&nbsp;</span>
							<span v-if="App.site.social.github"><a class="i-c-b" :href="App.site.social.github" target="_blank"><i class="fab fa-fw fa-github"></i></a> &nbsp;&nbsp;</span>
							<span v-if="App.site.social.bitcointalk"><a class="i-c-b" :href="App.site.social.bitcointalk" target="_blank"><i class="fab fa-fw fa-btc"></i></a> &nbsp;&nbsp;</span>
							<span v-if="App.site.social.reddit"><a class="i-c-b" :href="App.site.social.reddit" target="_blank"><i class="fab fa-fw fa-reddit"></i></a> &nbsp;&nbsp;</span>
							<span v-if="App.site.social.medium"><a class="i-c-b" :href="App.site.social.medium" target="_blank"><i class="fab fa-fw fa-medium"></i></a> &nbsp;&nbsp;</span>
						</big></big></div>
					</div>
				</div>
			</div>
			<div class="i-w-1-2">
				<div class="i-block">
					<div class="i-block__title">{{ lang.сontact_form }}</div>
					<form method="POST" action="" @submit="submitFeedback($event)" class="i-block__body">
						<input class="i-inp i-w-1-1" :placeholder="lang.subject" v-model="feedback.theme" required pattern=".{3,}"/>
						<textarea class="i-inp i-w-1-1 i-mt10" :placeholder="lang.text" rows="5" v-model="feedback.message" required pattern=".{3,}"></textarea>
						<button class="i-btn i-w-1-1 i-mt10">{{ lang.send_button }}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('contacts', {
			template: template,
			data: function() {
				return {
					feedback: {
						theme: '',
						message: ''
					}
				};
			},
			methods: {
				submitFeedback: function(event) {
					var self = this;
					App.api('site.feedback', self.feedback, function(err, res) {
						if(err) return err;
						self.feedback = {
							theme: '',
							message: ''
						};
						App.success(lang.your_message_sending);
					});
					event.preventDefault();
				}
			}
		});
	});
</script>