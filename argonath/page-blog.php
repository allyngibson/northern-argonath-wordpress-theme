<?php
/*
Template Name: Blog
 *
 * This template file displays all posts in a blog-style format.
 * Based on a concept from the StudioPress themes.
 *
 */

get_header(); ?>

			<div id="content" class="grid_8" role="main">

			<?php
			if ( have_posts() ) :
				$exclude = get_cat_ID('twitter');
				$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
				query_posts('cat=-'.$exclude.'&paged='.$page);
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'index' );
				endwhile;
				argo_content_nav( 'nav-below' );
			else :
			?>

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

			</div><!--/.grid_8 #content-->

			<div id="sidebar" class="grid_4">
				<?php get_sidebar(); ?>
			</div><!-- /.grid_4 -->
<?php get_footer(); ?>