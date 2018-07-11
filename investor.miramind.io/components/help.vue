<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.help }}</h1>
		<div class="i-block i-flex" style="min-height:160px;">
			<div class="i-block__icon" style="background-image:url(/assets/info.png); width:200px;">FAQ</div>
			<div class="i-block__body i-w-1-1">
				<p v-for="link in App.site.links" class="i-c-b" style="margin: 5px 0"><i class="fa fa-download"></i> &nbsp; <a :href="link.url" class="i-c-b">{{ link.name }}</a></p>
			</div>
		</div>
		<div class="i-block i-mt20">
			<div class="i-block__title">{{ lang.faq }}</div>
			<div class="i-block__body">
				<dl class="i-questions">
					<template v-for="q in App.site.help">
						<dt>{{ q.title }}</dt>
						<dd v-html="q.text"></dd>
					</template>
				</dl>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('help', {
			template: template,
			data: function() {
				return {};
			},
			mounted: function() {
				jQuery(this.$el).on('click', 'dt', function() {
					$(this).toggleClass('active');
				});
			}
		});
	});
</script>