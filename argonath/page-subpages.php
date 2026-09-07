<?php
/*
Template Name: Custom -- List Subpages
*/

get_header(); ?>

<div id="content" class="grid_8" role="main">
	<?php the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php $children = wp_list_pages( 'title_li=&child_of=' .$post->ID. '&echo=0' ); ?>
			<?php if ($children) { ?>
				<h2><?php _e( 'Directory' ); ?></h2>
				<ul class="subpages">
					<?php echo $children; ?>
				</ul>
		  <?php } ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- /.grid_8 #content -->

<aside id="sidebar" class="grid_4">
	<?php get_sidebar('single'); ?>
</aside><!-- /.grid_4 -->

<?php get_footer(); ?>