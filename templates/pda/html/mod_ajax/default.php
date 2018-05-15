<script type="text/javascript">
//var $s = jQuery.noConflict();
$(document).ready(function() {
	var data = null;
	$.ajax({
		url : '<?php echo $url; ?>',
		data : '<?php echo $data; ?>&ids=<?php echo $ids; ?>&tz=<?php echo $tz; ?>&showifnotonair=<?php echo $showifnotonair; ?>',
		type : '<?php echo $type; ?>',
		cache: false,
		error: function (xhr, status) {
          //  alert(status);
        },
		success : function(msg){
			$('div#<?php echo $id; ?>').html(msg);
		}
	});
});
</script>
<?php
if(isset($link)) {
?>
<noscript>
	<a href="<?php echo $link; ?>"><img src="<?php echo $image; ?>" title="<?php echo $imgtitle; ?>" /></a> 
</noscript>
<?php 
}
?>
<div id="<?php echo $id; ?>"></div>