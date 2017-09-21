(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Skill', Skill)
		.constant('PUBLIC_URL', 'http://localhost:8000/api/')
		.constant('AUTH_URL', 'http://localhost:8000/api/auth/');
	Skill.$inyect = ['$http', 'PUBLIC_URL', 'AUTH_URL', 'Auth'];
	function Skill($http, PUBLIC_URL, AUTH_URL, Auth){
		return{
			getSkills: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'skills',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;	
				});
				return promise;
			},
		};
	};
})();