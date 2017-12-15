<?php
/**
 * The template for displaying about page
 * Template Name: About
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MLAShure
 */

get_header(); ?>

	<div class="about-banner">
		<div class="ui container">
			<div class="ui segment vertical">
				<div class="ui two column grid stackable fullheight">
					<div class="column">
					</div>
					<div class="column middle aligned right aligned">
						<h1 class="white">Lorem ipsum dolor sit amet, partem malorum eam in, usu cu soleat expetenda</h1>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post(); ?>

			<div class="white-content">
				<div class="ui segment vertical nb0">
					<div class="ui text container text-center">
						<h2>A website to help you get great <br>grades for your exams for free</h2>
						<p>Lorem ipsum dolor sit amet, nam ex ferri nobis, <br>nec te saepe equidem omittantur. Quando primis eripuit ut eos, et tritani theophrastus sit, sed no illud malis deseruisse. </p>
					</div>
				</div>
			</div>

			<div class="ui segment vertical nb0">
				<div class="ui two column grid padded stackable">
					<div class="column padding0 right aligned" style="background: #e7e7e9;">
						<img src="<?php echo get_stylesheet_directory_uri() . '/img/about2.jpg'; ?>" alt="">
					</div>
					<div class="column about-2-wrap" style="background: #4882b9; color: #fff;">
						<div class="about-2-content">
							<h2>Lorem Ipsum</h2>
			<p>Lorem ipsum dolor sit amet, nam ex ferri nobis, nec te saepe equidem omittantur, sea insolens legendos ea. Quando primis eripuit ut eos, et tritani theophrastus sit, sed no illud malis deseruisse.</p>
			<p>Dictas cotidieque id vis, novum invidunt cu qui. Magna antiopam id eam, per at integre fastidii, ei cum ancillae epicurei volutpat. Munere antiopam vix ne, te mei quem doming intellegat, id est ceteros voluptatum. Id esse vivendum rationibus per, ex pro nostrud ornatus reprehendunt.</p>
						</div>
					</div>
				</div>
			</div>

			<div class="ui container">
				<div class="front-block">
		    	<?php get_template_part( 'template-parts/content', 'four-icons' ) ?>
				</div>
		  </div>


			<?php endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<div class="front-block cta mt0">
    <?php get_template_part( 'template-parts/content', 'cta' ) ?>
  </div>

<?php
get_footer();
