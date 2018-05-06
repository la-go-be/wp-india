jQuery(document).ready(function () {
	jQuery(".flickr_badge_image a").attr({
		target: "_blank",
		class: "entry"
	});
	jQuery(".flickr_badge_image a").css({
		//width: '33.3333%',
		float: 'left'
	});
	jQuery('.sidebar-flickr').wrapInner('');
});