<?php 
// Block direct access
if( !defined( 'ABSPATH' ) ){
	exit( 'Direct script access denied.' );
}
/**
 * @Packge 	   : Burger
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Before wrapper Preloader
	if( !function_exists('burger_site_preloader') ){
		function burger_site_preloader(){
			if( burger_opt('burger-preloader-toggle-settings') ):
			?>
		    <div id="preloader">
		        <div class="burger-preloader"></div>
		    </div>
			<?php
			endif;
		}
	}

	// Header menu hook function
	if( !function_exists( 'burger_header_cb' ) ){
		function burger_header_cb(){
			get_template_part( 'templates/header', 'top' );

			if( !is_page_template( 'template-builder.php' ) && !is_singular('service') ){
				get_template_part( 'templates/header', 'bottom' );
			}
		}
	}

	// Footer area hook function
	if( !function_exists( 'burger_footer_area' ) ){
		function burger_footer_area(){
			$footer_class = burger_opt( 'burger_footer_widget_toggle' ) == 1 ? 'footer' : 'footer no-widget';
			echo '<footer class="'.esc_attr( $footer_class ).'">';
				// Footer widgets
				if ( burger_opt('burger_footer_widget_toggle') == 1) {
					get_template_part( 'templates/footer', 'widgets' );
				}
				
				// Footer bottom
				get_template_part( 'templates/footer', 'bottom' );	
			echo '</footer>';
		}
	}


	// Blog, single, page, search, archive pages wrapper start hook function.
	if( !function_exists('burger_wrp_start_cb') ){
		function burger_wrp_start_cb(){
			$burger_wrp_start_class = is_home() ? ' blog_area' : ' search-page';
			echo '<section class="section-padding'.esc_attr($burger_wrp_start_class).'"><div class="container"><div class="row">';
		}
	}
	// Blog, single, page, search, archive pages wrapper end hook function.
	if( !function_exists('burger_wrp_end_cb') ){
		function burger_wrp_end_cb(){
			echo '</div></div></section>';
		}
	}
	// Blog, single, search, archive pages column start hook function.
	if( !function_exists('burger_blog_col_start_cb') ){
		function burger_blog_col_start_cb(){
			
			$sidebarOpt = burger_sidebar_opt();
								
			//
			if( !is_page() ){
				$pullRight  = burger_pull_right( $sidebarOpt , '3' );

				if( $sidebarOpt != '1' ){
					$col = '8'.$pullRight;
				}else{

					if( !is_single() ){
						$col = '12';
					}else{
						$col = '10 offset-lg-1';
					}

				}
			}else{
				$col = '8';
				
			}

			// single page should be p-b-80
			echo '<div class="col-lg-8 mb-5 mb-lg-0"><div class="blog_left_sidebar">';
		}
	}
	// Blog, single, search, archive pages column end hook function.
	if( !function_exists('burger_blog_col_end_cb') ){
		function burger_blog_col_end_cb(){
			echo '</div></div>';
		}
	}

	// Blog post thumbnail hook function.
	if( !function_exists('burger_blog_posts_thumb_cb') ){
		function burger_blog_posts_thumb_cb(){
			// Thumbnail Show
			if( has_post_thumbnail() ){
						
				if( !is_single() ){
				
					$html = '';
					$html .= '<div class="blog_item_img">';
					$html .= '<a href="'.esc_url( get_the_permalink() ).'" class="item-blog-img pos-relative dis-block hov-img-zoom">';
					$html .= burger_img_tag(
						array(
							'url' => esc_url( get_the_post_thumbnail_url() ),
							'class' => 'card-img rounded-0 wp-post-image'
						)
					);
					$html .= '</a>';
					$html .= '<a href="'. esc_url( burger_blog_date_permalink() ) .'" class="blog_item_date"><h3>'.  get_the_time( 'd' ) .'</h3><p>'. get_the_time('M') .'</p></a>';
					$html .= '</div>';
				
				}else{
					
					$html = '';
					$html .= '<div class="blog-post-thumb">';
					$html .= burger_img_tag(
						array(
							'url' => esc_url( get_the_post_thumbnail_url() ),
							'class' => 'card-img rounded-0 wp-post-image'
						)
					);
					$html .= '</div>';

				}
				echo wp_kses_post( $html );
				

			}
			// Thumbnail check and video and audio thumb show
			if( !is_single() && !has_post_thumbnail() ){
				$html = '';
				if( has_post_format( array( 'video' ) ) ){
					
					$html .= '<div class="blog-post-thumb">';
					$html .= burger_embedded_media( array( 'video', 'iframe' ) );
					$html .= '</div>';

				}else{

					if( has_post_format( array( 'audio' ) ) ){
						
						$html .= '<div class="blog-post-thumb">';
						$html .= burger_embedded_media( array( 'audio', 'iframe' ) );
						$html .= '</div>';
					}
				}
				
				echo apply_filters( 'burger_audio_embedded_media', $html );

			}
		}
	}

	// Blog details wrapper start hook function.
	if( !function_exists('burger_blog_details_wrap_start_cb') ){
		function burger_blog_details_wrap_start_cb(){

			echo '<div class="blog_details">';
		}
	}
	// Blog details wrapper end hook function.
	if( !function_exists('burger_blog_details_wrap_end_cb') ){
		function burger_blog_details_wrap_end_cb(){
			echo '</div>';
		}
	}

	// Blog post title hook function.
	if( !function_exists('burger_blog_posts_title_cb') ){
		function burger_blog_posts_title_cb(){
			if( get_the_title() ){

				$html = '';
				if( !is_single() ){
					$html .= '<a class="d-inline-block" href="'.esc_url( get_the_permalink() ).'"><h2 class="p_title">'.esc_html( get_the_title() ).'</h2></a>';
				}else{
					$html .= '<h2 class="p_title">'.esc_html( get_the_title() ).'</h2>';
				}
				
				echo wp_kses_post( $html );

			}
		}
	}

	// Blog posts meta hook function.
	if( !function_exists('burger_blog_posts_meta_cb') ){
		function burger_blog_posts_meta_cb(){

			echo '<div class="post-meta"><h6>';
			// Author
			if( get_the_author() ){
				echo esc_html__( 'By ', 'burger' ).'<a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'">'.esc_html( get_the_author() ).',</a>';
			}
			// Date
			if( get_the_date() ){
				$postData = '<a href="'.esc_url( burger_blog_date_permalink() ).'">'.esc_html( get_the_date() ).',</a>';
				echo wp_kses_post( $postData );
			}
			
			// Post category
			$cats = get_the_category();
			$categories = '';
			if( is_array( $cats ) && count( $cats ) > 0 ){
				
				foreach( $cats as $cat ){
				   $categories .= '<a href="'.esc_url( get_category_link( $cat->term_id ) ).'" class="category-link">'.esc_html( $cat->name ).',</a>';
				}
			}
							
			echo wp_kses_post( $categories );

			comments_popup_link( esc_html__( '0 Comment', 'burger' ), esc_html__( '1 Comment','burger' ), esc_html__('% Comments','burger'));
			
			$featured = '';
			if( is_sticky() ){
				$featured = '<span class="featured">'.esc_html__( 'Featured', 'burger' ).'</span>';
			}

			echo '</h6>'.wp_kses_post( $featured ).'</div>';

		
			
		}
	}

	// Blog posts excerpt hook function.
	if( !function_exists('burger_blog_posts_excerpt_cb') ){
		function burger_blog_posts_excerpt_cb(){
			?>
			<div class="blog-postexcerpt">
				<?php 
				// Post excerpt
				echo burger_excerpt_length( esc_html( burger_opt('burger_excerpt_length') ) );

				// Link Pages
				burger_link_pages();
				?>
			</div>			
			<?php
		}
	}

	// Blog read more hook function.
	if( !function_exists('burger_blog_read_more_cb') ){
		function burger_blog_read_more_cb(){
			?>
			<a href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Read More', 'burger' ); ?>
			</a>			
			<?php
		}
	}

	// Blog posts info links hook function.
	if( !function_exists('burger_blog_posts_info_link_cb') ){
		function burger_blog_posts_info_link_cb(){
			if( burger_opt( 'burger_blog_meta' ) == 1 ) {
				$burger_blog_info_link_class = is_single() ? 'blog-info-link mt-3' : 'blog-info-link';
				?>
				<ul class="<?php echo esc_attr( $burger_blog_info_link_class )?>">
					<li><i class="fa fa-tags"></i> <?php echo burger_featured_post_cat(); ?></li>
					<li><i class="ti-comments"></i> <?php echo burger_posted_comments(); ?></li>
				</ul>
				<?php
			}
		}
	}

	// Blog posts content hook function.
	if( !function_exists('burger_blog_posts_content_cb') ){
		function burger_blog_posts_content_cb(){
			?>
			<div class="blog_details">
				<?php
				the_content();
				// Link Pages
				burger_link_pages();
				?>
			</div>
			<?php
		}
	}

	// Page content hook function.
	if( !function_exists('burger_page_content_cb') ){
		function burger_page_content_cb(){
			?>
			<div class="page--content single-blog">
				<?php 
				the_content();

				// Link Pages
				burger_link_pages();
				?>

			</div>
			<?php
			// comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
	}

	// Blog page sidebar hook function.
	if( !function_exists('burger_blog_sidebar_cb') ){
		function burger_blog_sidebar_cb(){
			
			// $sidebarOpt = burger_sidebar_opt();
					
			// if( $sidebarOpt != '1'  || is_page()  ){
				get_sidebar();
			// }
			
				
		}
	}


	// Blog single post  social share hook function.
	if( !function_exists('burger_blog_posts_share_cb') ){
		function burger_blog_posts_share_cb(){
			?>
			<div class="navigation-top">
				<?php
				if( burger_opt('burger_like_btn') == 1 || burger_opt('burger_blog_share') == 1 ) {
					?>
					<div class="d-sm-flex justify-content-between text-center">
						<?php
						if ( burger_opt( 'burger_like_btn' ) == 1 ) {
							echo get_simple_likes_button( get_the_ID() );
						}

						if ( burger_opt( 'burger_blog_share' ) == 1 ) {
							echo burger_social_sharing_buttons( 'social-icons' );
						}
						?>
					</div>

					<?php
				}

				// Post Navigation
				burger_blog_single_post_navigation(); ?>
			</div>	
			<?php	
		}
	}


	/**
	 * Blog single post meta category, tag, next-previous link, comments form and biography hook function.
	 */
	if( !function_exists('burger_blog_single_meta_cb') ){
		function burger_blog_single_meta_cb(){
						
			$tags = burger_post_tags();
	
			if( $tags ){
				echo '<div class="wrap-tags">';
					echo '<span class="tag-title">'.esc_html__( 'Post Tags:', 'burger' ).'</span>';
					echo '<div class="tags-items">';
					// single post tag
					echo wp_kses_post( $tags );
					
					echo '</div>';
				echo '</div>';
			}

			// Author biography
			if( '' !== get_the_author_meta('description') ){
				get_template_part( 'templates/biography' );
			}
	
		}
	}

	// Blog 404 page hook function.
	if( !function_exists('burger_fof_cb') ){
		function burger_fof_cb(){
			get_template_part( 'templates/404' );			
		}
	}



?>