$(function () {

	var topJumper = $('.topJumper') ;

	topJumper.click (function () {

		$('body,html').animate ({

			scrollTop: 0
		}, 200) ;

		return false ;
	}) ;
}) ;

