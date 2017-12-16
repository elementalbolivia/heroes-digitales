(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('TeamAdminCtrl',['User', 'Auth', 'Team', 'LxNotificationService', TeamAdminCtrl]);

	function TeamAdminCtrl(User, Auth, Team, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.teams = [];
		// Methods
		vm.getTeams = getTeams;
		// Methods implementation
		function getTeams(){
			Team.getTeams().then(function(data){
				if(data.success){
					console.log(data);
					vm.teams = data.teams;
				}else{
					alert(data.msg);
				}
			}, function(err){

			});
		};
		// Methods self invoking
		vm.getTeams();
	};
})();
