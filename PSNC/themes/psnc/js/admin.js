// DOM Ready
jQuery(document).ready(function () {	
	
jQuery('.upload_image_button').click(function(){

		var textfieldid = jQuery(this).prev().attr("id");

		wp.media.editor.send.attachment = function(props, attachment){jQuery('#' + textfieldid).val(attachment.url);}

		wp.media.editor.open(this);
		return false;
        
  });
			    
				
});


