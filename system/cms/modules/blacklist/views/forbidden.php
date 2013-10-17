<html>
    <head>
        <title><?php echo lang('blacklist:forbidden_title'); ?></title>
    </head>
    <body>

        <?php
        show_error(sprintf(lang('blacklist:forbidden_msg'), $reason), '403', lang('blacklist:forbidden_title'));
        ?>
    </body>
</html>