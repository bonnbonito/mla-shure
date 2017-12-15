<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MLAShure
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mlashure' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="ui container">
			<div class="ui vertical segment nb0">
				<div class="ui grid stackable middle aligned navigation-wrap">
					<div class="six wide column computer only">
						<nav id="site-navigation" class="left-main-navigation">
							<?php wp_nav_menu( array(
								'theme_location' => 'menu-1',
								'menu_id' => 'primary-menu',
								'container' => false,
								'walker' => new Walker_Nav_Primary,
								'items_wrap' => '<div id="%1$s" class="ui secondary %2$s">%3$s</div>'
							) ); ?>
						</nav><!-- #site-navigation -->
					</div>
					<div class="four wide column centered">
						<div class="site-branding">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<img src="<?php echo get_stylesheet_directory_uri() . '/img/logo.png'; ?>" alt="<?php bloginfo( 'name' ); ?>">
							</a>
						</div><!-- .site-branding -->
						<a id="hamburger" href="#" class="menu-toggle" >
							<span class="top-bar"></span>
							<span class="middle-bar"></span>
							<span class="bottom-bar"></span>
						</a>
					</div>
					<div class="six wide column computer only">
						<nav id="site-navigation-right" class="right-main-navigation">
							<?php wp_nav_menu( array(
								'theme_location' => 'menu-2',
								'menu_id' => 'right-menu',
								'container' => false,
								'walker' => new Walker_Nav_Primary,
								'items_wrap' => '<div id="%1$s" class="ui secondary %2$s"><div class="right menu">%3$s</div></div>'
							) ); ?>
						</nav><!-- #site-navigation -->
					</div>
				</div>
			</div>
		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
