<?php
/*
Plugin Name: Simple SEO for Paged Comments
Plugin URI: http://www.herewithme.fr
Version: 1.1
Description: Reduce SEO problems when using WordPress's paged comments. (title + content)
Author: Amaury BALMER
Author URI: http://www.herewithme.fr

Credits:

- Improved title
Author: Christian Schenk
Author URI: http://www.christianschenk.org

- Replace content by excerpt
Author: Austin Matzko
Author URI: http://www.pressedwords.com
*/

define ( 'PAGED_SUFFIX', ' - Comment page %d' );

class Seo_Paged_Comments {
	function Seo_Paged_Comments() {
		add_filter ( 'the_content', array (&$this, 'contentFilter' ) );
		add_filter ( 'single_post_title', array (&$this, 'titleFilter' ) );
	}
	
	function contentFilter($content = '') {
		global $cpage;
		if ($cpage < 1) {
			return $content;
		}
		
		remove_filter ( 'the_content', array (&$this, 'contentFilter' ) ); // Execute only once !
		return get_the_excerpt () . sprintf ( ' <p><a href="%1$s">%2$s</a></p> ', get_permalink (), get_the_title () . ' ' . __ ( '(more...)' ) );
	}
	
	function titleFilter($title = '') {
		global $cpage;
		if ($cpage < 1) {
			return $title;
		}
		
		return $title . sprintf ( PAGED_SUFFIX, $cpage );
	}
}

add_action ( 'plugins_loaded', 'initSeoPagedComments', 999 );
function initSeoPagedComments() {
	$seo_paged_comments = new Seo_Paged_Comments ( );
}
?>