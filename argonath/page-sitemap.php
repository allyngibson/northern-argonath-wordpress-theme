<?php
/*
Template Name: Sitemap
 *
 * Creates a Sitemap
 */

get_header(); ?>

<div id="content" class="grid_8" role="main">
	<div class="grid_4 alpha">
		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>-pages">
			<div class="entry-content page-archives">
				<h2 class="subtitle"><?php _e( 'Page Archives' ); ?></h2>
				<ul>
					<?php wp_list_pages( 'title_li=' ); ?>
				</ul>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->

		<article id="post-<?php the_ID(); ?>-podcast">
			<div class="entry-content podcast-archives">
				<h2 class="subtitle"><?php _e('Podcast Archives'); ?></h2>
				<ul>
				<?php $archives = new WP_Query( 'category_name=podcast&order=ASC&orderby=date&posts_per_page=-1' ); ?>
				<?php while($archives->have_posts()) : $archives->the_post();?>
					<li><b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b></li>
				<?php endwhile; ?>
				</ul>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->

		<article id="post-<?php the_ID(); ?>-twitter">
			<div class="entry-content twitter-archives">
				<h2 class="subtitle"><?php _e('Twitter Archives'); ?></h2>
				<ul>
				<?php $archives = new WP_Query( 'category_name=twitter&order=ASC&orderby=date&posts_per_page=-1' ); ?>
				<?php while($archives->have_posts()) : $archives->the_post();?>
					<li><b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b></li>
				<?php endwhile; ?>
				</ul>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
	</div><!-- /.grid_8 #content -->

	<div class="grid_4 omega">
		<article id="post-<?php the_ID(); ?>-posts">
			<?php if(function_exists(srg_clean_archives)) { ?>
			<div class="entry-content daily-archives">
				<h2 class="subtitle"><?php _e( 'Daily Archives' ); ?></h2>
				<?php srg_clean_archives(); ?>
			<?php } else { ?>
			<div class="entry-content monthly-archives">
				<h2 class="subtitle"><?php _e( 'Monthly Archives' ); ?></h2>
				<ul>
					<?php wp_get_archives( 'postbypost', '', 'html', '', '', 'TRUE' ); ?>
				</ul>
			<?php } ?>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
	</div><!-- /.grid_4 #content -->

</div><!-- /.grid_8 #content -->

<aside id="sidebar" class="grid_4">
		<?php get_sidebar(); ?>
</aside><!-- /.grid_4 -->

<?php get_footer(); ?>