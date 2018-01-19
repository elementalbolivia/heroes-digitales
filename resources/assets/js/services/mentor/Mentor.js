(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('Mentor',['$http', 'Auth', 'PUBLIC_URL', 'AUTH_URL', Mentor]);
	function Mentor($http, Auth, PUBLIC_URL, AUTH_URL){
		return{
			getMentors: function(page, filters){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'mentors/'+page,
					params: {
						mentorName: filters.mentorName,
						city: JSON.stringify(filters.city),
						withTeam: filters.withTeam,
						token: Auth.getSession().token,
					 }
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
			excelReport: function(){
				var promise = $http({
					method: 'GET',
					url: AUTH_URL + 'mentors/report/excel',
					params: {token: Auth.getSession().token }
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
