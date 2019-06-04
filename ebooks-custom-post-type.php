<?php
/* Register eBooks custom Post type */
$labels = array(
	'name'                 => esc_html__( 'eBooks', 'library-books' ),
	'singular_name'        => esc_html__( 'eBook', 'library-books' ),
	'menu_name'            => esc_html__( 'eBooks', 'library-books' ),
	'name_admin_bar'       => esc_html__( 'eBook', 'library-books' ),
	'add_new'              => esc_html__( 'Add New', 'library-books' ),
	'add_new_item'         => esc_html__( 'Add New eBook', 'library-books' ),
	'new_item'             => esc_html__( 'New eBook', 'library-books' ),
	'edit_item'            => esc_html__( 'Edit eBook', 'library-books' ),
	'view_item'            => esc_html__( 'View eBook', 'library-books' ),
	'all_items'            => esc_html__( 'All eBooks', 'library-books' ),
	'search_items'         => esc_html__( 'Search eBooks', 'library-books' ),
	'parent_item_colon'    => esc_html__( 'Parent eBooks:', 'library-books' ),
	'not_found'            => esc_html__( 'No eBooks found.', 'library-books' ),
	'not_found_in_trash'   => esc_html__( 'No eBooks found in Trash.', 'library-books' ),
	'featured_image'       => esc_html__( 'eBook Image', 'library-books' ),
	'set_featured_image'   => esc_html__( 'Set eBook Image', 'library-books' ),
	'remove_featured_image'=> esc_html__( 'Remove eBook Image', 'library-books' ),
	'use_featured_image'   => esc_html__( 'Use eBook Image', 'library-books' ),
);

$cpt_ebooks_args = array(
	'labels'             => $labels,	
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'query_var'          => true,
	'rewrite'            => array( 'slug' => 'ebooks' ),
	'capability_type'    => 'post',
	'has_archive'        => true,
	'hierarchical'       => false,
	'exclude_from_search'=> true,
	'menu_position'      => null,
	'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'tags' ),
	'menu_icon'          => 'dashicons-portfolio',
);

$cpt_ebooks_args = apply_filters( 'library_ebooks_register_post_type',  $cpt_ebooks_args );
register_post_type( 'ebooks', $cpt_ebooks_args );


/* Author taxonomy */
$labels = array(
	'name'                       => esc_html__( 'Author', 'library-books' ),
	'singular_name'              => esc_html__( 'Author', 'library-books' ),
	'search_items'               => esc_html__( 'Search Author', 'library-books' ),
	'popular_items'              => esc_html__( 'Popular Author', 'library-books' ),
	'all_items'                  => esc_html__( 'All Author', 'library-books' ),	
	'parent_item'       		 => esc_html__( 'Parent Author', 'library-books' ),
	'parent_item_colon' 		 => esc_html__( 'Parent Author:', 'library-books' ),
	'edit_item'                  => esc_html__( 'Edit Author', 'library-books' ),
	'update_item'                => esc_html__( 'Update Author', 'library-books' ),
	'add_new_item'               => esc_html__( 'Add New Author', 'library-books' ),
	'new_item_name'              => esc_html__( 'New Author Name', 'library-books' ),
	'separate_items_with_commas' => esc_html__( 'Separate Author with commas', 'library-books' ),
	'add_or_remove_items'        => esc_html__( 'Add or remove Author', 'library-books' ),
	'choose_from_most_used'      => esc_html__( 'Choose from the most used Author', 'library-books' ),
	'not_found'                  => esc_html__( 'No Author found.', 'library-books' ),
	'menu_name'                  => esc_html__( 'Author', 'library-books' ),
);

$ebooks_author_args = array(
	'hierarchical'          => true,
	'labels'                => $labels,
	'show_ui'               => true,
	'show_admin_column'     => true,
	'public'                => true,
	'update_count_callback' => '_update_post_term_count',
	'query_var'             => true,
	'rewrite'               => array( 'slug' => 'ebooks-author' ),
);	
$ebooks_author_args = apply_filters( 'library_ebooks_author_register_taxonomy', $ebooks_author_args, 'ebooks' );
register_taxonomy( 'ebooks-author', 'ebooks', $ebooks_author_args );

/* ebooks publisher */
$labels = array(
	'name'                       => esc_html__( 'Publishers', 'library-books' ),
	'singular_name'              => esc_html__( 'Publishers', 'library-books' ),
	'search_items'               => esc_html__( 'Publishers', 'library-books' ),
	'popular_items'              => esc_html__( 'Publishers', 'library-books' ),
	'all_items'                  => esc_html__( 'All Publishers', 'library-books' ),
	'parent_item'       		 => esc_html__( 'Parent Publishers', 'library-books' ),
	'parent_item_colon' 		 => esc_html__( 'Parent Publishers:', 'library-books' ),
	'edit_item'                  => esc_html__( 'Edit Publishers', 'library-books' ),
	'update_item'                => esc_html__( 'Update Publishers', 'library-books' ),
	'add_new_item'               => esc_html__( 'Add New Publishers', 'library-books' ),
	'new_item_name'              => esc_html__( 'New Publishers Name', 'library-books' ),
	'separate_items_with_commas' => esc_html__( 'Separate Publishers with commas', 'library-books' ),
	'add_or_remove_items'        => esc_html__( 'Add or remove Publishers', 'library-books' ),
	'choose_from_most_used'      => esc_html__( 'Choose from the most used Publishers', 'library-books' ),
	'not_found'                  => esc_html__( 'No Publishers found.', 'library-books' ),
	'menu_name'                  => esc_html__( 'Publishers', 'library-books' ),
);
$ebooks_publisher_args =  array(
	'hierarchical'          => true,
	'labels'                => $labels,
	'show_ui'               => true,
	'show_admin_column'     => true,
	'public'                => false,
	'update_count_callback' => '_update_post_term_count',
	'query_var'             => true,
	'rewrite'               => array( 'slug' => 'ebooks-publisher' ),
);
$ebooks_publisher_args = apply_filters( 'library_ebooks_tag_register_taxonomy', $ebooks_publisher_args, 'ebooks' );
register_taxonomy( 'ebooks-publisher', 'ebooks', $ebooks_publisher_args );