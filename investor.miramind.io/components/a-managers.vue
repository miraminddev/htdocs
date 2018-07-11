<template>
	<div class="b-lk__content-wrap">
		<h1>{{ lang.managers }}</h1>
		<div class="i-block i-mt20">
			<div class="i-block__title">{{ lang.managers }}</div>
			<div class="i-block__body">
				<table class="i-table i-w-1-1">
					<tr>
						<th>{{ lang.address }}</th>
						<th>
							<button class="i-btn" @click="addManager()">{{ lang.add }}</button>
						</th>
					</tr>
					<tr v-for="manager in managers">
						<td v-text="manager"></td>
						<td>
							<button class="i-btn" @click="removeManager(manager)">{{ lang.delete }}</button>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	define(['Vue'], function(Vue) {
		Vue.component('a-managers', {
			template: template,
			data: function() {
				return {
					managers: []
				};
			},
			mounted: function() {
				this.getManagers();
			},
			methods: {
				getManageable: function(cb) {
			        if(App.web3_status >= 2) {
			        	(function() {
			        		if(App.site.contract.crowdsale_address != undefined) {
					        	// Interface of contract Manageable
					        	cb(web3.eth.contract([{"constant":true,"inputs":[],"name":"countManagers","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_manager","type":"address"}],"name":"addManager","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"managers","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getManagers","outputs":[{"name":"","type":"address[]"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_manager","type":"address"}],"name":"removeManager","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_manager","type":"address"}],"name":"isManager","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"anonymous":false,"inputs":[{"indexed":true,"name":"manager","type":"address"}],"name":"ManagerAdded","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"manager","type":"address"}],"name":"ManagerRemoved","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"previousOwner","type":"address"},{"indexed":true,"name":"newOwner","type":"address"}],"name":"OwnershipTransferred","type":"event"}]).at(App.site.contract.crowdsale_address));
			        		}
			        		else setTimeout(arguments.callee, 100);
			        	})();
			        }
			        else App.error(lang.metamask_not_found);
				},
				getManagers: function() {
					var self = this;
					self.getManageable(function(contract) {
						contract.getManagers(function(err, res) {
							if(err) return App.error(err);
							self.managers = res;
						});
					});
				},
				addManager: function() {
					var self = this;
					self.getManageable(function(contract) {
						var address = prompt(lang.write_address_manager);
						if(/^0x[a-f0-9]{40}$/i.test(address)) {
							contract.addManager(address, {}, function(err, res) {
								if(err) return App.error(err);
								self.getManagers();
							});
						}
						else App.error(lang.invalid_address);
					});
				},
				removeManager: function(address) {
					var self = this;
					self.getManageable(function(contract) {
						contract.removeManager(address, {}, function(err, res) {
							if(err) return App.error(err);
							self.getManagers();
						});
					});
				}
			}
		});
	});
</script>