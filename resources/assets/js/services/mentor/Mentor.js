(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Mentor',['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL', Mentor]);
	function Mentor($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			getMentors: function(page){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'mentors/'+page,
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
			getMentorsAdmin: function(page){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'mentors-admin/'+page,
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
