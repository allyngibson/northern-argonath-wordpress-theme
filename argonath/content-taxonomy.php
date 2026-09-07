<?php
/**
 * The template for displaying taxonomy content
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<h2 class="entry-title"><?php the_title(); ?></h2>
	</header><!-- / entry header -->
	
	<div class="entry-content">
		<?php the_content( 'Continue reading <span class="meta-nav">&rarr;</span>' ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->