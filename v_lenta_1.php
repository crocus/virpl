<?php
ob_start("ob_gzhandler");
include('base2.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Представление в виде ленты</title>
        <!--<script type="text/javascript" src="_js/jquery/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="../_js/jquery/ui/jquery-ui-1.7.custom.js"></script>-->
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>-->
        <!--<script type="text/javascript" src="_js/plugins/jquery.carousel.pack.js"></script>-->
        <!--<script type="text/javascript" src="_js/plugins/lightbox/js/jquery.lightbox.min.js"></script>-->
        <!--<script type="text/javascript" src="_js/script/view_detail.js"></script>-->
        <script type='text/javascript' src="/min/?g=jsframe"></script>
        <!--<script type='text/javascript' src="/min/?g=jsl"></script>
        <link href="_style/iframe.min.css" rel="stylesheet" type="text/css" />-->
        <link href="/min/?g=cssframe" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="objects">
            <table id="o_lent" class="lenta d_table">
                <tbody>
                    <?php if($totalRows_Recordset1>0) {
                        do { ?>
                    <tr onclick="showPopup(<?php echo $row_Recordset1['flats_cod']; ?>)" >
                        <td class="align_c" style=" width:90px;"><?php if( $row_Recordset1['foto'] != 0) echo '<img src="base5.php?id_image='. $row_Recordset1['flats_cod'] .'&amp;category=0&amp;image=0&amp;min=1&amp;percent=0.12" alt="" />'?></td>
                        <td class="align_l"><?php $count_r = $row_Recordset1['room_cod'];
                                    $text = '<span class="lentheader">';
                                    switch ( $row_Recordset1['type_s']) {
                                        case 'дом':
                                            if ($row_Recordset1['room_cod']!=0) {
                                                $text .= 'Дом, '.$count_r. ' комн., ';
                                            } else {
                                                $text .= 'Дом, ';
                                            }
                                            break;
                                        case 'квартира':
                                            if ($row_Recordset1['room_cod']!=0) {
                                                $text .= $count_r. '-комнатная, ';
                                            } else {
                                                $text .= 'Гостинка, ';
                                            }
                                            break;
                                        case 'подселение':
                                            if ($row_Recordset1['room_cod']!=0) {
                                                $text .= 'Подселение, '.$count_r. ' комн., ';
                                            } else {
                                                $text .= 'Подселение, ';
                                            }
                                            break;
                                        case 'офис':
                                            if ($row_Recordset1['room_cod']!=0) {
                                                $text .= 'Офис, '.$count_r. ' каб., ';
                                            } else {
                                                $text .= 'Офис, ';
                                            }
                                            break;
                                        case 'строение':
                                            $text .= 'Отдельностоящее строение, ';
                                            break;
                                        case 'производство':
                                            $text .= 'Производственно-складское помещение, ';
                                            break;
                                        case 'торговля':
                                            $text .= 'Торговое помещение, ';
                                            break;
                                        case 'коттедж':
                                            $text .= 'Коттедж, ';
                                            break;
                                        case 'под застройку':
                                            $text .= 'Земли поселений (под застройку), ';
                                            break;
                                        case 'дача':
                                            $text .= 'Садоводческий участок (дача), ';
                                            break;
                                        default :
                                            $text .= $count_r. '-комнатная, ';
                                            break;
                                    }
                                    $text .= $row_Recordset1['street_name'].'</span><br/><span class="lentbody">'. $row_Recordset1['So']. ' кв.м., '. $row_Recordset1['flats_floor'].'/'.$row_Recordset1['flats_floorest'].' '. $row_Recordset1['material_short']. ', '. (($row_Recordset1['region_name']==$row_Recordset1['city_name']) ? $row_Recordset1['city_name']: 'р-н '. $row_Recordset1['region_name']).'</span>';
                                    echo $text;?></td>
                        <td class="align_r" style=" width:100px;"><?php echo '<span class="lentprice">' . number_format($row_Recordset1['flats_price'], 0, '.', ' ').' руб.</span>'; ?></td>
                        <td class="trs-exchanges hide" valign="top" width="15%"><div style=" text-align:left; font-size:10px; color:#4A4A4A; padding-left:5px;"><?php
                                        if($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='0') {
                                            echo 'Получено с сайта.<br/><span class="red">Необработано.</span>';
                                        } elseif($row_Recordset1['Source']=='0' && $row_Recordset1['Treated']=='1') {
                                            echo 'Получено с сайта.<br/>Обработал(а):<br/>'. $row_Recordset1['agent_name'];
                                        } else {
                                            echo 'Разместил(а):<br/>'. $row_Recordset1['agent_name'];
                                        };
                                        ?></div></td>
                    </tr>
                        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                </tbody>
            </table><br />
            <table class="d_table">
                <tfoot>
                    <tr>
                        <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" alt="" /></a>
                                <?php } // Show if not first page ?>
                        </td>
                        <td ><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" alt="" /></a>
                                <?php } // Show if not first page ?>
                        </td>
                        <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" alt="" /></a>
                                <?php } // Show if not last page ?>
                        </td>
                        <td ><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" alt="" /></a>
                                <?php } // Show if not last page ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"  valign="center" >Объекты с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> найденных в базе данных
                        <?php } else { echo "Отсутствуют объявления, удовлетворяющие условиям, Вашего запроса.";}?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="card" style="display:none;padding:10px;"></div>
        <script type="text/javascript">
            var modeview = $.cookie("modeview");
            var obj_AvailableAgents = "";
            $(document).ready(function(){
                if (modeview == null) {
                    modeview = "review";
                    $.cookie("modeview", "review");
                }
                createModeView(modeview);
                $.getJSON("../_scriptsphp/session_var.php", function(json){
                    var use = json.use;
                    if(use == 1){
                        $('td.trs-exchanges').removeClass("hide").addClass("show");
                        if ( parseInt(json.role) <= 1) {
                            bind_id = json.id;
                        } else {
                            bind_id = json.group;
                        }
                        $.cookie("inquery", bind_id);
                        var agent_t = $.ajax({
                            url: "../_scriptsphp/get_parameters.php",
                            data: "parameter=agent",
                            async: false
                        }).responseText;
                        obj_AvailableAgents = eval("(" + agent_t + ")");

                    }
                });
                $(window).unload( function () {	if ($.cookie("_filedir") != null)
                        $.post("../_scriptsphp/trimming.php");
                } );
            });
        </script>
    </body>    
</html>
<?php
ob_end_flush();
?> 
