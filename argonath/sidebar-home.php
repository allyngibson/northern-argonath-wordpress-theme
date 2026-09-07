<?php
/**
 * The Sidebar containing the homepage widget area.
 *
 * If no 125x125 banner is active in this sidebar, it will be hidden completely.
 */
?>

<?php if ( is_active_sidebar( 'banner-1' ) ) : ?>
<div id="secondary" class="widget-area grid_4" role="complementary">
	<div class="row1">
		<?php dynamic_sidebar( 'banner-1' ); ?>
		<?php dynamic_sidebar( 'banner-2' ); ?>
	</div><!-- .row1 -->
	<?php if ( is_active_sidebar( 'banner-3' ) ) : ?>
	<div class="row2">
		<?php dynamic_sidebar( 'banner-3' ); ?>
		<?php dynamic_sidebar( 'banner-4' ); ?>
	</div><!-- .row2 -->
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'banner-5' ) ) : ?>
	<div class="row3">
		<?php dynamic_sidebar( 'banner-5' ); ?>
		<?php dynamic_sidebar( 'banner-6' ); ?>
	</div><!-- .row3 -->
	<?php endif; ?>
</div><!-- #secondary .widget-area -->
<? else : ?>
<div id="secondary" class="widget-area grid_4" role="complementary">
	<?php dynamic_sidebar( 'sidebar-home' ); ?>
</div><!-- #secondary .widget-area -->
<?php endif; ?>
