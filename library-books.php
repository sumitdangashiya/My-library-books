<?php
/*
Plugin Name: Library Books
Plugin URI: https://dishantpatel.me
Description: Search library books.
Author: Dishant Patel
Author URI: https://dishantpatel.me
Version: 1.0.0
*/

if ( !defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

define( 'LIBRARY_BOOKS_URL', plugins_url('/', __FILE__) );  // Define Plugin URL
define( 'LIBRARY_BOOKS_PATH', plugin_dir_path(__FILE__) );  // Define Plugin Directory Path

if ( !class_exists( 'Library_Books' ) ) {
	
	class Library_Books {
		
		public function __construct() {
			
			
			add_action( 'activated_plugin', array( $this, 'library_books_activation_redirect' ) );
			
			add_action( 'init',  array( $this, 'library_books_register_post_types' ) );
			add_action( 'add_meta_boxes', array( $this, 'library_books_post_type_meta_boxes' ) );
			add_action( 'save_post_ebooks', array( $this, 'library_books_save_ebooks_meta_fields' ), 10, 3 );
			add_action( 'admin_enqueue_scripts', array( $this, 'library_books_admin_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'library_books_wp_script' ) );
			
			add_shortcode( 'library_book_search', array( $this, 'library_book_search_func' ) );
			
			add_action( 'wp_ajax_library_book_search', array( $this, 'wp_ajax_library_book_search_func' ) );
			add_action( 'wp_ajax_nopriv_library_book_search', array( $this, 'wp_ajax_library_book_search_func' ) );
			
			add_action('admin_menu', array( $this, 'library_books_menu_pages') );
			 
		}
		
		/*
		 * Redirect plugin after activate.
		 */
		public function library_books_activation_redirect( $plugin ) {
			if( $plugin == plugin_basename( __FILE__ ) ) {
				wp_redirect( admin_url( 'edit.php?post_type=ebooks&page=ebook_page' ) ) ;
				exit;
			}
		}
		/*
		 * enqueue Fronted side js and css file
		 */
		public function library_books_wp_script() {
			wp_register_style( 'bootstrap',  plugins_url('/css/bootstrap.min.css', __FILE__) );
			wp_enqueue_style( 'bootstrap' );
			wp_register_style( 'jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
			wp_enqueue_style( 'jquery-ui' ); 
			
			wp_register_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css' );
			wp_enqueue_style( 'fontawesome' ); 
			
			wp_enqueue_style( 'library-books', plugins_url('/css/library-books.css', __FILE__) ); 
			
			
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-slider' );	
			wp_enqueue_script('library-books', plugins_url('/js/library-books.js', __FILE__), array( 'jquery' ));
			
			$locale_settings = [
					'ajaxurl' => admin_url( 'admin-ajax.php' ),					
				];


			$locale_settings = apply_filters( 'library_book_localize_settings', $locale_settings );

			wp_localize_script(
				'library-books',
				'bookconfig',
				$locale_settings
			);
		}
		
		
		/*
		 * enqueue admin side js and css file
		 */
		public function library_books_admin_script() {
			
			wp_register_style( 'jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
			wp_enqueue_style( 'jquery-ui' ); 
		
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script('library-books', plugins_url('/js/library-books.js', __FILE__), array( 'jquery' ));		
		}
		
		/*
		 * register custom post type
		 */
		public function library_books_register_post_types() {
			include LIBRARY_BOOKS_PATH. 'ebooks-custom-post-type.php';
			
			
		}
		
		/*
		 * Add Submenu Page in eBook Post Type
		 */
		public function library_books_menu_pages() {
			add_submenu_page('edit.php?post_type=ebooks','eBook Shortcode', 'eBook Shortcode','manage_options', 'ebook_page', array( $this, 'library_bookpage') );
		}
		
		/*
		 * Add meta box for ebooks custom post type
		 */
		public function library_books_post_type_meta_boxes() {
			
			add_meta_box( 'library-ebooks-meta-box', esc_html__( 'eBook Options', 'library-books' ), array( $this, 'library_ebooks_options' ), 'ebooks', 'normal', 'high' );
			
			
		}
		
		/*
		 * eBook Post Type custom fields box
		 */
		
		public function library_ebooks_options( $post ){
			$post_id = $post->ID;
	
			$_short_description	= get_post_meta( $post_id, '_short_description', true);			
			$_price		= get_post_meta( $post_id, '_price', true);
			$_published_date		= get_post_meta( $post_id, '_published_date', true);
			$_rating		= get_post_meta( $post_id, '_rating', true);
			
			?>
			<table class="form-table" id="form_table">
				<tr class="ad-meta-field">
					<th>
						<label><?php esc_html_e( 'Short Description', 'library-books' )?></label>
					</th>
					<td>
						<textarea name="_short_description" class="regular-text "><?php echo esc_html( $_short_description);?></textarea>		
					</td>
				</tr>				
				<tr class="ad-meta-field">
					<th>
						<label><?php esc_html_e( 'Price ($)', 'library-books' )?></label>
					</th>
					<td>
						<input type="text" name="_price" value="<?php echo esc_attr( $_price );?>" class="regular-text " size="100"/>
					</td>
				</tr>
				<tr class="ad-meta-field">
					<th>
						<label><?php esc_html_e( 'Published date', 'library-books' )?></label>
					</th>
					<td>
						<input type="text" name="_published_date" value="<?php echo esc_attr( $_published_date );?>" class="regular-text regular-datepicker" size="100"/>
					</td>
				</tr>
				<tr class="ad-meta-field">
					<th>
						<label><?php esc_html_e( 'Rating', 'library-books' )?></label>
					</th>
					<td>
						<select name="_rating">
							<option value="" ><?php _e( 'Select rating', 'library-books' );?></option>
							<?php for( $i=1; $i<=5; $i++):?>
								<option value="<?php echo $i?>" <?php selected( $_rating, $i ); ?>><?php echo $i . ' out of 5';?></option>
							<?php endfor;?>
						</select>						
					</td>
				</tr>
			</table>
			
			<?php
		}
		
		/*
		 * eBook Shortcode page
		 */
		
		public function library_bookpage() {
			?>
			<div class="wrap">
				<h1><?php _e( 'eBook Shortcode', 'library-books' ); ?></h1>
				
				<code>[library_book_search]</code>
				<p class="description"><?php esc_html_e( 'Use this shortcode to display eBook search page.','library-books' );?></p>
			</div>
			<?php
		}
		
		/*
		 * Save eBooks information
		 */
		public function library_books_save_ebooks_meta_fields( $post_id, $post, $update ) {
			update_post_meta( $post_id, '_short_description', $_POST['_short_description'] );			
			update_post_meta( $post_id, '_price', $_POST['_price'] );
			update_post_meta( $post_id, '_published_date', $_POST['_published_date'] );
			update_post_meta( $post_id, '_rating', $_POST['_rating'] );
		}
		
		/*
		 * call shortcode page template file.
		 */
		public function library_book_search_func( $atts ) {
						
			ob_start();
			
			library_book_get_template( 'ebook-shortcode.php', $atts );
			
			return ob_get_clean();
		}
		
		/*
		 * call Bool lists template file on ajax search.
		 */
		public function wp_ajax_library_book_search_func(){			
			
			library_book_get_template( 'ebook-lists.php' );
			
			wp_die();
		}
	}
}

new Library_Books();

/**
 * Get other templates passing attributes and including the file.
 * 
 */
function library_book_get_template( $template_name, $args = array(), $template_path = '', $default_path = ''  ) {
		
	
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}

	$located = library_book_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		/* translators: %s template */
		wc_doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'ansh-addon' ), '<code>' . $located . '</code>' ), '2.1' );
		return;
	}	
	
	
	include apply_filters( 'library_book_get_template', $located, $template_name, $args, $template_path, $default_path );;
	
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 */
function library_book_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	if ( ! $template_path ) {
		$template_path = apply_filters( 'library_book_template_path', 'ansh-addon/' );
	}

	if ( ! $default_path ) {
		$default_path = LIBRARY_BOOKS_PATH . '/templates/';
	}

	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name,
		)
	);

	// Get default template/.
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}
	// Return what we found.
	return apply_filters( 'library_book_locate_template', $template, $template_name, $template_path );
}


/*
 * Return custom taxonomy array. 
 *
 * @since 1.0.0
 */
function library_book_custom_taxonomy( $taxonomy = 'category') {
	
    $terms = get_terms( array( 
							'taxonomy' => $taxonomy,
							'hide_empty' => true,
						)
					);
    
    $options = array();
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$options[ $term->term_id ] = $term->name;
		}
    }
    
    return $options;
}