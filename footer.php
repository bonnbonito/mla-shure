<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MLAShure
 */

?>

	</div><!-- #content -->

<footer class="footer-wrap">

	<div class="ui container">
		<div class="ui segment vertical nb0">
			<div class="ui three column grid centered stackable">
				<div class="column">
					<div class="ui four column grid center aligned">
						<div class="column">
							<a href="#"><i class="circular facebook f icon blue inverted"></i></a>
						</div>
						<div class="column">
							<a href="#"><i class="circular instagram icon blue inverted"></i></a>
						</div>
						<div class="column">
							<a href="#"><i class="circular twitter icon blue inverted"></i></a>
						</div>
						<div class="column">
							<a href="#"><i class="circular linkedin icon blue inverted"></i></a>
						</div>
					</div>
				</div>
			</div>

			<div class="ui hidden divider"></div>

			<div class="ui grid stackable centered center aligned">
				<div class="ten wide column">
					<nav id="footer-navigation" class="footer-navigation">
						<?php wp_nav_menu( array(
							'theme_location' => 'footer'
						) ); ?>
					</nav><!-- #site-navigation -->
				</div>
			</div>

			<div class="ui hidden divider"></div>

			<div id="colophon" class="site-footer">
				<div class="site-info">
					© copyrights 2017 ONE Click MS  all rights reserved.
				</div><!-- .site-info -->
			</div><!-- #colophon -->
		</div>
	</div>
</footer>


</div><!-- #page -->

<nav id="mobile-menu" class="mobile-menu" role="navigation">
    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
</nav><!-- #site-navigation -->

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(function() {
            FastClick.attach(document.body);
        });
        $('#mobile-menu').mmenu({
            'extensions': [
                'pagedim-black',
                'theme-dark'
            ],
            'navbar': {
                'add': true
            },
            'navbars': [
                {
                    'position': 'top'
                },
                {
                    'position': 'bottom',
                    'content': [
                        '<a href="#/" title="Follow Our Facebook"><i class="facebook f icon"></i></a>',
                        '<a href="#/" title="Follow Our Twitter"><i class="twitter icon"></i></a>',
                        '<a href="#/" title="Follow Our Instagram"><i class="instagram icon"></i></a>',
                    ]
                }
            ]
        });
        var API = $("#mobile-menu").data( "mmenu" );
        $(".menu-toggle").click(function() {
            API.open();
        });
    });
</script>

<?php wp_footer(); ?>

</body>
</html>
