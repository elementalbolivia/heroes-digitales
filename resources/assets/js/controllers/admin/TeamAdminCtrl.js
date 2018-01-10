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
		vm.counters = {
			mentorsEA: 0,
			mentorsLP: 0,
			studentsEA: 0,
			studentsLP: 0,
		};
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			divisions: ['Junior (de 10 a 14 años)', 'Senior (de 15 a 18 años)'],
			categories: ['Educación'],
			teamThat: {
				requestMembers: true,
				requestMentors: true,
			},
		};
		// Methods
		vm.updateFilter = updateFilter;

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
					vm.counters.mentorsEA = data.totalMentorsEA;
					vm.counters.mentorsLP = data.totalMentorsLP;
					vm.counters.studentsEA = data.totalStudentsEA;
					vm.counters.studentsLP = data.totalStudentsLP;
				}else{
					LxNotificationService.warn(data.msg);
				}
			}, function(err){
				LxNotificationService.error(err);
			});
		};
		function deleteTeam(teamId){
			LxNotificationService.confirm('¿Está seguro de borrar al equipo?', 'Todos los miembros del equipo serán dados de baja del equipo, y este no será visible',
				{
					cancel: 'Cancelar',
					ok: 'Si, deseo hacerlo'
				}, function (answer){
					if(answer){
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
					}else{
						return;
					}
				});
		}
		function updateFilter(type, arg){
			var index = vm.filters[type].indexOf(arg);
			if(index == -1){
				vm.filters[type].push(arg);
			}else{
				vm.filters[type].splice(index, 1);
			}
		};
		// Methods self invoking
		vm.getTeams();
	};
})();
