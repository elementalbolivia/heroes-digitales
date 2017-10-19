(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('City',['$http', 'PUBLIC_URL', City]);
	function City($http, PUBLIC_URL){
		return{
			getCities: function(){
				var promise = $http({
					method: 'GET',
					url: PUBLIC_URL + 'cities'
				}).then(function(response){
					return response.data;
				});
				return promise;
			},
		};
	};
})();
