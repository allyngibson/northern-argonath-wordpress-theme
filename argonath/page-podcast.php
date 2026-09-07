<?php
/*
Template Name: Podcast
*/
?>

<?php get_header(); ?>

<div id="content" class="grid_8" role="main">
	<?php the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->

	<?php $podcast = new WP_Query( 'category_name=podcast&showposts=1' ); ?>
	<?php while($podcast->have_posts()) : $podcast->the_post();?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php _e( "Latest Podcast" ); ?></a></h2>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile; ?>

	<article id="post-archive" <?php post_class(); ?>>
		<header class="entry-header">
			<h2><?php _e( 'Podcast Archives' ); ?></h2>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<ul>
			<?php $archives = new WP_Query( 'category_name=podcast&order=ASC&orderby=date&posts_per_page=-1' ); ?>
			<?php while($archives->have_posts()) : $archives->the_post();?>
				<li><b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b> (<?php echo get_the_date( 'm-d-Y' ); ?>)</li>
			<?php endwhile; ?>
			</ul>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- /.grid_8 #content -->
<aside id="sidebar" class="grid_4">
<?php get_sidebar('single'); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>