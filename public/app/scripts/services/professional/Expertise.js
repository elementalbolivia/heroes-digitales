(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Expertise', Expertise)
		.constant('PUBLIC_URL', 'http://localhost:8000/api/')
		.constant('AUTH_URL', 'http://localhost:8000/api/auth/');
	Expertise.$inyect = ['$http', 'PUBLIC_URL', 'AUTH_URL', 'Auth'];
	function Expertise($http, PUBLIC_URL, AUTH_URL, Auth){
		return{
			getExpertises: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'expertises',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;	
				});
				return promise;
			},
		};
	};
})();