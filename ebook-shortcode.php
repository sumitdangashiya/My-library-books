<?php
/*
 * Search Book shortcode template file
 */
?>
<div class="library-book-shortcode">
	<div class="library-book-search-box">
		<h2><?php esc_html_e( 'Book Search', 'library-books' );?></h2>
		<form id="library-book-search-form" action="" >
			<div class="container">
				<div class="row">
					<div class="col-6">
						<label><?php esc_html_e( 'Book Name:', 'library-books' );?></label>
						<input type="text" name="s" value="" />
					</div>
					<div class="col-6">
						<label><?php esc_html_e( 'Author:', 'library-books' );?></label>
						<?php $ebook_author = library_book_custom_taxonomy( 'ebooks-author' );?>
						
						<select name="author">
							<option value=""><?php _e( 'Select Author', 'library-books' );?></option>
							<?php foreach( $ebook_author as $key=>$value ):?>
								<option value="<?php echo $key;?>"><?php echo $value;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-6">
						<label><?php esc_html_e( 'Publisher:', 'library-books' );?></label>
						<?php $ebook_publisher = library_book_custom_taxonomy( 'ebooks-publisher' );?>
						
						<select name="publisher">
							<option value=""><?php _e( 'Select Publisher', 'library-books' );?></option>
							<?php foreach( $ebook_publisher as $key=>$value ):?>
								<option value="<?php echo $key;?>"><?php echo $value;?></option>
							<?php endforeach;?>
						</select>
						
						
					</div>
					<div class="col-6">
						<label><?php esc_html_e( 'Rating:', 'library-books' );?></label>
						<select name="_rating">
							<option value="" ><?php _e( 'Select rating', 'library-books' );?></option>
							<?php for( $i=1; $i<=5; $i++):?>
								<option value="<?php echo $i?>"><?php echo $i;?></option>
							<?php endfor;?>
						</select>	
					</div>
				</div>
				
				<div class="row">
					<div class="col-12">
						<label><?php esc_html_e( 'Price:', 'library-books' );?></label>
						<input type="text" id="price" name="price" readonly />
						<div id="slider-range"></div>
					</div>				
				</div>
				<div class="row">
					<div class="col-12">
						<input type="submit" id="library-book-submit" name="submit" value="Search" />
					</div>				
				</div>
			</div>	
		</form>
	</div>

	<?php library_book_get_template( 'ebook-lists.php' ); ?>

</div>