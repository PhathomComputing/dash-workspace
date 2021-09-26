// Interactiveness now

(function() {

	var clock = document.querySelector('digiclock');
	
	// But there is a little problem
	// we need to pad 0-9 with an extra
	// 0 on the left for hours, seconds, minutes
	
	var pad = function(x) {
		return x < 10 ? '0'+x : x;
	};
	
	var ticktock = function() {
		var d = new Date();
		
		var h = pad( d.getHours() );
		var m = pad( d.getMinutes() );
		var s = pad( d.getSeconds() );
		
		var current_time = [h,m,s].join(':');
		
		clock.innerHTML = current_time;
		
	};
	
	ticktock();
	
	// Calling ticktock() every 1 second
	setInterval(ticktock, 1000);
	
}());

/* ---------- Notifications ---------- */
	$('.noty').click(function(e){
		e.preventDefault();
		var options = $.parseJSON($(this).attr('data-noty-options'));
		noty(options);
	});

var ytubeAuth = {"web":{"client_id":"982211860724-hgvf7tvq6c2k2h6hm8g9gu06hug797lm.apps.googleusercontent.com","project_id":"chrismiadash","auth_uri":"https://accounts.google.com/o/oauth2/auth","token_uri":"https://oauth2.googleapis.com/token","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs","client_secret":"g0Zy1OtqlxSnwiJ7AhnsKoLu","javascript_origins":["http://www.chrismia.com"]}};