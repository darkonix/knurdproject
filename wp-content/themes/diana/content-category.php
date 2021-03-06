<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<?php $categories = get_the_category(); ?>
	<?php
		$categoriesArray = array();
		$categoriesBuffer = array();
		$seriesArray = array();
		$categories_list = '';
		foreach ($categories as $category) {
			if ($category->parent == 2514 OR $category->parent == 13) {
				$categoriesBuffer[] = array (
					'id' => $category->term_id,
					'slug' => $category->slug,
					'name' => $category->name,
				);
			} elseif ($category->parent == 2510) {
				$seriesArray[] = $category->slug;
				$args = array( 'numberposts' => $category->count, 'category' => $category->term_id );
				$series_posts = get_posts( $args );
				$count = -1;
				foreach ($series_posts as $series_post) {
					++$count;
					if ($series_post->ID == $post->ID) {
						break;
					}
				}
				$post_count = $category->count - $count;
				$series_list = '<a href="'.get_category_link($category->term_id).'">'.$category->name.' Episode '.$post_count.'</a>';
			}
		}
		$comma_count = 0;
		$comma_total = count($categoriesBuffer);
		foreach ($categoriesBuffer as $categoryArray) {
			$comma_count++;
			$categoriesArray[] = $categoryArray['slug'];
			if ($comma_count < $comma_total) {
				$categories_list .= '<span class="title-'.$categoryArray['slug'].'"><a href="'.get_category_link($categoryArray['id']).'">'.$categoryArray['name'].'</a></span>, ';
			} else {
				$categories_list .= '<span class="title-'.$categoryArray['slug'].'"><a class="link-'.$categoryArray['slug'].'" href="'.get_category_link($categoryArray['id']).'">'.$categoryArray['name'].'</a></span>';
			}
		}
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		<div class="category-wrapper">
			<div class="entry-thumb">
				<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'category'); ?>
				<img src="<?php echo $thumb['0']; ?>" width="43" height="43" />
			</div>
			<div class="entry-title">
			<div class="entry-meta meta-<?php echo $seriesArray[0]; ?>">
			<?php if ( 'post' == get_post_type() ) : ?>
				<?php twentyeleven_posted_on(); ?>
			<?php endif; ?>
			<?php $show_sep = true; ?>
			<span class="sep"> | </span>
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				if ( $categories_list ):
			?>
			<span class="cat-links">
				<?php printf( __( '<span class="%1$s"></span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
				$show_sep = true; ?>
			</span>
			<?php endif; // End if categories ?>
			<span class="sep"> | </span>
			<?php
				if ( $series_list ):
				if ( $show_sep ) : ?>
				<?php endif; // End if $show_sep ?>
			<span class="tag-links">
				<?php printf( __( '%2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-tag-links', $series_list );
				$show_sep = false; ?>
			</span>
			<?php endif; // End if $series_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>

			</div><!-- .entry-meta -->
			<?php if ( is_sticky() ) : ?>
				<hgroup>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<h3 class="entry-format"><?php _e( 'Featured', 'twentyeleven' ); ?></h3>
				</hgroup>
			<?php else : ?>
			<?php $subject = get_post_meta($post->ID, 'subject'); ?>
			<h1 class="title-<?php echo $categoriesArray[0]; ?>"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?> - <?php echo $subject[0]; ?></a></h1>
			</div>
			<?php endif; ?>
		</div>
		</header><!-- .entry-header -->
	</article><!-- #post-<?php the_ID(); ?> -->
