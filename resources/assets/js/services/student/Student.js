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
			getStudents: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'students',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
