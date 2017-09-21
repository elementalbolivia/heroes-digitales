(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
		.controller('RegisterSuccessCtrl', RegisterSuccessCtrl);
	RegisterSuccessCtrl.$inyect = ['$state', '$timeout'];

	function RegisterSuccessCtrl($state, $timeout){
		$timeout(function(){
			$state.go('home');
		}, 4500);
	};
})();