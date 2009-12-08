<?php
require('base2.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>
<body>
<div id="lenta" >
  <?php do { ?>
        <table id="o_lent" class="lenta" >
          <tbody >
          
              <tr  onclick="showPopup(<?php echo $row_Recordset1['flats_cod']; ?>)" >
                <td class="td_o_lent align_c" style=" width:90px;"><img src="base5.php?image=0&min=1&percent=0.1" alt=""></td>
                <td class="td_o_lent"><?php echo $row_Recordset1['room_cod']. '-комнатная, '. $row_Recordset1['street_name'].'<br/>'. $row_Recordset1['So']. ' кв.м., '. $row_Recordset1['flats_floor'].'/'.$row_Recordset1['flats_floorest'].' '. $row_Recordset1['material_short']. ', р-н '.$row_Recordset1['region_name']; ?></td>
                <td class="td_o_lent align_r" style=" width:100px;"><?php echo number_format($row_Recordset1['flats_price'], 0, '.', ' ').' руб.'; ?></td>
              </tr>
             
          </tbody>
        </table>
        
        </div>
        <table id="example" class="d_table" border="0" style="display:none;">
          <thead>
            <tr>
              <th>Дата постановки</th>
              <th>Тип</th>
              <th>Комнат</th>
              <th>Расположение</th>
              <th >Площади, <span style="white-space: nowrap;">(Sо/Sж/Sк)</span></th>
              <th>С/У</th>
              <th>Б/Л</th>
              <th>Цена</th>
              <th>Этаж</th>
            </tr>
          </thead>
              <tr  id="m_tr"  onmouseover="this.style.background='#FFCC33'" onMouseOut="this.style.background=''"  onclick="showPopup(<?php echo $row_Recordset1['flats_cod']; ?>)">
                <td ><?php echo $row_Recordset1['flats_date']; ?></td>
                <td><?php echo $row_Recordset1['type_s']; ?></td>
                <td><?php echo $row_Recordset1['room_cod']; ?></td>
                <td align="left"><?php echo $row_Recordset1['region_name']; ?><?php echo ", "; ?><?php echo $row_Recordset1['street_name']; ?></td>
                <td ><?php echo $row_Recordset1['So']; ?><?php echo "/"; ?><?php echo $row_Recordset1['Sz']; ?><?php echo "/"; ?><?php echo $row_Recordset1['Sk']; ?></td>
                <td><?php echo $row_Recordset1['wc_short']; ?></td>
                <td><?php echo $row_Recordset1['balcon_short']; ?></td>
                <td><?php echo $row_Recordset1['flats_price']; ?></td>
                <td align="center" style="white-space:nowrap;"><?php echo $row_Recordset1['flats_floor']; ?><?php echo "/"; ?><?php echo $row_Recordset1['flats_floorest']; ?> <?php echo $row_Recordset1['material_short']; ?></td>
              </tr>
             

        </table>
         <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        <table class="d_table">
          <tfoot align="center">
            <tr>
              <td  align="center">
                <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="_images/First.gif" alt=""></a>
                  <?php } // Show if not first page ?>                </td>
              <td  align="center">
                <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="_images/Previous.gif" alt=""></a>
                  <?php } // Show if not first page ?>                </td>
              <td align="center">
                <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="_images/Next.gif" alt=""></a>
                  <?php } // Show if not last page ?>                </td>
              <td align="center">
                <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="_images/Last.gif" alt=""></a>
                  <?php } // Show if not last page ?>                </td>
            </tr>
            <tr>
              <td  colspan="4" align="center"valign="center" >Объекты с <?php echo ($startRow_Recordset1 + 1) ?> по <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> из <?php echo $totalRows_Recordset1 ?> найденных в базе данных</td>
            </tr>
          </tfoot>
        </table>
</body>
</html>
