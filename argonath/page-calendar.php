<?php
/*
Template Name: Calendar
 *
 * Creates a LiveJournal-style calendar archives page.
 */

get_header(); ?>

<div id="content" class="grid_8" role="main">
	<?php the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php _e('Calendar Archives'); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php argonath_calendar_archive(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->

</div><!-- /.grid_8 #content -->

<aside id="sidebar" class="grid_4">
	<?php get_sidebar(); ?>
</aside><!-- /.grid_4 -->

<?php get_footer(); ?>