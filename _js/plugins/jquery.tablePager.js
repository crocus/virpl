/**
 * jQuery Plugin tablePager v1.0
 * Creates pagination for large tables.  tablePage hides all rows in the tbody of your
 * table and displays the rows in the current "page" of the table.  tablePager also
 * binds events and data to specified elements in the tfoot area of the table for paging
 * and information display.
 * 
 * USAGE:
 * 
 * jQuery("table").tablePager(options);
 * 
 * Copyright (c) 2008 David E Still [dave at stilldesigning dot com]
 * Available for use under the LGPL license
 * @author David E. Still, http://www.stilldesigning.com
 */
/**
 * Create pagination for large tables
 * 
 * @uses jQuery
 * 
 * @param Object opts JSON object of paging parameters
 * @param Integer opts_pagesize Number of table rows (<tr> tags) per page (default 15)
 * @param Integer opts_startpage First page displayed (default 1)
 * @param Object opts_selectors jQuery selectors to find buttons and data elements
 * @param String opts_selectors_next jQuery selector for "Next" button for paging forward through table.  All matching elements are captured for click events, and the current page is incremented by 1 when fired. (default ".pageNext")
 * @param String opts_selectors_prev jQuery selector for "Previous" button for paging back through table.  All matching elements are captured for click events, and the current page is decremented by 1 when fired. (default ".pagePrev")
 * @param String opts_selectors_page jQuery selector for elements displaying the current page number.  When the current page is updated, all matching elements are updated to display the current page number. (default ".pageNum")
 * @param String opts_selectors_count jQuery selector for elements displaying the total page count.  When tablePager is first called, all matching elements are updated to display the page count. (default ".pageCount")
 * 
 * @return jQuery element Returns the jQuery object representing the element
 */
jQuery.fn.tablePager = function() {
	var opts = jQuery.extend({
		pagesize: 15,
		startpage: 1,
		selectors: {
			next: ".pageNext",
			prev: ".pagePrev",
			page: ".pageNum",
			count: ".pageCount"
		},
		rowstyles: []
	}, arguments[0] || {});
	return this.each(function(){
		jQuery(this)[0].tablePager = {
			table: this,
			opts: opts,
			page: 1,
			showPage: function(page){
				var pagedTable = jQuery(this.table);
				var pagesize = this.opts.pagesize;
				var rows = pagedTable.find("tbody tr");
				page = parseInt(page,10);
				if (page < 1) { page = 1; }
				var count = Math.ceil(rows.length / pagesize);
				if (page > count) { page = count; }
				rows.removeClass(this.opts.rowstyles.join(" "));
				for (var i=0; i<rows.length; i++) {
					if (i>=(page-1)*pagesize && i<page*pagesize) {
						jQuery(rows[i]).addClass(this.opts.rowstyles[i % this.opts.rowstyles.length]);
						jQuery(rows[i]).show();
					}
					else { jQuery(rows[i]).hide(); }
				}
				this.page = page;
				pagedTable.find(this.opts.selectors.page).html(page);
				pagedTable.find(this.opts.selectors.count).html(count);
				return jQuery(this);
			},
			next: function() {
				var pagedTable = (arguments.length < 1)?jQuery(this):arguments[0].data;
				var page = pagedTable[0].tablePager.page;
				pagedTable[0].tablePager.showPage(page+1);
				return false;
			},
			prev: function() {
				var pagedTable = (arguments.length < 1)?jQuery(this):arguments[0].data;
				var page = pagedTable[0].tablePager.page;
				pagedTable[0].tablePager.showPage(page-1);
				return false;
			}
		};
		jQuery(this)[0].tablePager.showPage(opts.startpage);
		jQuery(this).find(jQuery(this)[0].tablePager.opts.selectors.next).bind("click", jQuery(this), jQuery(this)[0].tablePager.next);
		jQuery(this).find(jQuery(this)[0].tablePager.opts.selectors.prev).bind("click", jQuery(this), jQuery(this)[0].tablePager.prev);
	});
};
