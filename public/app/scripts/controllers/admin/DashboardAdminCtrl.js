(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('DashboardAdminCtrl', DashboardAdminCtrl);
	DashboardAdminCtrl.$inyect = ['User', 'Auth', 'Stage', 'LxNotificationService', '$state'];

	function DashboardAdminCtrl(User, Auth, Stage, LxNotificationService, $state){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.stages = []
		// Methods
		vm.getStages = getStages;
		// Methods implementation
		function getStages(){
			Stage.getStages().then(function(data){
				if(data.success){
					console.log(data.stages);
					vm.stages = data.stages;
				}else{
					alert(data.msg);
				}
			}, function(err){
				console.error('Hubo un error en el servidor');
			});
		};
		// Methods self invoking
		vm.getStages();
	};
})();
