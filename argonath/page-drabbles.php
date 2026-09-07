<?php
/**
Template Name: Custom -- Drabble Archive
 *
 * This is the template that displays drabble archives.
 * When using this page, put the slug for the Short Fiction category
 * into the content window.  The page will pull that and build a
 * loop from what's entered there.
 */

get_header(); ?>
<?php remove_action('pre_get_posts', 'argonath_drabble_exclude'); ?>
<?php the_post(); ?>
<?php $drabbleslug = get_the_content(); ?>

		<div id="content" class="grid_8" role="main">

			<div class="category-background">
				<h1 class="page-title"><?php single_term_title(); ?></h1>

				<?php
					$term_description = term_description();
					if ( $term_description )
						echo '<div class="taxonomy-description">' . $term_description . '</div>';
				?>
			</div> <!-- /.category-background -->
			
			<?php wp_reset_query(); ?>
			<?php $drabble = query_posts( array(
				'tax_query' => array(
					array(
						'taxonomy' => 'short-fiction',
						'field' => 'slug',
						'terms' => $drabbleslug
					)
				),
				'orderby' => 'title',
				'order' => 'ASC',
				'posts_per_page' => -1 ) );
			?>
			<?php if ( have_posts() ) : ?>

			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'drabbles' ); 
				endwhile;
				argo_content_nav( 'nav-below' );

			else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title">Nothing Found</h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>


		</div>
		<!-- /.grid_8 #content -->
		<?php add_action('pre_get_posts', 'argonath_drabble_exclude'); ?>
<aside id="sidebar" class="grid_4">
<?php get_sidebar('single'); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
