(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Team', Team);
	Team.$inyect = ['$http', 'Upload', 'Auth', 'PUBLIC_URL', 'AUTH_URL'];
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
					method: 'PUT',
					url: AUTH_URL + 'team/member',
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
		};
	};
})();