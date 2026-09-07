<?php
/*
Template Name: Custom -- Post to Page
 *
 * This template will allow you to convert a blog post
 * into a static page.  Place the Post ID in the post's
 * content field, and the resulting page will use the
 * title given in the Page management area along with the
 * post content.
 */

get_header(); ?>

<div id="content" class="grid_8" role="main">
	<?php the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->
	
		<div class="entry-content">
			<?php
				$post_id = get_the_content();
				$queried_post = get_post($post_id);
				$content = $queried_post->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				echo $content;
			?>
			<hr width="75%" />
			<p><i>Originally published <a href="<?php echo get_permalink( $queried_post ); ?>">here</a>.</i></p>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->

</div><!-- /.grid_8 #content -->
<aside id="sidebar" class="grid_4">
<?php get_sidebar('single'); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>