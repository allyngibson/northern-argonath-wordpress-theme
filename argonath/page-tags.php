<?php
/*
Template Name: Tags
*/
get_header(); ?>

<style>
.tagcloud {
	text-align: justify;
}
</style>

<div id="content" class="grid_8" role="main">
	<?php the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php _e('Tag Cloud'); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content tagcloud">
			<?php wp_tag_cloud('smallest=10&largest=40&number=500&orderby=name'); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- /.grid_8 #content -->

<aside id="sidebar" class="grid_4">
	<?php get_sidebar('single'); ?>
</aside><!-- /.grid_4 -->

<?php get_footer(); ?>