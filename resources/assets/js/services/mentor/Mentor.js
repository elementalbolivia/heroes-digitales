(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Mentor',['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL', Mentor]);
	function Mentor($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			getMentors: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'mentors',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();