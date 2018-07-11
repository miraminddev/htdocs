<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.langs }}</h1>
		<div class="i-block">
			<div class="i-block__body">
				<div class="i-flex i-flex__pad10" v-for="(item, key) in langs">
					<label class="i-label">
						<div class="i-label__title">{{ lang.key }}</div>
						<input class="i-inp i-label__inp" size="34" v-model="item[0]"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">{{ lang.value }}</div>
						<input class="i-inp i-label__inp" size="34" v-model="item[1]"/>
					</label>
					<label class="i-label">
						<div class="i-label__title">&nbsp;</div>
						<button class="i-label__inp i-btn" @click="langs.splice(key, 1)" :title="lang.delete"><i class="fa fa-trash"></i></button>
					</label>
				</div>
				<a href="javascript:" @click="langs.push([' ',' '])">{{ lang.add_value }}</a>
				<br/><br/>
				<button class="i-btn" @click="setLang($event)">{{ lang.save_button }}</button>
				<a href="javascript:" class="i-f-r" @click="exportJson()">{{ lang.export_json }}</a>
				<a href="javascript:" class="i-f-r" style="margin:0 20px 0 0;" @click="importJson()">{{ lang.import_json }}</a>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('a-lang', {
			template: template,
			data: function() {
				return {
					langs: []
				};
			},
			mounted: function() {
				this.getLang();
			},
			methods: {
				getLang: function() {
					var self = this;
					App.api('site.getLang', function(err, res) {
						if(err) return err;
						self.langs = res.lang;
					});
				},
				setLang: function(event) {
					var self = this;
					App.api('site.setLang', {lang: self.langs}, function(err, res) {
						if(err) return err;
						App.success(lang.data_save);
					});
					event.preventDefault();
				},
				exportJson: function() {
					window.open('/langs/' + lang.symbol + '.json?' + (new Date()).getTime());
				},
				importJson: function() {
					var self = this;
					jQuery('<input type="file" accept="application/json"/>').on('change', function() {
						var reader = new FileReader();
						reader.onload = function() {
							self.langs = [];
							var data = jQuery.parseJSON(reader.result) || {};
							for(var k in data) {
								self.langs.push([k, data[k]]);
							}
						};
						reader.readAsText(this.files[0]);
				    }).trigger('click');
				}
			}
		});
	});
</script>