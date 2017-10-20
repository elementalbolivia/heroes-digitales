(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('MentorProfileCtrl', ['$stateParams', 'User', 'Mentor', 'Auth', 'Team', 'LxNotificationService', MentorProfileCtrl]);

	function MentorProfileCtrl($stateParams, User, Mentor, Auth, Team, LxNotificationService){
		var vm = this;
		// Props
		vm.mentorData = {
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
		vm.getMentorData = getMentorData;
		vm.inviteToTeam = inviteToTeam;
		vm.hasInvited = hasInvited;
		vm.cancelInvitation = cancelInvitation;
		// Methods implementation
		function getMentorData(id){
			User.getInfo(id).then(function(data){
				if(data.success){
					console.log(data.user);
					vm.mentorData = data.user;
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
				Team.inviteToTeam({uid: id, teamId: vm.authParams.teamId, role: vm.mentorData.role_id}).then(function(data){
					if(data.success){
						LxNotificationService.alert('Felicidades', 'La invitación fue enviada con éxito', 'OK', function(answer){
							return;
						});
						vm.getMentorData($stateParams.id);
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
			var invitations = vm.mentorData.invitations;
			for (var i = 0; i < invitations.length; i++) {
				if(invitations[i].team_id == vm.authParams.teamId){
					vm.mentorData.invitationId = invitations[i].invitation_id;
					return true;
				}
			}
			return false;
		};
		function cancelInvitation(){
			Team.confirmInvitationFromTeam({invitationId: vm.mentorData.invitationId, accept: false}).then(function(data){
				if(data.success){
					getMentorData($stateParams.id);
					LxNotificationService.success('La invitación fue cancelada');
				}else{
					LxNotificationService.warning('Hubo un error al cancelar la invitación');
				}
			}, function(err){
				LxNotificationService.error('Hubo un error en el servidor, revise su conexión a internet');
			});
		}
		// Methods self invoking
		getMentorData($stateParams.id);
	};
})();
