(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StudentAdminCtrl',['$stateParams', 'AUTH_URL', 'User', 'Auth', 'Team', 'Student', 'Request', 'LxNotificationService', StudentAdminCtrl]);

	function StudentAdminCtrl($stateParams, AUTH_URL, User, Auth, Team, Student, Request, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.url = AUTH_URL + 'students/report/excel?token=' + vm.userCreds.token;
		vm.userData = {};
		vm.students = [];
		vm.isLoading = true;
		vm.studentParent = {
			names: '',
			lastnames: '',
			isAny: false,
			msg: '',
			parents: {},
			isSigned: {
				state: false,
				msg: ''
			},
		};
		vm.studentParentSignature = {
			id: 0,
			signature: '',
		};
		vm.filters = {
			cities: ['La Paz', 'El Alto'],
			gender: ['Femenino', 'Masculino'],
			withTeam: 'ALL',
		};
		vm.total = 0;
		vm.pagination = [];
		vm.currentPage = $stateParams.num;
		// Methods
		vm.getStudents = getStudents;
		vm.updateFilter = updateFilter;
		vm.approve = approve;
		vm.getStudent = getStudent;
		vm.confirmParent = confirmParent;
		vm.downloadReport = downloadReport;
		// Methods implementation
		function getStudents(){
			Student.getStudentsAdmin(vm.currentPage).then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.students = data.students;
					vm.total = data.pages;
					for (var i = 0; i < data.pages; i++) {
						vm.pagination.push(i + 1);
					}
				}else{
					alert(data.msg);
				}
			}, function(err){
				alert('Hubo un error al obtener los datos de los estudiantes');
			});
		};
		function getStudent(id){
			Student.getStudentParents(id).then(function(data){
				if(data.success){
					console.log(data)
					vm.studentParent.names = data.student_names;
					vm.studentParent.lastnames = data.student_lastnames;
					vm.studentParent.student_id = data.student_id;
					if(data.code == 'NONE'){
						vm.studentParent.isAny = false;
						vm.studentParent.msg = data.msg;
					}else{
						vm.studentParent.isAny = true;
						vm.studentParent.parents = data.parents;
						vm.studentParentSignature.id = data.parents.id;
					}
				}else{
					LxNotificationService.warning('Intente cargar nuevamente los datos del usuario');
				}
			}, function(err){
				LxNotificationService.error('Hubo un error al obtener los datos del usuario');
			});
		};
		function updateFilter(type, arg){
			console.log(type, arg);
			if(type == 'TEAM'){
				vm.filters.withTeam = arg;
				return;
			}
			var index = vm.filters[type].indexOf(arg);
			if(index == -1){
				vm.filters[type].push(arg);
			}else{
				vm.filters[type].splice(index, 1);
			}
		};
		function approve(id, action){
			var title = action ? '¿Está seguro de aprobar al estudiante?' : '¿Está seguro de eliminar al estudiante?';
			var msg = action ? 'El estudiante podrá acceder a su sesión' : 'El estudiante ya no podrá iniciar sesión';
			LxNotificationService.confirm(title, msg, {
				cancel: 'Cancelar',
				ok: 'Si, deseo hacerlo',
			}, function(answer){
				if(answer){
					User.confirmUser({uid: id, action: action}).then(function(data){
						if(data.success){
							LxNotificationService.success(data.msg);
							for (var i = 0; i < vm.students.length; i++) {
								if(vm.students[i].id == id){
									vm.students[i].is_active = action;
									break;
								}
							}
						}else{
							LxNotificationService.warning('No se actualizo al usuario, intente nuevamente');
						}
					}, function(err){
						LxNotificationService.error('Hubo un error al actualizar al usuario');
					});
				}else{
					return;
				}
			});
		};
		function confirmParent(){
				if(vm.studentParentSignature.signature.trim() == ''){
					vm.studentParent.isSigned.state = true;
					vm.studentParent.isSigned.msg = 'Debe llenar la firma del padre/tutor';
					return;
				}
				Student.authParent(vm.studentParentSignature).then(function(data){
					if(data.success){
						// $('#authParent').modal('close');
						LxNotificationService.success(data.msg);
						for (var i = 0; i < vm.students.length; i++) {
							if(vm.students[i].id == vm.studentParent.student_id){
								vm.students[i].student.authorization = {
									active: true,
									signature: vm.studentParentSignature.signature,
								};
								break;
							}
						}
					}else{
						LxNotificationService.warning(data.msg);
					}
				}, function(err){
					LxNotificationService.error('Hubo un error al actualizar al usuario');
			});
		}
		function downloadReport(){
			Student.excelReport().then(function(data){
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
		vm.getStudents();
	};
})();
