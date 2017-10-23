(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('DashboardUserCtrl',['User', 'Auth', 'Team', 'LxNotificationService', DashboardUserCtrl]);

	function DashboardUserCtrl(User, Auth, Team, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.menthors = [];
		vm.students = [];
		vm.emailInvitation = {
			mail: '',
			teamId: 0,
			type: '',
			state: {
				isLoading: false,
				msg: '',
				success: false
			}
		};
		// Methods
		vm.getUserData = getUserData;
		vm.confirmRequest = confirmRequest;
		vm.confirmInvitation = confirmInvitation;
		vm.deleteMembership = deleteMembership;
		vm.sendInvitationEmail = sendInvitationEmail;
		// Methods implementation
		function getUserData(){
			User.getInfo(vm.userCreds.id).then(function(data){
				if(data.success){
					console.log(data.user)
					vm.userData = data.user;
					vm.userData.invitations = angular.equals(data.user.invitations, []) ? false : data.user.invitations;
					if(vm.userData.has_team){
						for (var i = 0; i < vm.userData.team.members.length; i++) {
							if(vm.userData.team.members[i].is_student){
								vm.students.push(vm.userData.team.members[i]);
							}else{
								vm.menthors.push(vm.userData.team.members[i]);
								vm.userData.team.has_menthor = true;
							}
						}
					}
				}else{
					alert(data.msg);
				}
			}, function(err){
				LxNotificationService.error('Hubo un error al descargar sus datos, revise su conexión a internet');
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
		function deleteMembership(memberShipId, invitationId){
			LxNotificationService.confirm('Eliminar membresía', 'Estas seguro que deseas eliminar la membresía del participante?',
					{
							cancel: 'Cancelar',
							ok: 'Si, quiero hacerlo'
					}, function(answer)
					{
						if (answer){
							Team.deleteMembership(memberShipId, invitationId).then(function(data){
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
		function sendInvitationEmail(type){
			vm.emailInvitation.teamId = vm.userData.team.id;
			vm.emailInvitation.type = type;
			vm.emailInvitation.leaderId = vm.userData.id;
			var valid =  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(vm.emailInvitation.mail == '' || !valid.test(vm.emailInvitation.mail)){
				vm.emailInvitation.state.success = true;
				vm.emailInvitation.state.msg = 'Debes ingresar un correo electrónico';
				return;
			}
			for (var i = 0; i < vm.userData.team.members.length; i++) {
				if( type == "mentor" && vm.userData.team.members[i].is_student){
					vm.emailInvitation.state.success = true;
					vm.emailInvitation.state.msg = 'Tú equipo ya tiene un mentor';
					return;
				}
			}
			vm.emailInvitation.state.isLoading = true;
			User.sendEmailInvitation(vm.emailInvitation).then(function(data){
				vm.emailInvitation.state.isLoading = false;
				if(data.success){
					$('#mailStudent').modal('hide');
					vm.emailInvitation.mail = '';
					if(data.action == 'EXIST'){
						var teamData = {
							role: data.role,
							teamId: data.team_id,
							uid: data.uid,
						};
						Team.inviteToTeam(teamData).then(function(res){
							var typeUser = teamData.role == 1 ? 'estudiante' : 'mentor'
							LxNotificationService.confirm('Felicitaciones', 'El ' + typeUser + ' tiene una cuenta en la plataforma, y se le envío una invitación', {
								'ok': 'Esta bien',
							}, function(answer){
								return;
							});
						}, function(err){
								LxNotificationService.error('Hubo un error al enviar la invitación');
						});
					}else{
						LxNotificationService.confirm('Felicitaciones', data.msg, {
							'ok': 'Esta bien',
						}, function(answer){
							return;
						});
					}
				}else{
					vm.emailInvitation.state.success = true;
					vm.emailInvitation.state.msg = data.msg;
				}
			}, function(err){
					LxNotificationService.error('Hubo un problema al enviar la invitación');
					vm.emailInvitation.state.success = true;
					vm.emailInvitation.state.isLoading = false;
			});
		}
		// Methods self invoking
		getUserData();
	};
})();
