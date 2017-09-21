(function(){
	'use strict';
	angular.module('heroesDigitalesApp')
		.factory('School', School)
		.constant('PUBLIC_URL', 'http://localhost:8000/api/v1/');
	School.$inyect = ['$http', 'PUBLIC_URL'];
	function School($http, PUBLIC_URL){
		return{
			getSchools: function(){
				var promise = $http({
					method: 'GET',
					url: PUBLIC_URL + 'schools'
				}).then(function(response){
					return response.data;	
				});
				return promise;
			},
		};
	};
})();