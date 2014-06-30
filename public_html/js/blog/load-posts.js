jQuery(document).ready(function($) {
	// The number of the next page to load (/page/x/).
	var pageNum = parseInt(pbd_alp.startPage) + 1;
	// The maximum number of pages the current query can return.
	var max = parseInt(pbd_alp.maxPages);
	// The link of the next page of posts.
	var nextLink = pbd_alp.nextLink;
	// Localization
	var showMore = ( typeof ct_blog_localization != 'undefined' || ct_blog_localization != null ) ? ct_blog_localization.show_more : "Mostrar mais Artigos";
		loadingPosts = ( typeof ct_blog_localization != 'undefined' || ct_blog_localization != null ) ? ct_blog_localization.loading_posts : "Carregando Artigos...";
	/**
	* Replace the traditional navigation with our own,
	* but only if there is at least one page of new posts to load.
	*/
	if(pageNum <= max) {
		// Insert the "More Posts" link.
		$('#entry-blog')
			.append('<div class="pbd-alp-placeholder-'+ pageNum +'"></div>')
			.append('<div id="pbd-alp-load-posts"><a href="#">'+ showMore +'</a></div>');
		// Remove the traditional navigation.
		$('.blog-navigation').remove();
	}
	/**
	 * Load new posts when the link is clicked.
	 */
	$('#pbd-alp-load-posts a').click(function() {
		// Are there more posts to load?
		if(pageNum <= max) {
			// Show that we're working.
			$(this).text(loadingPosts);
			$('#pbd-alp-load-posts').append('<i class="fa fa-spinner fa-spin"></i>');
			$('.pbd-alp-placeholder-'+ pageNum).load(nextLink + ' .post',
				function() {
		$('a[data-rel]').each(function() {
			$(this).attr('rel', $(this).data('rel'));
		});
		$("a[rel^='prettyPhoto']").prettyPhoto({
			animationSpeed: 'normal', /* fast/slow/normal */
			opacity: 0.80, /* Value between 0 and 1 */
			showTitle: false, /* true/false */
			theme:'light_square',
			deeplinking: false
		});
					jQuery(".post-like a").click(function(){
						heart = jQuery(this);
						post_id = heart.data("post_id");
						jQuery.ajax({
							type: "post",
							url: ajax_var.url,
							data: "action=post-like&nonce="+ajax_var.nonce+"&post_like=&post_id="+post_id,
							success: function(count){
								if(count != "already") {
									heart.addClass("voted");
									heart.siblings(".count").text(count);
								}
							}
						});
						return false;
					})
					noPosts = ( typeof ct_blog_localization != 'undefined' || ct_blog_localization != null ) ? ct_blog_localization.no_posts : "Nenhum artigo anterior";
					// Update page number and nextLink.
					pageNum++;
					nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);
					$( ".fa-spinner" ).remove();
					// Add a new placeholder, for when user clicks again.
					$('#pbd-alp-load-posts')
						.before('<div class="pbd-alp-placeholder-'+ pageNum +'"></div>')
					// Update the button message.
					if(pageNum <= max) {
						$('#pbd-alp-load-posts a').text(showMore);
					} else {
						$('#pbd-alp-load-posts a').text(noPosts);
						$('#pbd-alp-load-posts a').css('display','none');
						$('#pbd-alp-load-posts').append('<div class="pbd-no-posts">'+noPosts+'</div>');
					}
				}
			);
		} else {
			$('#pbd-alp-load-posts a').append('.');
		}
		return false;
	});
});