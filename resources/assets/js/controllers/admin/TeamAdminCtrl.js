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
		vm.isLoading = true;
		// Methods
		vm.getTeams = getTeams;
		vm.deleteTeam = deleteTeam;
		// Methods implementation
		function getTeams(){
			Team.getTeamsAdmin().then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.teams = data.teams;
				}else{
					LxNotificationService.warn(data.msg);
				}
			}, function(err){
				LxNotificationService.error(err);
			});
		};
		function deleteTeam(teamId){
			console.log(teamId);
			Team.deleteTeam(teamId).then(function(data){
				if(data.success){
					for (var i = 0; i < vm.teams.length; i++) {
						if(vm.teams[i].id == teamId){
							vm.teams.splice(i, 1);
							console.log(i, 'Eliminado');
							LxNotificationService.success(data.msg);
							return;
						}
					}
				}else{
					LxNotificationService.warning(data.msg);
				}
			}, function(err){
				LxNotificationService.error(err);
			});
		}
		// Methods self invoking
		vm.getTeams();
	};
})();
