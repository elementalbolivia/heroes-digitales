(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('User',['$http', 'Upload', 'Auth', 'PUBLIC_URL', 'AUTH_URL', User]);
	function User($http, Upload, Auth, PUBLIC_URL, AUTH_URL){
		return{
			confirmEmail: function(data){
				var promise = $http({
					method: 'POST',
					url: PUBLIC_URL + 'creds-verification',
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			sendVerifEmail: function(data){
				var promise = $http({
					method: 'POST',
					url: PUBLIC_URL + 'send-verification-email',
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			resetPassword: function(data){
				var promise = $http({
					method: 'PUT',
					url: PUBLIC_URL + 'reset-password',
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			acceptHonorCode: function(data){
				var promise = $http({
					method: 'POST',
					url: AUTH_URL + 'user/honor-code',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			acceptParentsAuth: function(data){
				var promise = $http({
					method: 'POST',
					url: AUTH_URL + 'user/parents-auth',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getInfo: function(id){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'user/'+id,
					params: {token: Auth.getSession().token },
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			updateStudent: function(data, id){
				var promise = $http({
					method: 'PUT',
					url: AUTH_URL + 'user/student/edit/' + id,
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			updateMenthor: function(data, id){
				var promise = $http({
					method: 'PUT',
					url: AUTH_URL + 'user/mentor/edit/' + id,
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			updateImage: function(data, id){
				var promise = Upload.upload({
					method: 'POST',
					url: AUTH_URL + 'user/edit/img/'+id,
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			requestHasSent: function(teamId, uid, role){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'team/member/invitation/'+teamId+'/'+uid+'/'+role,
					params: {token: Auth.getSession().token },
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			sendEmailInvitation: function(data){
				var promise = Upload.upload({
					method: 'POST',
					url: AUTH_URL + 'user/email-invitation',
					params: {token: Auth.getSession().token },
					data: data
				}).then(function(response){
					return response.data;
				});
				return promise;
			}
		};
	};
})();
