(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Team',['$http', 'Upload', 'Auth', 'PUBLIC_URL', 'AUTH_URL', Team]);
	function Team($http, Upload, Auth, PUBLIC_URL, AUTH_URL){
		return{
			registerTeam: function(data){
				var promise = Upload.upload({
					method: 'POST',
					url: AUTH_URL + 'team',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getTeams: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'team',
					params: {token: Auth.getSession().token },
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getTeamsAdmin: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'team-admin',
					params: {token: Auth.getSession().token },
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getTeam: function(id){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'team/'+ id,
					params: {token: Auth.getSession().token },
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			editTeam: function(data){
				var promise = $http({
					method: 'PUT',
					url: AUTH_URL + 'team',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			editTeamImg: function(data){
				var promise = Upload.upload({
					method: 'POST',
					url: AUTH_URL + 'team/img',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			requestJoin: function(data){
				var promise = $http({
					method: 'POST',
					url: AUTH_URL + 'team/member',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			confirmRequestToJoin: function(data){
				var promise = $http({
					method: 'POST',
					url: AUTH_URL + 'team/member/request',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			inviteToTeam: function(data){
				var promise = $http({
					method: 'POST',
					url: AUTH_URL + 'team/invitation',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			confirmInvitationFromTeam: function(data){
				var promise = $http({
					method: 'PUT',
					url: AUTH_URL + 'team/invitation',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			deleteMembership: function(memberId, invitationId){
				var promise = $http({
					method: 'DELETE',
					url: AUTH_URL + 'team/member/'+memberId+'/invitation/'+invitationId,
					params: {token: Auth.getSession().token },
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			deleteTeam: function(teamId){
				var promise = $http({
					method: 'DELETE',
					url: AUTH_URL + 'team/' + teamId,
					params: {token: Auth.getSession().token },
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			excelReport: function(cities, divisions, teamName){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'teams/report/excel/' + cities + '/' + divisions +'/' + teamName,
					params: {token: Auth.getSession().token },
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			uploadVideo: function(data){
				var promise = $http({
					method: 'POST',
					url: AUTH_URL + 'project/video',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			updateVideo: function(data, id){
				var promise = $http({
					method: 'PUT',
					url: AUTH_URL + 'project/video/' + id + '/edit',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			uploadAppDoc: function(data){
				var promise = Upload.upload({
					method: 'POST',
					url: AUTH_URL + 'project/app-doc',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			uploadAppApk: function(data){
				var promise = Upload.upload({
					method: 'POST',
					url: AUTH_URL + 'project/app-apk',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
