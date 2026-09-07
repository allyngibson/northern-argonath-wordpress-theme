<?php 
/* 
Template Name: iTunes Podcast RSS Feed
*/

// Page template based upon http://digwp.com/2009/09/easy-custom-feeds-in-wordpress/

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>

<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">

<?php the_post(); ?>
<?php remove_filter( 'get_the_excerpt', 'argo_custom_excerpt_more' ); ?>
<?php remove_action( 'pre_get_posts', 'argonath_drabble_exclude' ); ?>
<channel>
	<title><?php the_title_rss(); ?></title>
	<link><?php the_permalink(); ?></link>
	<language>en-us</language>
	<copyright>&#xA9; <?php echo date("Y"); ?> <?php the_author(); ?></copyright>
	<itunes:subtitle><?php the_excerpt_rss() ?></itunes:subtitle>
	<itunes:author><?php the_author( $post->post_author ); ?></itunes:author>
	<itunes:summary><?php the_content_rss() ?></itunes:summary>
	<description><?php the_content_rss() ?></description>
	<itunes:owner>
		<itunes:name><?php the_author(); ?></itunes:name>
		<itunes:email><?php the_author_meta( 'user_email' ); ?></itunes:email>
	</itunes:owner>
	<itunes:image href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" />

	<?php $category1 = get_post_meta( $post->ID, 'itunes_cat1', true); ?>
	<itunes:category text="<?php echo $category1; ?>">
	<?php $subcat1 = get_post_meta( $post->ID, 'itunes_subcat1', true); ?>
	<?php if($itunes_subcat1 != '') { ?>
		<itunes:category text="<?php echo $subcat1; ?>" /><?php } ?>
	</itunes:category>

	<?php $category2 = get_post_meta( $post->ID, 'itunes_cat2', true); ?>
	<?php if($itunes_cat2 != '') { ?>
		<itunes:category text="<?php echo $category2; ?>">
		<?php $subcat2 = get_post_meta( $post->ID, 'itunes_subcat2', true); ?>
		<?php if($itunes_subcat2 != '') { ?>
			<itunes:category text="<?php echo $subcat2; ?>" /><?php } ?>
		</itunes:category>
	<?php } ?>

	<?php $category = get_post_meta( $post->ID, 'category_slug', true); ?>
	<?php wp_reset_query(); ?>
	<?php $posts = query_posts( 'category_name=' . $category . '&order=DESC&orderby=date&posts_per_page=-1' ); ?>
	<?php $more = 1; ?>

	<?php while( have_posts()) : the_post(); ?>
	<item>
		<title><?php the_title_rss(); ?></title>
		<itunes:author><?php the_author(); ?></itunes:author>
		<itunes:subtitle><?php the_excerpt_rss() ?></itunes:subtitle>
		<itunes:summary><?php the_content_rss() ?></itunes:summary>
		<itunes:image href="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" />
		<?php rss_enclosure(); ?>
		<guid isPermaLink="false"><?php the_guid(); ?></guid>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<itunes:duration><?php echo get_post_meta($post->ID, 'mp3-duration', true); ?></itunes:duration>
		<itunes:keywords><?php echo strip_tags(get_the_tag_list('',', ','')); ?></itunes:keywords>
	</item>
	<?php endwhile; ?>

</channel>
<?php add_filter( 'get_the_excerpt', 'argo_custom_excerpt_more' ); ?>
<?php add_action( 'pre_get_posts', 'argonath_drabble_exclude' ); ?>
</rss>