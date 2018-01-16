(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('MentorAdminCtrl',['$stateParams', 'User', 'Auth', 'Team', 'Mentor', 'Request', 'LxNotificationService', MentorAdminCtrl]);

	function MentorAdminCtrl($stateParams, User, Auth, Team, Mentor, Request, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.mentors = [];
		vm.isLoading = true;
		// Methods
		vm.getMentors = getMentors;
		vm.approve = approve;
		vm.total = 0;
		vm.pagination = [];
		vm.currentPage = $stateParams.num;
		vm.filters = {
			withTeam: 'ALL',
		}
		// Methods implementation
		function getMentors(){
			Mentor.getMentorsAdmin(vm.currentPage).then(function(data){
				if(data.success){
					console.log(data);
					vm.isLoading = false;
					vm.mentors = data.mentors;
					vm.total = data.pages;
					for (var i = 0; i < data.pages; i++) {
						vm.pagination.push(i + 1);
					}
				}else{
					alert(data.msg);
				}
			}, function(err){
				alert('Hubo un error al obtener a los mentores');
			});
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
							for (var i = 0; i < vm.mentors.length; i++) {
								if(vm.mentors[i].id == id){
									vm.mentors[i].is_active = action;
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
		}
		// Methods self invoking
		vm.getMentors();
	};
})();
