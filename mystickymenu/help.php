<div class="mystickymenu-help-form">
    <form action="<?php echo esc_url(admin_url( 'admin-ajax.php' )) ?>" method="post" id="mystickymenu-help-form">
        <div class="mystickymenu-help-header">
            <b>Gal Dubinski</b> Co-Founder at Premio
        </div>
        <div class="mystickymenu-help-content">
            <p><?php echo esc_html__("Hello! Are you experiencing any problems with My Sticky Bar? Please let me know :)", "mystickymenu") ?></p>
            <div class="mystickymenu-form-field">
                <input type="text" name="user_email" id="user_email" placeholder="<?php echo esc_html__("Email", "mystickymenu") ?>">
            </div>
            <div class="mystickymenu-form-field">
                <textarea type="text" name="textarea_text" id="textarea_text" placeholder="<?php echo esc_html__("How can I help you?", "mystickymenu") ?>"></textarea>
            </div>
            <div class="form-button">
                <button type="submit" class="mystickymenu-help-button" ><?php echo esc_html__("Chat", 'mystickymenu') ?></button>
                <input type="hidden" name="action" value="mystickymenu_admin_send_message_to_owner"  >
                <input type="hidden" id="nonce" name="nonce" value="<?php echo esc_attr(wp_create_nonce("mystickymenu_send_message_to_owner")) ?>">
            </div>
			<p class="mystickymenu-help-center">
				Or
			</p>
			<p class="mystickymenu-help-center" >
				<a href="https://premio.io/help/mystickymenu/?utm_source=pluginchat" target="_blank" ><?php echo esc_html__('Visit our Help Center >>', 'mystickymenu' );?></a>
			</p>
        </div>
    </form>
</div>
<div class="mystickymenu-help-btn">
    <a class="mystickymenu-help-tooltip" href="javascript:;"><img src="<?php echo esc_url(MYSTICKYMENU_URL) ?>images/owner.png" alt="<?php echo esc_html__("Need help?", "mystickymenu") ?>"  /></a>
	<?php if ( !isset($_COOKIE['mse-help-cta'])):?>
    <span class="tooltiptext"><?php echo esc_html__("Need help?", "mystickymenu") ?></span>
	<?php endif;?>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("#mystickymenu-help-form").on( 'submit', function(){			
            jQuery(".mystickymenu-help-button").attr("disabled",true);
            jQuery(".mystickymenu-help-button").text("<?php echo esc_html__("Sending Request...", "mystickymenu") ?>");
            formData = jQuery(this).serialize();
            jQuery.ajax({
                url: "<?php echo esc_url(admin_url( 'admin-ajax.php' )) ?>",
                data: formData,
                type: "post",
                success: function(responseText){
                    jQuery("#mystickymenu-help-form").find(".error-message").remove();
                    jQuery("#mystickymenu-help-form").find(".input-error").removeClass("input-error");                    
                    responseArray = jQuery.parseJSON(responseText);
                    if(responseArray.error == 1) {
                        jQuery(".mystickymenu-help-button").attr("disabled",false);
                        jQuery(".mystickymenu-help-button").text("<?php echo esc_html__("Chat", "mystickymenu") ?>");
                        for(i=0;i<responseArray.errors.length;i++) {
                            jQuery("#"+responseArray.errors[i]['key']).addClass("input-error");
                            jQuery("#"+responseArray.errors[i]['key']).after('<span class="error-message">'+responseArray.errors[i]['message']+'</span>');
                        }
                    } else if(responseArray.status == 1) {
                        jQuery(".mystickymenu-help-button").text("<?php echo esc_html__("Done!", "mystickymenu") ?>");
                        setTimeout(function(){
                            jQuery(".mystickymenu-help-header").remove();
                            jQuery(".mystickymenu-help-content").html("<p class='success-p'><?php echo esc_html__("Your message was sent successfully.", "mystickymenu") ?></p>");
                        },1000);
                    } else if(responseArray.status == 0) {
                        jQuery(".mystickymenu-help-content").html("<p class='error-p'><?php echo esc_html__("There is some problem in sending request. Please send us mail on <a href='mailto:contact@premio.io'>contact@premio.io</a>", "mystickymenu") ?></p>");
                    }
                }
            });
            return false;
        });
        jQuery(".mystickymenu-help-tooltip").on( 'click', function(e){
            e.stopPropagation();
            jQuery(".mystickymenu-help-form").toggleClass("active");
			if ( jQuery(".mystickymenu-help-btn .tooltiptext").length != 0) {
				jQuery(".mystickymenu-help-btn .tooltiptext").remove();
			}
			document.cookie = "mse-help-cta=hide"; 
        });
        jQuery(".mystickymenu-help-form").on( 'click', function(e){
            e.stopPropagation();
        });
        jQuery("body").on( 'click', function(){
            jQuery(".mystickymenu-help-form").removeClass("active");
        });
    });
</script>