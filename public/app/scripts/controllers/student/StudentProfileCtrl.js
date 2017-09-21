(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('StudentProfileCtrl', StudentProfileCtrl);
	StudentProfileCtrl.$inyect = ['$stateParams', 'User', 'Student', 'Auth', 'Team', 'LxNotificationService'];

	function StudentProfileCtrl($stateParams, User, Student, Auth, Team, LxNotificationService){
		var vm = this;
		// Props
		vm.studentData = {
			names: '',
			lastnames: '',
			img: '',
			email: '',
			birthDate: '',
			genre: '',
			school: '',
			city: '',
			zone: '',
			bio: '',
		};
		vm.uploadInvitation = {
			isLoading: false,
		};
		vm.isMemberInvited = false;
		vm.authParams = Auth.getSession();
		// Methods
		vm.getStudentData = getStudentData;
		vm.inviteToTeam = inviteToTeam;
		vm.hasInvited = hasInvited;
		// Methods implementation
		function getStudentData(id){
			User.getInfo(id).then(function(data){
				if(data.success){
					console.log(data.user);
					vm.studentData = data.user;
					vm.isMemberInvited = vm.hasInvited();
				}else{
					console.warn(data.msg);
				}
			}, function(err){
				alert('Hubo un error');
			});
		};
		function inviteToTeam(id){
			if(!vm.authParams.hasTeam){
				LxNotificationService.alert('Debes crear un equipo o unirte a uno', '', 'Esta bien', function(answer){
					return;
				});
			}else{
				vm.uploadInvitation.isLoading = true;
				Team.inviteToTeam({uid: id, teamId: vm.authParams.teamId, role: vm.studentData.role_id}).then(function(data){
					if(data.success){
						LxNotificationService.alert('Felicidades', 'La invitación fue enviada con éxito', 'OK', function(answer){
							return;
						});
						vm.getStudentData($stateParams.id);
						vm.isMemberInvited = vm.hasInvited();
					}else{
						LxNotificationService.warning(data.msg);
					}
				}, function(err){
					LxNotificationService.error('Hubo un error en el servidor');
				});
				vm.uploadInvitation.isLoading = false;
			}
		};
		function hasInvited(){
			var invitations = vm.studentData.invitations;
			for (var i = 0; i < invitations.length; i++) {
				if(invitations[i].team_id == vm.authParams.teamId)
					return true;
			}
			return false;
		};
		// Methods self invoking
		getStudentData($stateParams.id);
	};
})();