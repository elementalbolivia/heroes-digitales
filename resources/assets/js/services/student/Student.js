(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Student',['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL', Student]);
	function Student($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			parentAuth: function(data){
				var promise = $http({
					method: 'PUT',
					url: PUBLIC_URL + 'user/parents-auth',
					data: data,
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getStudentsPage: function(page){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'students/'+page,
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getStudents: function(page){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'students',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getStudentsAdmin: function(page){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'students-admin/'+page,
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getStudentParents: function(id){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'student-parents/'+id,
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			authParent: function(data){
				var promise = $http({
					method: 'PUT',
					url: AUTH_URL + 'student/parents-auth-admin',
					params: {token: Auth.getSession().token },
					data: data,
				}).then(function(response){
					return response.data;
				});
				return promise;
			}
		};
	};
})();
