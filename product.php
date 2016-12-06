<?php
/*
Template Name: Product
*/
?>

<?php get_header(); ?>

		<div id="wrapper">
			<div class="row">
				<section>
					<?php
					if ( has_post_thumbnail() ) {
					$thumbnail_id = get_post_thumbnail_id( $post->ID );
					// Generate an <img> tag with srcset/sizes attributes.
					echo rwp_img( $thumbnail_id );
					}
					?>
				</section>

       	<?php if( get_field('right_panel') ) { ?>
				<section class="featured">
					<?php the_title( '<h1>', '</h1>' ); ?>
					<?php the_field('right_panel'); ?>
       	</section>
       	<?php } else { ?>
       	<section class="featured">
          <?php the_title( '<h1>', '</h1>' ); ?>
       	</section>
       	<?php } ?>
			</div>

			<div class="row">
				<?php if( get_field('product_info') ): ?>
				<section class="product-info">
					<?php the_field('product_info'); ?>
				</section>
				<?php endif; ?>

				<section class="product-links">
					<ul>
						<?php if( get_field('download_link') ): ?><li><a href="<?php the_field('download_link'); ?>" target="_blank">Instructions (PDF)</a></li><?php endif; ?>
						<li><a href="<?php echo site_url(); ?>/order">How to make an Order Enquiry</a></li>
						<li><a href="<?php echo site_url(); ?>/options">View Options available</a></li>
					</ul>
				</section>
			</div>

			<?php if( get_field('activate_content') ): ?>
			<div class="row">
				<section>
					<?php the_content(); ?>
				</section>
			</div>
			<?php endif; ?>

	    <?php global $post; if ( is_page() && $post->post_parent ) { ?>

	    <?php
	    $pagelist = get_pages("child_of=".$post->post_parent."&parent=".$post->post_parent."&sort_column=menu_order&sort_order=desc");
	    $pages = array();
	    foreach ($pagelist as $page) {
	      $pages[] += $page->ID;
	    }

	    $current = array_search($post->ID, $pages);
	    $prevID = $pages[$current-1];
	    $nextID = $pages[$current+1];
	    ?>

	    <div class="navigation">
	    <?php if (!empty($prevID)) { ?>
	      <div class="alignleft">
	        <a href="<?php echo get_permalink($prevID); ?>" title="<?php echo get_the_title($prevID); ?>">&laquo;&laquo; <?php echo get_the_title($prevID); ?></a>
	      </div>
	    <?php }
	    if (!empty($nextID)) { ?>
	      <div class="alignright">
	        <a href="<?php echo get_permalink($nextID); ?>" title="<?php echo get_the_title($nextID); ?>"><?php echo get_the_title($nextID); ?> &raquo;&raquo;</a>
	      </div>
	    <?php } ?>
	    </div>

	    <?php } else { ?>
	    <?php } ?>
		</div>

<?php get_footer(); ?>