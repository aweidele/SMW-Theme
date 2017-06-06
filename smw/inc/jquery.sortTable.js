/*!
 * Javascript To handle sorting
 *
 * Developed by Adam Fitzgarrald
 *
 * Designed by Wyman Projects / www.wymanprojects.com
 * 
 */
(function($){
	$.fn.sortTable= function(){
		var $wrapper = $(this);

		function sortResults(column, invert)
		{
			var items = [];
			
			$wrapper.children(".sortable-item").each(function(){
				items.push($(this));
			});
					
			if( invert ) {
				items.sort(function($a, $b){
					return $b.attr("data-sort-" + column).localeCompare($a.attr("data-sort-" + column));
				});
			} else {
				items.sort(function($a, $b){
					return $a.attr("data-sort-" + column).localeCompare($b.attr("data-sort-" + column));
				});
			}
			
			$.each(items, function(index, item){
				item.appendTo($wrapper);
			});
			
			$.cookie("sortTable-sort", column, { path: '/' });
			$.cookie("sortTable-sort-invert", invert, { path: '/' });
		}
		
		$wrapper.find(".sort-column").on("click.sortTable", function(e){
			e.preventDefault();
			var $this = $(this);
			
			//
			// Remove existing
			//
			if( !$this.hasClass("active") )
			{
				$wrapper.find(".sort-column.active").removeClass("active descending");
				$this.addClass("active");
			}
			
			$this.toggleClass("descending");
			
			sortResults( $this.data("sort-column"), !$this.hasClass("descending") );
		});
		
		var sort = $.cookie("sortTable-sort") || $wrapper.find(".sort-column").eq(0).data("sort-column");
		var invert = $.cookie("sortTable-sort-invert") === "true" || false;
		
		$wrapper.find(".sort-column").each(function(){
			var $this = $(this);
			
			if( $this.data("sort-column") == sort )
			{
				$this.addClass("active");
				
				if( !invert )
				{
					$this.addClass("descending");
				}
				sortResults( sort, invert );				
				return false;
			}
		});		
	}

})(jQuery);

