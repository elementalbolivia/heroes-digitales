(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Student', Student)
		.constant('PUBLIC_URL', 'http://localhost:8000/api/v1/')
		.constant('AUTH_URL', 'http://localhost:8000/api/v1/auth');
	Student.$inyect = ['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL'];
	function Student($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
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