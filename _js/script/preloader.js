  $.blockUI({
			css: { 
			border: 'none',
			padding: '10px',
			width: '300px',
			height: '75px'
		},
		overlayCSS:  {
		backgroundColor: 'white',
		opacity:          1,
		cursor:          'wait'
	},
		message:'<img src="../_images/loading.gif" /><p style="margin-top:5px; font: bold 14pt/12pt Arial, Verdana, Tahoma">Загрузка ...</p>'}); 
  $(document).ready($.unblockUI);