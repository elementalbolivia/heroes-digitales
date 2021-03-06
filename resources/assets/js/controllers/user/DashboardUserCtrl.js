(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('DashboardUserCtrl',['$scope', '$window', '$timeout', '$state', 'User', 'Auth', 'Team', 'Stage', 'LxNotificationService', DashboardUserCtrl]);

	function DashboardUserCtrl($scope, $window, $timeout, $state, User, Auth, Team, Stage, LxNotificationService){
		var vm = this;
		// Props
		vm.userCreds = Auth.getSession();
		vm.userData = {};
		vm.menthors = [];
		vm.students = [];
		vm.isUserDataLoaded = false;
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
		vm.sended = {
			msg: '',
			title: '',
		};
		vm.stages = [];
		// Methods
		vm.getUserData = getUserData;
		vm.confirmRequest = confirmRequest;
		vm.confirmInvitation = confirmInvitation;
		vm.deleteMembership = deleteMembership;
		vm.sendInvitationEmail = sendInvitationEmail;
		vm.clearFields = clearFields;
		vm.getStages = getStages;
		vm.cancelInvitation = cancelInvitation;
		vm.setActiveTeachable = setActiveTeachable;
		// Methods implementation
		function getStages(){
			Stage.getStages().then(function(data){
				if(data.success){
					console.log(data.stages);
					vm.stages = data.stages;
				}else{
					alert(data.msg);
				}
			}, function(err){
				console.error('Hubo un error en el servidor');
			});
		};
		function getUserData(){
			User.getInfo(vm.userCreds.id).then(function(data){
				if(data.success){
					vm.isUserDataLoaded = true;
					console.log(data.user)
					vm.userData = data.user;
					if( (vm.userCreds.role == 1 || vm.userCreds.role == 2) && data.user.teacheable == null )
						$('#teacheableModal').modal({display: 'show', backdrop: 'static', keyboard: false});
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
						vm.students = [];
						vm.mentors = [];
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
			var invId = invitationId == undefined ? null : invitationId;
			LxNotificationService.confirm('Eliminar membresía', 'Estas seguro que deseas eliminar la membresía del participante?',
					{
							cancel: 'Cancelar',
							ok: 'Si, quiero hacerlo'
					}, function(answer)
					{
						if (answer){
							Team.deleteMembership(memberShipId, invId).then(function(data){
								if(data.success){
									vm.students = [];
									vm.mentors = [];
									vm.getUserData();
									LxNotificationService.success('El miembro fue eliminado');
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
			if(type == 'mentor' && vm.userData.team.is_full_mentors){
				vm.emailInvitation.state.success = true;
				vm.emailInvitation.state.msg = 'Tú equipo ya tiene 2 mentores';
				return;
			}
			if(type == 'student' && vm.userData.team.is_full_students){
				vm.emailInvitation.state.success = true;
				vm.emailInvitation.state.msg = 'Tú equipo ya tiene 4 estudiantes';
				return;
			}
			vm.emailInvitation.state.isLoading = true;
			User.sendEmailInvitation(vm.emailInvitation).then(function(data){
				vm.emailInvitation.state.isLoading = false;
				if(data.success){
					$('#mailStudent').modal('hide');
					$('#mailMentor').modal('hide');
					vm.emailInvitation.mail = '';
					vm.emailInvitation.state.success = false;
					$('#invitationSend').modal('show');
					vm.sended.title = 'Invitación Enviada!';
					vm.sended.msg = data.msg;
				}else{
					vm.emailInvitation.state.success = true;
					vm.emailInvitation.state.msg = data.msg;
				}
			}, function(err){
					vm.emailInvitation.state.msg = 'Hubo un problema al enviar la invitación';
					vm.emailInvitation.state.success = true;
					vm.emailInvitation.state.isLoading = false;
			});
		}
		function clearFields(){
			vm.emailInvitation.state.success = false;
			vm.emailInvitation.mail = '';
		}
		function cancelInvitation(id){
			Team.confirmInvitationFromTeam({invitationId: id, accept: false}).then(function(data){
				if(data.success){
					var toPop = 0;
					var invitations =  vm.userData.team.invitations_sent;
					for (var i = 0; i < invitations.length; i++) {
						if(invitations[i].invitation_id == id){
							toPop = i;
						}
					}
					invitations.splice(toPop, 1);
					LxNotificationService.success('La invitación fue cancelada');
				}else{
					LxNotificationService.warning('Hubo un error al cancelar la invitación');
				}
			}, function(err){
				LxNotificationService.error('Hubo un error en el servidor, revise su conexión a internet');
			});
		}
		function setActiveTeachable(){
			User.createTeachableCreds({id: vm.userCreds.id}).then(function(data){
				if(data.success){
					$('#teacheableModal').modal('hide');
				}else{
					LxNotificationService.warning(data.msg);
				}
			}, function(data){
				LxNotificationService.error('Hubo un error al crear su crendencial, verifique su conexión a internet');
			})
		}
		// Methods self invoking
		getUserData();
		getStages();
	};
})();
