// facebook share trigger event
$(".facebook").on('click',function(){
	FB.ui({
			method: 'share',
			href: 'songfarm.ca/',
	});
});

// twitter share trigger event
$(".twitter").on('click',function(){
	// location.href='https://twitter.com/share';
	var width  = 575,
	height = 400,
	left   = ($(window).width()  - width)  / 2,
	top    = ($(window).height() - height) / 2,
	url    = "https://twitter.com/intent/tweet?url=http%3A%2F%2Fwww.songfarm.ca&text=Growing%20authentic%20music%20talent%20from%20the%20ground%20up!&hashtags=songfarmdotca",
	opts   = 'status=1' +
					 ',width='  + width  +
					 ',height=' + height +
					 ',top='    + top    +
					 ',left='   + left;
	window.open(url, 'twitter', opts);
	return false;
});

$(".linkedIn").on('click',function(){
	// location.href="https://www.linkedin.com/shareArticle?mini=true&url=http://songfarm.ca";
	var width  = 575,
	height = 400,
	left   = ($(window).width()  - width)  / 2,
	top    = ($(window).height() - height) / 2,
	url    = "https://www.linkedin.com/shareArticle?mini=true&url=http://songfarm.ca",
	opts   = 'status=1' +
					 ',width='  + width  +
					 ',height=' + height +
					 ',top='    + top    +
					 ',left='   + left;
	window.open(url, 'linkedIn', opts);
	return false;
});
