if ( typeof ($sig) == 'undefined') {
	var $sig = jQuery;
}
function SigProModal(el) {
	href = $sig(el).attr('href');
	$sig.fancybox({
		type : 'iframe',
		href : href,
		padding : 0,
		margin : 40,
		title : null,
		width : 1225,
		height : 800,
		helpers : {
			css : {
				'html' : 'overflow:hidden'
			},
			locked : true
		}
	});
}