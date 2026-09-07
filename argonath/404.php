<?php
/**
 * The Template for 404 requests.
 */

get_header(); ?>

		<div id="content" class="grid_8" role="main">

			<article id="404" class="hentry">
				<header>
			 		<h1 class="entry-title"><?php _e( 'Page Not Found &mdash; Error 404' ); ?></h1>
				</header><!-- / entry header -->

				<div class="entry-content">
					<p>The page you are looking for cannot be found.</p>
					<p>Please feel free to search the <strong>site archives</strong> by page, month, or category:</p>

					<div class="grid_4 alpha">

						<p><strong>By page:</strong></p>
						<ul>
							<?php wp_list_pages('title_li='); ?>
						</ul>

					</div>

					<div class="grid_4 omega">

						<p><strong>By month:</strong></p>
						<ul>
							<?php wp_get_archives('type=monthly'); ?>
						</ul>

						<p><strong>By category:</strong></p>
						<ul>
							<?php wp_list_cats('sort_column=name'); ?>
						</ul>

					</div>

				</div><!-- .entry-content -->
			</article><!-- #post-<?php the_ID(); ?> -->

		</div><!--/.grid_8 #content-->

		<div id="sidebar" class="grid_4">
			<?php get_sidebar('single'); ?>
		</div><!-- /.grid_4 -->
<?php get_footer(); ?>