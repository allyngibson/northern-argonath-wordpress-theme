<?php
/**
 * The home template file.
 *
 * The front page.  Adapted from OS Template's Educational Theory
 * website template:
 * http://www.os-templates.com/free-website-templates/educational-theory
 * 
 */

get_header(); ?>
<?php global $position; ?>

	<!-- Featured page slider for five Pages categorized as "Featured" -->
	<div id="featured_slide_" class="grid_12" role="marquee">
		<ul id="featured_slide_Content">
		<?php $featuredpages = new WP_Query(array(
			'showposts'=>5,
			'post_type' => 'page',
			'post_status' => 'publish',
			'category_name'=>'featured' ));
		?>
		<?php while( $featuredpages->have_posts() ) : $featuredpages->the_post(); ?>
			<?php get_template_part( 'content', 'featuredpage' ); ?>
		<?php endwhile; ?>
			<li class="clear featured_slide_Image">
				<!-- Important - Leave This Empty -->
			</li>
		</ul>
	</div><!-- #featured_slide .grid_12 .marquee -->

	<!-- Thumbnail and link taken from Homepage Links custom menu -->
	<div id="hpage_featured_info" class="clearfix">
		<?php wp_nav_menu( array(
			'theme_location' => 'buttons',
			'container' => false,
			'items_wrap' => '%3$s',
			'depth' => 1,
			'walker' => new Argonath_Buttons_Walker )
		); ?>
	</div><!-- #hpage_featured_info -->

	<!-- Four posts marked Display in the "Homepage Spotlight" taxonomy -->
	<div id="featured" class="clearfix">
		<?php $featuredposts = new WP_Query( array(
			'spotlight-row' => 'display',
			'orderby' => 'date',
			'order' => 'DESC',
			'posts_per_page' => 4 ) ); ?>
		<?php while( $featuredposts->have_posts() ) : $featuredposts->the_post(); ?>
		<?php $do_not_duplicate[] = $post->ID; ?>
			<?php get_template_part( 'content', 'featuredpost' ); ?>
		<?php endwhile; ?>
	</div><!-- #featured -->

	<?php get_sidebar( 'banner468' ); ?>

	<div id="homepage" class="grid_8" role="main">
		<h2>Recent Posts</h2>
		<?php $position = "alpha"; ?>
		<?php $quantity = argonath_homepage_posts(); ?>
		<?php $recent = new WP_Query( array(
			'post__not_in'=>$do_not_duplicate,
			'category__not_in'=>array( get_cat_ID('twitter'), get_cat_ID('podcast') ),
			'posts_per_page'=>$quantity ) );
		?>
		<?php while( $recent->have_posts() ) : $recent->the_post(); ?>
		<?php if( $position == "alpha" ) echo('<div class="row clearfix">'); ?>
			<?php $do_not_duplicate[] = $post->ID; ?>
			<?php get_template_part( 'content', 'homepage' ); ?>
			<?php if( $position == "alpha" ) {
				$position = "omega";
			} else {
				$position = "alpha";
			} ?>
			<?php if( $position == "alpha" ) echo('</div>'); ?>
		<?php endwhile; ?>
	</div><!-- #homepage .grid_8 .main -->

	<?php get_sidebar( 'home' ); ?>

<!-- ####################################################################################################### -->

<?php global $add_argonath_script; ?>
<?php $add_argonath_script = true; ?>
<?php get_footer(); ?>