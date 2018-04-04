(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Expert',['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL', Expert]);
	function Expert($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			getExperts: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'experts',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			assignRandomTeams: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'expert/assignation',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
		  },
			assignExpertToTeam: function(data){
				var promise = $http({
					method: 'POST',
					url: AUTH_URL + 'expert/team/assignation',
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
