(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Skill',['$http', 'PUBLIC_URL', 'AUTH_URL', 'Auth', Skill]);
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
