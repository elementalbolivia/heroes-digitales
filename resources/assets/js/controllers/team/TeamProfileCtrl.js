(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('TeamProfileCtrl',['$stateParams', '$timeout', 'User', 'Team', 'Auth', 'LxNotificationService', TeamProfileCtrl]);

	function TeamProfileCtrl($stateParams, $timeout, User, Team, Auth, LxNotificationService){
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
		vm.youtubeUrls = {
			demo: {
				url: '',
				type: 'DEMO'
			},
			team: {
				url: '',
				type: 'EQUIPO'
			}
		};
		vm.appDoc = {
			file: null,
			state: false,
		};
		vm.appApk = {
			file: null,
			progress: 0,
			state: false,
		};
		vm.userHasSentReq = false;
		// Methods
		vm.getTeamData = getTeamData;
		vm.inviteToTeam = inviteToTeam;
		vm.updateTeamImg = updateTeamImg;
		vm.joinTeam = joinTeam;
		vm.requestHasSent = requestHasSent;
		vm.uploadVideo = uploadVideo;
		vm.uploadAppDoc = uploadAppDoc;
		vm.uploadAppApk = uploadAppApk;
		// Methods implementation
		function getTeamData(id){
			Team.getTeam(id).then(function(data){
				if(data.success){
					console.log(data.team);
					vm.teamData = data.team;
					vm.youtubeUrls = {
						demo: {
							url: data.team.youtube_videos[0].youtube_url,
							type: 'DEMO'
						},
						team: {
							url: data.team.youtube_videos[1].youtube_url,
							type: 'EQUIPO'
						}
					};
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
		function uploadVideo(id, url, type){
			var ytPath = /https:\/\/www.youtube.com/g;
			if( !ytPath.test(url) ){
				LxNotificationService.warning('Debe subir una URL de Youtube');
				return;
			}
			if(id === null || typeof id === 'undefined'){
				Team.uploadVideo({teamId: vm.userCreds.teamId, type: type, ytUrl: url}).then(function(data){
					if(data.success){
						LxNotificationService.success(data.msg);
						if(type == 'DEMO') vm.teamData.youtube_videos[0].youtube_url = url;
						else vm.teamData.youtube_videos[1].youtube_url = url;
					}else{
						LxNotificationService.warning(data.msg);
					}
				}, function(err){
					LxNotificationService.error('Hubo un error al subir su video')
				});
			}else{
				Team.updateVideo({type: type, ytUrl: url}, id).then(function(data){
					if(data.success){
						LxNotificationService.success(data.msg);
						if(type == 'DEMO') vm.teamData.youtube_videos[0].youtube_url = url;
						else vm.teamData.youtube_videos[1].youtube_url = url;
					}else{
						LxNotificationService.warning(data.msg);
					}
				}, function(err){
					LxNotificationService.error('Hubo un error al subir su video')
				});
			}
		}
		function uploadAppDoc(){
			vm.appDoc.state = true;
			if(angular.equals(vm.appDoc.file, {}) ||  vm.appDoc.file === null){
				LxNotificationService.warning('Debe subir un archivo');
				return;
			}
			Team.uploadAppDoc({appDoc: vm.appDoc.file, teamId: vm.userCreds.teamId}).then(function(data){
				vm.appDoc.state = false;
				if(data.success){
					LxNotificationService.success(data.msg);
					vm.teamData.app_doc = data.docName;
					vm.appDoc.file = null;
				}else{
					LxNotificationService.warning(data.msg);
				}
			}, function(err){
				vm.appDoc.state = false;
				LxNotificationService.error('Hubo un error al subir su documento');
			});
		}
		function uploadAppApk(){
			if(angular.equals(vm.appApk.file, {}) ||  vm.appApk.file === null){
				LxNotificationService.warning('Debe subir un archivo');
				return;
			}
			vm.appApk.state = true;
			Team.uploadAppApk({appApk: vm.appApk.file, teamId: vm.userCreds.teamId}).then(function(data){
				if(data.success){
					vm.appApk = {
						file: null,
						progress: 0,
						state: false,
					};
					vm.teamData.app_apk = data.docName;
					LxNotificationService.success(data.msg);
				}else{
					LxNotificationService.warning(data.msg);
				}
			}, function(err){
				LxNotificationService.error('Hubo un error al subir su documento');
				vm.appApk = {
					file: null,
					progress: 0,
					state: false,
				};
			}, function(evt){
				// console.log(parseInt(100.0 * evt.loaded / evt.total))
				vm.appApk.progress = parseInt(100.0 * evt.loaded / evt.total);
			});
		}
		// Methods self invoking
		getTeamData($stateParams.id);
		vm.requestHasSent();
	};
})();
