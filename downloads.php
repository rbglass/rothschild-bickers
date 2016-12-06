<?php
/*
Template Name: Downloads
*/
?>

<?php get_header(); ?>

		<div id="wrapper">
			<div class="row">
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
				
				<?php if( get_field('activate_content') ): ?>
				<section>
					<?php the_content(''); ?>
				</section>
				<?php endif; ?>

				<section>
				<?php if( have_rows('downloads') ): while( have_rows('downloads') ): the_row(); ?>

					<div class="download-thumb">
							<div class="media">
							<?php 
							$image = get_sub_field('download-media');
							$size = 'download-thumb'; // (thumbnail, medium, large, full or custom size)

							// Get the image info
							$url = wp_get_attachment_url( $image );
							$title = get_the_title( $image );
							$alt = get_post($image)->_wp_attachment_image_alt;
							$caption = get_post($image)->post_excerpt;
							$description = get_post($image)->post_content;

							// Get the filesize
							$filesize = filesize( get_attached_file($image));
							$filesize = size_format($filesize, 2);

							// Get the extension
							$path_info = pathinfo( get_attached_file($image));
							$metadata = wp_get_attachment_metadata($image);
							$width = $metadata['width'];
							$height = $metadata['height'];
							?>

								<a href="<?php echo $url; ?>" target="_blank" title="<?php echo $title; ?>">
								<div class="fade">
									<?php echo wp_get_attachment_image( $image, $size ); ?>
									<div class="details">
									</div>
								</div>
								</a>

								<h5>&mdash; <a href="<?php echo $url; ?>" target="_blank" title="<?php echo $title; ?>"><?php echo $title; ?></a></h5>
								<p>&mdash; <span class="extension"><?php echo $path_info['extension']; ?></span> &mdash; <?php echo $filesize; ?> &mdash; <?php echo $width; ?> x <?php echo $height; ?>px</p>
								<?php if(!empty($caption)):?><p>&mdash; <?php echo $caption; ?></p><?php endif; ?>
								<?php if(!empty($description)):?><p>&mdash; <?php echo $description; ?></p><?php endif; ?>
							</div>
					</div>
				<?php endwhile; endif; ?>
				</section>
			</div>
		</div>

<?php get_footer(); ?>