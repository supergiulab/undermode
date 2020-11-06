<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php if (function_exists('undermode_tpl_title')) undermode_tpl_title(); ?></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class('page-undermode'); ?>>
<header id="um-masthead">
    <div class="um-site-content">
        <?php if (function_exists('undermode_tpl_logo')) undermode_tpl_logo(); ?>
        <?php if (function_exists('undermode_tpl_content')) undermode_tpl_content(); ?>

        <?php if (function_exists('undermode_tpl_news_form')) undermode_tpl_news_form(); ?>
        <?php if (function_exists('undermode_tpl_contacts')) undermode_tpl_contacts(); ?>
        <?php if (function_exists('undermode_tpl_socials')) undermode_tpl_socials(); ?>
    </div>
</header>
<footer id="um-colophon">
    <div class="um-site-footer"><?php if (function_exists('undermode_login_out')) undermode_login_out(); ?></div>
</footer>
<?php if (function_exists('undermode_login_form')) undermode_login_form(); ?>

<?php wp_footer(); ?>
</body>
</html>