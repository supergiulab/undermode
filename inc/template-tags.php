<?php
/**
 * UnderMode Template Tags
 * 
 * @package undermode
 */
/*----------------------------------------------------------------------------------------------------------*/
/**
 * Maintenance Page Elements
 * 
 * @see maintenance.php
 */
/* Page Title */
function undermode_tpl_title(){
	$name    = bloginfo('name');
	$options = get_option('undermode_option');
	$title   = $options['undermode_page_title'];

	if($title) {
		echo $name . ' // ' . $title;
	} else {
		echo $name . ' // ' . __('UnderMode Site');
	}
}

/*----------------------------------------------------------------------------------------------------------*/
/* Page Logo */
function undermode_tpl_logo(){
	$options = get_option('undermode_option');
	$logo    = $options['undermode_page_logo'];
	$logo    = wp_get_attachment_image($logo, 'full');

	if ($logo) {
?>
	<div class="site-logo"><?php echo $logo; ?></div>
<?php
	}
}

/*----------------------------------------------------------------------------------------------------------*/
/* Page Content */
function undermode_tpl_content(){
	$options = get_option('undermode_option');
	$content = $options['undermode_page_txt'];

	if ($content) {
?>
	<div id="page-content"><?php echo apply_filters('the_content', $content); ?></div>
<?php
	}
}

/*----------------------------------------------------------------------------------------------------------*/
/* Page Newsletter Form */
// function undermode_tpl_news_form(){
// 	$options = get_option('undermode_option');
// 	$form    = $options['undermode_news_form'];

// 	if ($form) {
// 		echo '<div id="newsletter-form">'.do_shortcode($form).'</div>';
// 	}
// }

/*----------------------------------------------------------------------------------------------------------*/
/* Page Contacts */
function undermode_tpl_contacts(){
	$options = get_option('undermode_option');
	$address = $options['undermode_address'];
	$phone   = $options['undermode_phone'];
	$mobile  = $options['undermode_mobile'];
	$fax     = $options['undermode_fax'];
	$skype   = $options['undermode_skype'];
	$email   = $options['undermode_email'];
	$hours   = $options['undermode_hours'];

	if ($address || $phone || $fax || $email || $hours) {
?>
	<ul class="site-contact">
		<?php if( $address ) { ?>
			<li class="site-address"><?php echo apply_filters( 'the_content', $address ); ?></li>
		<?php } ?>
		<?php if( $phone ) { ?>
			<li class="site-phone">
				<a class="hidden-md-up" href="tel:+39<?php echo preg_replace("/[^0-9]/", "", $phone); ?>">+39 <?php echo esc_html( $phone ); ?></a>
				<span class="hidden-sm-down">+39 <?php echo esc_html( $phone ); ?></span>
			</li>
		<?php } ?>
		<?php if( $mobile ) { ?>
			<li class="site-mobile">
				<a class="hidden-md-up" href="tel:+39<?php echo preg_replace("/[^0-9]/", "", $mobile); ?>">+39 <?php echo esc_html( $mobile ); ?></a>
				<span class="hidden-sm-down">+39 <?php echo esc_html( $mobile ); ?></span>
			</li>
		<?php } ?>
		<?php if( $fax ) { ?>
			<li class="site-fax">+39 <?php echo esc_html( $fax ); ?></li>
		<?php } ?>
		<?php if( $skype ) { ?>
			<li class="site-skype"><a href="skype:<?php echo esc_html($skype); ?>?call"><?php echo esc_html($skype); ?></a></li>
		<?php } ?>
		<?php if( $email ) { ?>
			<li class="site-email"><a href="mailto:<?php echo antispambot($email); ?>"><?php echo antispambot($email); ?></a></li>
		<?php } ?>
		<?php if( $hours ) { ?>
			<li class="site-hours"><div><?php echo apply_filters( 'the_content', $hours ); ?></div></li>
		<?php } ?>
	</ul>
<?php
	}
}

/*----------------------------------------------------------------------------------------------------------*/
/* Page Social Links */
function undermode_tpl_socials(){
	$options = get_option('undermode_option');
	$fb      = $options['undermode_fb'];
	$gram    = $options['undermode_gram'];
	$tw      = $options['undermode_tw'];
	$in      = $options['undermode_linkedin'];
	$yt      = $options['undermode_yt'];

	if ($fb || $tw || $in || $gram || $yt) {
?>
	<ul class="site-socials">
		<?php if($fb) { ?><li class="site-facebook"><a href="<?php echo esc_url($fb); ?>" title="<?php _e('Follow us on Facebook', 'undermode'); ?>" target="_blank"><?php _e('Follow us on Facebook'); ?></a></li><?php } ?>
		<?php if($fb) { ?><li class="site-instagram"><a href="<?php echo esc_url($gram); ?>" title="<?php _e('Follow us on Instagram', 'undermode'); ?>" target="_blank"><?php _e('Follow us on Instagram', 'undermode'); ?></a></li><?php } ?>
		<?php if($tw) { ?><li class="site-twitter"><a href="<?php echo esc_url($tw); ?>" title="<?php _e('Follow us on Twitter', 'undermode'); ?>" target="_blank"><?php _e('Follow us on Twitter', 'undermode'); ?></a></li><?php } ?>
		<?php if($in) { ?><li class="site-linkedin"><a href="<?php echo esc_url($in); ?>" title="<?php _e('Follow us on Linkedin', 'undermode'); ?>" target="_blank"><?php _e('Follow us on Linkedin', 'undermode'); ?></a></li><?php } ?>
		<?php if($yt) { ?><li class="site-youtube"><a href="<?php echo esc_url($yt); ?>" title="<?php _e('Follow us on YouTube', 'undermode'); ?>" target="_blank"><?php _e('Follow us on YouTube', 'undermode'); ?></a></li><?php } ?>
	</ul>
<?php
	}
}

/*----------------------------------------------------------------------------------------------------------*/
/* Login Form */
function undermode_login_form() {
	global $user_login;

	$user_id = get_current_user_id();
	$blog_id = get_current_blog_id();
	$is_failed = isset( $_GET['login'] ) && $_GET['login'] == 'failed' ? true : false;
	$is_empty  = isset( $_GET['login'] ) && $_GET['login'] == 'empty' ? true : false;
	$is_login  = isset( $_GET['login'] ) && $_GET['login'] == 'required' ? true : false;
	$is_open   = $is_failed || $is_empty || $is_login ? 'in open' : '';
?>
	<div id="um-login" class="collapse <?php echo $is_open; ?>">
		<div class="um-login-form">

		<?php if(isset( $_GET['login'] ) ) { ?>
			<?php if ( $_GET['login'] == 'failed' || $_GET['login'] == 'required' && !is_user_logged_in() ) { ?>
				<div class="login-error alert fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><?php _e( '<strong>Username o password non corretti</strong>, prova di nuovo.', 'untheme' ); ?></p>
				</div>
			<?php } ?>

			<?php if ( $_GET['login'] == 'empty' && !is_user_logged_in() ) { ?>
				<div class="login-error alert fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><?php _e( '<strong>Username o password non inseriti</strong>, prova di nuovo.', 'untheme' ); ?></p>
				</div>
			<?php } ?>
		<?php } ?>

		<?php if ( is_user_logged_in() && is_user_member_of_blog( $user_id, $blog_id ) ) { ?>
			<div class="login-content logged-in"> 
				<h2><?php echo sprintf( wp_kses( 'Ciao <strong>%1$s</strong>, <span>hai gi&agrave; eseguito il login</span>', 'untheme' ), $user_login ); ?></h2>
				<p><?php echo sprintf( wp_kses( 'Se vuoi puoi eseguire il <a id="wp-submit" href="%1$s" title="Logout">Logout</a>, tornare alla <a href="%2$s" title="Vai alla Home Page">Home Page</a> del sito, oppure accedere alla <a href="%3$s" title="Vai alla Bacheca">Bacheca di Amministrazione</a>.', 'untheme' ), wp_logout_url(), get_permalink( get_page_by_path('home') ), get_admin_url() ); ?></p>
			</div>
<?php	
		} else {
?>
			<div class="login-content">
				<h2><?php _e('Benvenuto!', 'untheme'); ?></h2>
				<p><?php _e('Esegui il login per accedere alla Bacheca', 'untheme'); ?></p>
<?php
			$user = wp_get_current_user();
			if(in_array('administrator', $user->roles)) {
				$redirect = get_admin_url();
			} else {
				$redirect = get_home_url( '/' );
			}
			
			$args = array( 'redirect' => $redirect );
			wp_login_form( $args );
?>
			<a class="lost-password" href="<?php echo wp_lostpassword_url(); ?>" title="<?php echo __('Hai perso la password?', 'st
			'); ?>"><?php echo __('Hai perso la password?', 'untheme'); ?></a>
			</div>
<?php
	}
?>
		</div>
	</div>	
<?php
}

/*----------------------------------------------------------------------------------------------------------*/
/* Login/Logout Link */
function undermode_login_out() {
	$user_id = get_current_user_id();
	$blog_id = get_current_blog_id();

	$link = '<div class="um-autentication-link">';
	if ( is_user_logged_in() && is_user_member_of_blog( $user_id, $blog_id ) ) {
		$link .= '<a id="um-logout-link" href="' . wp_logout_url() . '" title="Logout">' . __( 'Logout' ) . '</a>';
		$link .= '<a id="um-dashboard-link" href="' . admin_url() . '" title="Vai alla Bacheca">' . __( 'Vai alla Bacheca' ) . '</a>';
	} elseif ( is_page('under-construction') ) {
		$link .= '<a id="um-login-link" href="' . wp_login_url() . '" title="Login">' . __( 'Login' ) . '</a>';
	}  else {
		$link .= '<a id="um-login-link" href="' . wp_login_url() . '" title="Login">' . __( 'Login' ) . '</a>';
	}
	$link .= '</div>';
	echo $link;
}
?>