<div class="content-widgets skip gray">
        <div class="widget-head blue">
                <h3>{congrats}, {user_firstname} {user_lastname}!</h3>
        </div>
        <div class="widget-container gray">
                <div class="form-container grid-form form-background">
                        <div class="form-horizontal left-align">
                                <p>{intro_text}</p>
                                <p>
                                        <strong>{email}:</strong> {user_email}
                                </p>
                                <p class="password-reveal">
                                        <strong>{password}:</strong> <span class="password">{user_password}</span>
                                </p>
                                <p><a class="btn btn-primary show-pass" href="#"> {show_password}</a></p>

                                <p><?php echo lang('outro_text'); ?></p>

                                <p>
                                        <?php echo anchor($website_url, lang('go_website'), 'class="btn btn-primary go_to_site"'); ?> 
                                        <?php echo anchor($control_panel_url, lang('go_control_panel'), 'class="btn btn-primary go_to_site"'); ?>
                                </p>

                                <script>
                                        $(function(){
                                                $.get("<?php echo site_url('ajax/statistics');?>");
                                                $('.show-pass').click(function(e){
                                                        e.preventDefault();
                                                        $(this).fadeOut().parent().prev('.password-reveal').delay(400).fadeIn();
                                                });
                                        });
                                </script>
                        </div>
                </div>
        </div>
</div>