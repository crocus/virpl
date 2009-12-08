jQuery(document).ready(function(){
jQuery("#list2").jqGrid({
   	url:'../../base6.php',
	height: '100%',
	datatype: "json",
	colNames:['foto','flats_cod','Дата постановки','Комнат','Площади, (Sо/Sж/Sк)','Расположение','С/У','Б/Л','Цена','Этаж'],
   	colModel:[
		/*{name:'foto',index:'foto', width:40, sortable:false},
   		{name:'flats_cod',index:'flats_cod', width:"auto"},
   		{name:'flats_date',index:'flats_date', width:80},
		{name:'room_cod',index:'room_cod', width:50, align:"center"},
   		{name:'square',index:'square', width:80, align:"center", sortable:false},			  		
   		{name:'inplace',index:'inplace', width:"auto", sortable:false},
   		{name:'wc_short',index:'wc_short', width:40, align:"center"},		
   		{name:'balcon_short',index:'balcon_short', width:40, align:"center"},
		{name:'flats_price',index:'flats_price', width:80,align:"right"},
   		{name:'floor',index:'floor', width:80, align:"center",sortable:false}*/
		{name:'foto',index:'foto', width:"auto", sortable:false},
   		{name:'flats_cod',index:'flats_cod', width:"auto"},
   		{name:'flats_date',index:'flats_date', width:"auto"},
		{name:'room_cod',index:'room_cod', width:50, align:"center"},
   		{name:'square',index:'square', width:80, align:"center", sortable:false},			  		
   		{name:'inplace',index:'inplace', width:"auto", sortable:false},
   		{name:'wc_short',index:'wc_short', width:40, align:"center"},		
   		{name:'balcon_short',index:'balcon_short', width:40, align:"center"},
		{name:'flats_price',index:'flats_price', width:80,align:"right"},
   		{name:'floor',index:'floor', width:80, align:"center",sortable:false}	
   	],
   	rowNum:10,
   	rowList:[10,15,20,25,50],
   	imgpath: gridimgpath,
	altRows: true,
	toolbar: [true,"top"],
   	pager: $('#pager2'),
   	sortname: 'flats_date',
    viewrecords: true,
    sortorder: "desc",
	loadComplete :function () {
			jQuery("#list2").hideCol(['foto','flats_cod']);
	},
    caption:"Test"
}).navGrid('#pager2',{edit:false,add:false,del:false});
jQuery("#list2").setGridParam({
		onSelectRow : function(flats_cod) {
			jQuery("#tabs").tabs('option', 'selected', 2);
			jQuery("#resp").html("I'm row number: "+ flats_cod +" and setted dynamically").css("color","red");
		}
	});
jQuery("#vcol").click(function (){
	jQuery("#list2").setColumns();
	});
});

