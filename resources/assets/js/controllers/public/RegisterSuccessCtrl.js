(function(){
	'use strict';

	angular.module('heroesDigitalesApp')
	.controller('RegisterSuccessCtrl', ['$state', '$timeout', RegisterSuccessCtrl]);
	function RegisterSuccessCtrl($state, $timeout){
		$timeout(function(){
			$state.go('home');
		}, 4500);
	};
})();
