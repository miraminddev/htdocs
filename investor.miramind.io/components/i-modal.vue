<template>
	<div class="i-modal" v-if="value" @click="close()">
		<div class="i-modal__wrap" @click.stop="">
			<div class="i-modal__close" @click="close()"></div>
			<div class="i-modal__body">
				<slot></slot>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('i-modal', {
			template: template,
			props: ['value'],
			data: function() {
				return {
					show: true
				};
			},
			methods: {
				close: function() {
					this.$emit('input', false);
				}
			}
		});
	});
</script>