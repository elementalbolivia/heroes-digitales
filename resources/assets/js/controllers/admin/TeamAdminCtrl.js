(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('TeamAdminCtrl',['$scope', 'AUTH_URL', '$timeout', 'User', 'Auth', 'Team', 'Expert', 'LxNotificationService', TeamAdminCtrl]);

	function TeamAdminCtrl($scope, AUTH_URL, $timeout, User, Auth, Team, Expert, LxNotificationService){
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
			studentsFem: 0,
			studentsMas: 0,
			mentorsFem: 0,
			mentorsMas: 0,
		};
		vm.chart = {
			labels:{
				 teams: ['Total equipos',
								 'Equipos La Paz',
								 'Equipos El Alto',],
				 students: ['Estudiantes La Paz',
									 'Estudiantes El Alto',
									 'Estudiantes Mujeres',
								 	 'Estudiantes Hombres',],
				 mentors: ['Mentores La Paz',
							 	 'Mentores El Alto',
							 	 'Mentores Mujeres',
							   'Mentores Hombres'],
			 },
			data: {
				teams: Array(3).fill(0),
				students: Array(4).fill(0),
				mentors: Array(4).fill(0),
			},
		};
		vm.filters = {
			cities: ['La Paz', 'El Alto', 'Pando', 'Cochabamba'],
			divisions: ['Junior (de 10 a 14 años)', 'Senior (de 15 a 18 años)'],
			categories: ['Educación'],
			teamThat: {
				requestMembers: true,
				requestMentors: true,
			},
		};
		vm.experts = [];
		vm.isLoading = true;
		vm.assignExpert = {
			team: {
				id: null,
				name: '',
			},
			expert: {
				id: null
			},
			action: {
				isLoading: false,
				msg: '',
				state: false
			},
		};
		// Methods
		var updateCounters = updateCounters;
		var fireWatch = fireWatch;
		vm.updateFilter = updateFilter;
		vm.getTeams = getTeams;
		vm.downloadReport = downloadReport;
		vm.deleteTeam = deleteTeam;
		vm.getExperts = getExperts;
		vm.selectTeam = selectTeam;
		vm.assignExpertToTeam = assignExpertToTeam;
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
					LxNotificationService.warning(data.msg);
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
								LxNotificationService.success(data.msg);
								vm.getTeams();
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
				studentsFem: 0,
				studentsMas: 0,
				mentorsFem: 0,
				mentorsMas: 0,
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
					if(students[i].gender == 'Masculino') counters['studentsMas'] += 1;
					else counters['studentsFem'] += 1;
				}
				for (var i = 0; i < mentors.length; i++) {
					if(mentors[i].city == 'La Paz') counters['mentorsLP'] += 1;
					else counters['mentorsEA'] += 1;
					if(mentors[i].gender == 'Masculino') counters['mentorsMas'] += 1;
					else counters['mentorsFem'] += 1;
				}
			}
			vm.counters = counters;
			vm.chart.data = {
				teams: [
					counters.teamsLP + counters.teamsEA,
					counters.teamsLP,
					counters.teamsEA,
				],
				students: [
					counters.studentsLP,
					counters.studentsEA,
					counters.studentsFem,
					counters.studentsMas,
				],
				mentors: [
					counters.mentorsLP,
					counters.mentorsEA,
					counters.mentorsFem,
					counters.mentorsMas,
				]
			};
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
			Team.excelReport(vm.filters.cities, vm.filters.divisions, vm.teamFilter).then(function(data){
				if(data.succes){
					LxNotificationService.success(data.msg);
				}else{
					LxNotificationService.warning(data.msg);
				}
			}, function(data){
				LxNotificationService.error('Hubo un error al descargar el reporte, revise su conexión a internet');
			});
		}
		function getExperts(){
			Expert.getExperts().then(function(data){
				if(data.success){
					console.log(data);
					vm.experts = data.experts;
				}else{
					LxNotificationService.warning(data.msg);
				}
			}, function(err){
				LxNotificationService.error('Hubo un error en el servidor');
			});
		}
		function selectTeam(id, name){
			vm.assignExpert.team = {
				id: id,
				name: name
			};
			return;
		}
		function assignExpertToTeam(){
			var form = vm.assignExpert;
			form.action.isLoading = true;
			if(form.expert.id == null){
				form.action.msg = 'Debes seleccionar a un experto';
				form.action.state = true;
				form.action.isLoading = false;
				return;
			}
			form.action.state = false;
			var toSend = {
				teamId: form.team.id,
				expertId: form.expert.id,
			};
			Expert.assignExpertToTeam(toSend).then(function(data){
				form.action.isLoading = false;
				if(data.success){
					vm.assignExpert = {
						team: {
							id: null,
							name: '',
						},
						expert: {
							id: null
						},
						action: {
							isLoading: false,
							msg: '',
							state: false
						},
					};
					$('#selectExpert').modal('hide');
					LxNotificationService.success(data.msg);
				}else{
					form.action.state = true;
					form.action.msg = data.msg;
				}
			}, function(err){
				form.action.isLoading = false;
				form.action.state = true;
				form.action.msg = 'Hubo un error en el servidor';
			});
		}
		// Methods self invoking
		vm.getTeams();
		vm.getExperts();
	};
})();
