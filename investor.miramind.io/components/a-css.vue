<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.custom_css }}</h1>
		<div class="i-block">
			<div class="i-block__body">
				<label class="i-label">
					<div class="i-label__title">{{ lang.custom_css }}</div>
					<textarea class="i-inp i-label__inp i-w-1-1" rows="24" v-model="css"></textarea>
				</label>
				<label class="i-label">
					<div class="i-label__title">{{ lang.default_color }}</div>
					<input class="i-inp" type="color" style="padding:0; width:20px;" v-model="default_color" @change="setDefaultColor()"/>
				</label>
				<br/>
				<button class="i-btn" @click="setCSS($event)">{{ lang.save_button }}</button>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('a-css', {
			template: template,
			data: function() {
				return {
					css: '',
					default_color: ''
				};
			},
			mounted: function() {
				this.getCSS();
			},
			methods: {
				getCSS: function() {
					var self = this;
					App.api('site.getCSS', function(err, res) {
						if(err) return err;
						self.css = res.css;
					});
				},
				setCSS: function(event) {
					var self = this;
					App.api('site.setCSS', {css: self.css}, function(err, res) {
						if(err) return err;
						App.success(lang.data_save);
					});
					event.preventDefault();
				},
				setDefaultColor: function() {
					this.css = this.css.replace(/\/\* var:default_color \*\/.+\/\* endvar:default_color \*\//, '');
					this.css = '/* var:default_color */.i-c-b{color:#!important}.i-btn:not(.i-btn_white){background:#}.i-btn:hover{background:#}.i-tabs__item:hover{border-bottom-color:#}.i-tabs__item.active{border-bottom-color:#}.i-currency.active{border-bottom-color:#}.i-questions dt{color:#}.b-header b{color:#}.b-header i{color:#}.b-nav li.active a,.b-nav li:hover a{border-left-color:#}.b-nav li.active i,.b-nav li:hover i{color:#}/* endvar:default_color */'.replace(/#/g, this.default_color) + this.css;
				}
			}
		});
	});
</script>