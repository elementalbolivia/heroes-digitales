(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('TeamProfileCtrl', TeamProfileCtrl);
	TeamProfileCtrl.$inyect = ['$stateParams', 'User', 'Team', 'Auth', 'LxNotificationService'];

	function TeamProfileCtrl($stateParams, User, Team, Auth, LxNotificationService){
		var vm = this;
		// Props
		vm.teamData = {};
		vm.userCreds = Auth.getSession();
		vm.hasTeam = vm.userCreds.hasTeam;
		vm.isMTeam = {
			state: ($stateParams.id == vm.userCreds.teamId) ? true : false,
			isLeader: vm.userCreds.isLeader,
			uid: vm.userCreds.id,
		};
		vm.teamImg = {
			id: $stateParams.id,
			newImg: null,
		};
		vm.uploadImg = {
			isLoading: false,
		};
		vm.uploadRequest = {
			isLoading: false,
			msg: '',
			success: true,
		};
		vm.userHasSentReq = false;
		// Methods
		vm.getTeamData = getTeamData;
		vm.inviteToTeam = inviteToTeam;
		vm.updateTeamImg = updateTeamImg;
		vm.joinTeam = joinTeam;
		vm.requestHasSent = requestHasSent;
		// Methods implementation
		function getTeamData(id){
			Team.getTeam(id).then(function(data){
				if(data.success){
					console.log(data.team);
					vm.teamData = data.team;
				}else{
					console.warn(data.msg);
				}
			}, function(err){
				alert('Hubo un error');
			});
		};
		function inviteToTeam(){
			if(!Auth.hasTeam()){
				alert('Debes crear un equipo o unirte a uno');
				return;
			}
		};
		function updateTeamImg(){
			vm.uploadImg.isLoading = true;
			if(vm.teamImg.newImg == null)
				return;
			Team.editTeamImg(vm.teamImg).then(function(data){
				if(data.success){
					vm.teamData.img = data.updated_img;
					vm.teamImg.newImg = null;
				}else{
					console.warn(data.msg);
				}
				vm.uploadImg.isLoading = false;
			}, function(err){	
				alert('Hubo un error en el servidor');
			});
		};
		function joinTeam(idTeam){
			vm.uploadRequest.isLoading = true;
			Team.requestJoin({idUser: vm.userCreds.id, idTeam: idTeam, role: vm.userCreds.role}).then(function(data){
				if(data.success){
					LxNotificationService.alert('FELICIDADES','Tu solicitud fue enviada con éxito, la respuesta llegará a tu correo electrónico', 'OK', function(answer){
						return;
					});
					vm.requestHasSent();
				}else{
					vm.uploadRequest.msg = data.msg;
					vm.uploadRequest.success = false;
				}
				vm.uploadRequest.isLoading = false;
			}, function(err){
				alert('Hubo un error en el servidor');
			});
		};
		function requestHasSent(){
			User.requestHasSent($stateParams.id, vm.userCreds.id, vm.userCreds.role).then(function(data){
				if(data.success)
					vm.userHasSentReq = data.isSent;
				else
					LxNotificationService.warning(data.msg);
			}, function(err){
				LxNotificationService.error('Hubo un error en el servidor');
			});	
		}
		// Methods self invoking
		getTeamData($stateParams.id);
		vm.requestHasSent();
	};
})();