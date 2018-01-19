(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('TeamAdminCtrl',['$scope', 'AUTH_URL', '$timeout', 'User', 'Auth', 'Team', 'LxNotificationService', TeamAdminCtrl]);

	function TeamAdminCtrl($scope, AUTH_URL, $timeout, User, Auth, Team, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.url = AUTH_URL + 'teams/report/excel?token=' + vm.userCreds.token;
		vm.teams = {
			teams: [],
			update: 'none',
		};
		vm.counters = {
			mentorsEA: 0,
			mentorsLP: 0,
			studentsEA: 0,
			studentsLP: 0,
			teamsLP: 0,
			teamsEA: 0,
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
		vm.isLoading = true;
		// Methods
		var updateCounters = updateCounters;
		var fireWatch = fireWatch;
		vm.updateFilter = updateFilter;
		vm.getTeams = getTeams;
		vm.downloadReport = downloadReport;
		vm.deleteTeam = deleteTeam;
		// Methods implementation
		function getTeams(){
			Team.getTeamsAdmin().then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.teams.teams = data.teams;
					updateCounters(data.teams);
					// vm.counters.mentorsEA = data.totalMentorsEA;
					// vm.counters.mentorsLP = data.totalMentorsLP;
					// vm.counters.studentsEA = data.totalStudentsEA;
					// vm.counters.studentsLP = data.totalStudentsLP;
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
			fireWatch();
			var index = vm.filters[type].indexOf(arg);
			if(index == -1){
				vm.filters[type].push(arg);
			}else{
				vm.filters[type].splice(index, 1);
			}
		};

		function fireWatch(){
			vm.teams.update = 'change:' + Date.now();
		}

		function updateCounters(filtered){
			var counters = {
				mentorsEA: 0,
				mentorsLP: 0,
				studentsEA: 0,
				studentsLP: 0,
				teamsLP: 0,
				teamsEA: 0,
			};
			// console.log(filtered);
			for (var j = 0; j < filtered.length; j++) {
				if(filtered[j].city.nombre == 'La Paz') counters['teamsLP'] += 1;
				else counters['teamsEA'] += 1;

				var students = filtered[j].members.students;
				var mentors = filtered[j].members.mentors;
				for (var i = 0; i < students.length; i++) {
					if(students[i].city == 'La Paz') counters['studentsLP'] += 1;
					else counters['studentsEA'] += 1;
				}
				for (var i = 0; i < mentors.length; i++) {
					if(mentors[i].city == 'La Paz') counters['mentorsLP'] += 1;
					else counters['mentorsEA'] += 1;
				}
			}
			// console.log(counters);
			vm.counters = counters;
			return;
		}

		$scope.$watch('vm.teams.update', function(newVal, oldVal){
			try{
				if(vm.filtered === undefined) throw 'NO FILTERED ARRAY PROVIDED';
				// console.log(vm.filtered);
				$timeout(function(){
					updateCounters(vm.filtered);
				}, 0);
			}catch(err) {
				console.warn(err);
			}
		});
		function downloadReport(){
			Team.excelReport().then(function(data){
				if(data.succes){
					LxNotificationService.success(data.msg);
				}else{
					LxNotificationService.warning(data.msg);
				}
			}, function(data){
				LxNotificationService.error('Hubo un error al descargar el reporte, revise su conexión a internet');
			});
		}
		// Methods self invoking
		vm.getTeams();
	};
})();
