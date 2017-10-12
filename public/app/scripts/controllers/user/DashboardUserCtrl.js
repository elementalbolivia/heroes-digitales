(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('DashboardUserCtrl', DashboardUserCtrl);
	DashboardUserCtrl.$inyect = ['User', 'Auth', 'Team', 'LxNotificationService'];

	function DashboardUserCtrl(User, Auth, Team, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		// Methods
		vm.getUserData = getUserData;
		vm.confirmRequest = confirmRequest;
		vm.confirmInvitation = confirmInvitation;
		vm.deleteMembership = deleteMembership;
		// Methods implementation
		function getUserData(){
			User.getInfo(vm.userCreds.id).then(function(data){
				if(data.success){
					console.log(data.user)
					vm.userData = data.user;
					vm.userData.invitations = angular.equals(data.user.invitations, []) ? false : data.user.invitations;
				}else{
					alert(data.msg);
				}
			}, function(err){

			});
		};
		function confirmRequest(reqId, bool){
			if(bool){
				Team.confirmRequestToJoin({reqId: reqId, accept: bool}).then(function(data){
					if(data.success){
						LxNotificationService.success('El participante fue adicionado a tu equipo');
						vm.getUserData();
					}else{
						LxNotificationService.warning(data.msg);
					}
				}, function(err){
					LxNotificationService.error('Hubo un error en el servidor');
				});
			}else{
				LxNotificationService.confirm('Rechazar solicitud', 'Estas seguro que deseas rechazar la solicitud del participante?',
	            {
	                cancel: 'Cancelar',
	                ok: 'Si, quiero hacerlo'
	            }, function(answer)
	            {
	                if (answer)
	                {
	                	Team.confirmRequestToJoin({reqId: reqId, accept: bool}).then(function(data){
							if(data.success){
								LxNotificationService.success('La solicitud fue eliminada');
								vm.getUserData();
							}else{
								LxNotificationService.warning(data.msg);
							}
						}, function(err){
							LxNotificationService.error('Hubo un error en el servidor');
						});
	                }
	                else
	                {
	                	return;
	                }
	            });
			}
		};
		function confirmInvitation(invitationId, teamId, bool){
			if(bool){
				Team.confirmInvitationFromTeam({invitationId: invitationId, teamId: teamId, accept: bool}).then(function(data){
					if(data.success){
						LxNotificationService.success('Aceptaste la invitación del equipo');
						console.log(data);
						vm.getUserData();
						Auth.setHasTeam(true);
						Auth.setIsLeader(false);
						Auth.setTeamId(data.team_id);
					}else{
						LxNotificationService.warning(data.msg);
					}
				}, function(err){
					LxNotificationService.error('Hubo un error en el servidor');
				});
			}else{
				LxNotificationService.confirm('Rechazar invitación', 'Estas seguro que deseas rechazar la invitación del equipo?',
	            {
	                cancel: 'Cancelar',
	                ok: 'Si, quiero hacerlo'
	            }, function(answer)
	            {
              if (answer)
	                {
	                	Team.confirmInvitationFromTeam({invitationId: invitationId, teamId: teamId, accept: bool}).then(function(data){
										if(data.success){
											LxNotificationService.success('La invitación fue eliminada');
											Auth.setTeamId(teamId);
											Auth.setIsLeader(false);
											Auth.setHasTeam(true);
											vm.userCreds = Auth.getSession();
											vm.getUserData();
										}else{
											LxNotificationService.warning(data.msg);
										}
									}, function(err){
										LxNotificationService.error('Hubo un error en el servidor');
									});
              }
              else
              {
              	return;
              }
            });
			}
		};
		function deleteMembership(memberShipId){
			LxNotificationService.confirm('Eliminar membresía', 'Estas seguro que deseas eliminar la membresía del participante?',
					{
							cancel: 'Cancelar',
							ok: 'Si, quiero hacerlo'
					}, function(answer)
					{
						if (answer){
							Team.deleteMembership(memberShipId).then(function(data){
								if(data.success){
									console.log(data);
										LxNotificationService.success('El miembro fue eliminado');
										vm.getUserData();
								}else{
									LxNotificationService.warning(data.msg);
								}
							}, function(err){
								LxNotificationService.error('Hubo un error en el servidor');
							});
						}else{
							return;
						}
					}
			);
		};
		// Methods self invoking
		getUserData();
	};
})();
