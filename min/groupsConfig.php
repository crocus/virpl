<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 **/

return array(
'js' => array(
'//_js/jquery/jquery-1.3.2.min.js',
//'//_js/jquery/jquery-1.5.min.js',
'//_js/jquery/ui/jquery-ui-1.7.custom.js',
'//_js/plugins/jquery.form.js',
// '//_js/plugins/tools.tabs-1.0.1.min.js',			   
'//_js/plugins/jquery.history.js',
'//_js/jquery/external/bgiframe/jquery.bgiframe.min.js',
'//_js/jquery/external/cookie/jquery.cookie.min.js',
'//_js/plugins/jquery-treeview/jquery.treeview.min.js',
'//_js/plugins/jquery-treeview/jquery.treeview.async.js',
'//_js/plugins/jqueryslidemenu/js/jqueryslidemenu.js',
'//_js/plugins/jquery.cycle.all.min.js',
'//_js/plugins/jquery.carousel.pack.js',
'//_js/plugins/jquery.validate.min.js',
// '//_js/plugins/jquery.metadata.js',
'//_js/plugins/messages_ru.js',
'//_js/plugins/jquery.blockUI.js',
'//_js/plugins/jquery.scrollTo-min.js',
'//_js/plugins/jquery.serialScroll-min.js',
'//_js/plugins/ext_libs/md5.js',
'//_js/script/ajaxupload.3.6.js',
'//_js/plugins/jquery-lightbox-0.5/js/jquery.lightbox-0.5.js',
'//_js/script/services.js',
'//_js/plugins/jquery.json-1.3.js',
//   '//_js/plugins/jquery.autoheight.js',
// '//_js/plugins/iframe.js',
//  '//_js/plugins/jquery.ifixpng.js',
//'//_js/plugins/trivial.loadprocess.js',
//'//_js/plugins/jquery.simpleMultiSelect.js',
'//_js/plugins/jquery-autocomplete/jquery.autocomplete.min.js'),
'jsframe' => array(//'//_js/jquery/jquery-1.5.min.js',
'//_js/jquery/jquery-1.3.2.min.js',
'//_js/jquery/ui/jquery-ui-1.7.custom.js',
'//_js/plugins/jquery.blockUI.js',
'//_js/script/view_detail.js',
'//_js/plugins/jquery.form.js',
'//_js/plugins/jquery.validate.min.js',
'//_js/script/jquery-idleTimeout.js',
'//_js/jquery/external/cookie/jquery.cookie.min.js',
'//_js/plugins/jquery.json-1.3.js',
'//_js/plugins/ext_libs/md5.js',
'//_js/script/ajaxupload.3.6.js',
//'//_js/plugins/jquery.ifixpng.js',
'//_js/plugins/jquery-lightbox-0.5/js/jquery.lightbox-0.5.js',
'//_js/script/services.js',
'//_js/plugins/jquery.scrollTo-min.js'),
'jstape' => array('//_js/script/v_lenta.js'),
'cssframe' => array('//_style/iframe.min.css',
'//_js/plugins/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css',
'//_js/plugins/lightgallery/skins/default/style.css'),
'css' => array('//_js/jquery/themes/redmond/jquery-ui-1.7.2.custom.css',
/*'_js/jquery/themes/smoothness/ui.core.css',
'//_js/jquery/themes/smoothness/ui.resizable.css',
'//_js/jquery/themes/smoothness/ui.accordion.css',
'//_js/jquery/themes/smoothness/ui.dialog.css',
'//_js/jquery/themes/smoothness/ui.slider.css',
'//_js/jquery/themes/smoothness/ui.tabs.css',
'//_js/jquery/themes/smoothness/ui.datepicker.css',
'//_js/jquery/themes/smoothness/ui.progressbar.css',
'//_js/jquery/themes/smoothness/ui.theme.css',*/
'//_style/style-color.css',
'//_style/tabs-accordion-redmond.css',
'//_style/carousel.css',
'//_js/plugins/jquery-treeview/jquery.treeview.css',
'//_js/plugins/jqueryslidemenu/css/jqueryslidemenu-redmond.css',
'//_style/top_menu_a.css',
'//_js/plugins/jquery-autocomplete/jquery.autocomplete.css',
'//_js/plugins/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css')

// custom source example
	/*'js2' => array(
		dirname(__FILE__) . '/../min_unit_tests/_test_files/js/before.js',
		// do NOT process this file
		new Minify_Source(array(
			'filepath' => dirname(__FILE__) . '/../min_unit_tests/_test_files/js/before.js',
			'minifier' => create_function('$a', 'return $a;')
		))
	),//*/

	/*'js3' => array(
		dirname(__FILE__) . '/../min_unit_tests/_test_files/js/before.js',
		// do NOT process this file
		new Minify_Source(array(
			'filepath' => dirname(__FILE__) . '/../min_unit_tests/_test_files/js/before.js',
			'minifier' => array('Minify_Packer', 'minify')
		))
	),//*/
);