<?php
$args = array(
			'post_type'		=> 'ebooks',
			'posts_per_page'=> -1,
			'post_status'	=> 'publish',
			'orderby'       => 'date',
			'order'         => 'desc',
		);
		
if ( isset($_POST['action']) && $_POST['action'] != '' ) {
	if ( $_POST['s'] != '' ) {
		$args['s'] = $_POST['s'];		
	}
	
	/* Search from Publisher Taxonomy */
	if ( isset($_POST['publisher']) && $_POST['publisher'] != '' ) {
		$args['tax_query']['relation'] = 'OR';
		$args['tax_query'][]= array(
								'taxonomy' => 'ebooks-publisher',
								'field'    => 'id',
								'terms'    => $_POST['publisher'],
							);
	}
	
	/* Search from Author Taxonomy */
	if ( isset($_POST['author']) && $_POST['author'] != '' ) {
		$args['tax_query']['relation'] = 'OR';
		$args['tax_query'][]= array(
								'taxonomy' => 'ebooks-author',
								'field'    => 'id',
								'terms'    => $_POST['author'],
							);
	}
	
	/* Search from Rating custom field */
	if ( isset($_POST['_rating']) && $_POST['_rating'] != '' ) {
		$args['meta_query']['relation'] = 'AND';
		$args['meta_query'][]= array(
								'key' 		=> '_rating',
								'value'    	=> $_POST['_rating'],
								'compare'   => '=',
							);
	}
	
	/* Search from Price custom field */
	if ( isset($_POST['price']) && $_POST['price'] != '' ) {
		$price = str_replace( array('$',' ') , array('','') , $_POST['price']);
		$args['meta_query']['relation'] = 'AND';
		$args['meta_query'][]= array(
								'key' 		=> '_price',
								'value'    	=> explode('-', $price),
								'type'    => 'numeric',
								'compare' => 'BETWEEN',
							);
	}
}

$ebooks_posts = new WP_Query($args);
?>

<div id="library-book-lists" class="library-book-lists">
	<!-- I don't use table format but here I have used table format to reduce css. -->
	<table>
		<thead>
			<tr>
				<td><?php esc_html_e( 'No', 'library-books');?></td>
				<td><?php esc_html_e( 'Name', 'library-books');?></td>
				<td><?php esc_html_e( 'Price', 'library-books');?></td>
				<td><?php esc_html_e( 'Author', 'library-books');?></td>
				<td><?php esc_html_e( 'Publisher', 'library-books');?></td>
				<td><?php esc_html_e( 'Rating', 'library-books');?></td>
			</tr>
		</thead>
		<tbody id="load-book-lists">
	<?php if ( $ebooks_posts->have_posts() ) : ?>
		
		<?php $i=1; while ( $ebooks_posts->have_posts() ) : $ebooks_posts->the_post();  
		
				$_short_description	= get_post_meta( get_the_ID(), '_short_description', true);			
				$_price		= get_post_meta( get_the_ID(), '_price', true);				
				$_rating		= get_post_meta( get_the_ID(), '_rating', true);
				
				$ebooks_author = get_the_term_list( get_the_ID(), 'ebooks-author', '', ',') ;
				$ebooks_publisher = get_the_term_list( get_the_ID(), 'ebooks-publisher', '', ',') ;
				
				
		?>
			<tr>
				<td><?php echo $i++;?></td>
				<td>
					<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );  ?>
					<p><?php echo $_short_description;?></p>
				</td>
				<td>
					<?php 
					if ( $_price != '' ) {
						echo "<p>$" . $_price . "</p>";
					}
					
					?>
				</td>
				<td>
					<?php echo $ebooks_author;?>
				</td>				
				<td>
					<?php echo $ebooks_publisher;?>
					
				</td>
				<td>
					<?php
					$_rating = 'width:'.($_rating * 20).'%'; ?>
					<div class="book-star-rating-wrap">
						<div class="book-star-rating">
							<span style="<?php echo $_rating; ?>"></span>
						</div>
					</div>
					
				</td>
			</tr>
		<?php endwhile;?>
	<?php else:?>
		<tr>
			<td colspan="6"></td>
		</tr>
	<?php endif;
	wp_reset_postdata();
	?>
		</tbody>
	</table>
</div>