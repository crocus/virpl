<?php echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?".">"; ?><?php require_once('_scriptsphp/r_conn.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>���"�������"- ������������ ������������</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body bgcolor="#F1DABC">
<table width="187"  background="_images/starb.jpg" border="2"  bordercolor="#710000"cellpadding="1" cellspacing="2">
  <!--DWLayoutTable-->
  <tr><td style="width: 160px;" width="175" height="36" valign="top"><pre>���������� ���� ������
  <img src="_images/star.jpg" width="15" height="15" /><a href="outbase.php" target="mainFrame">���������</a> <br>  <img src="_images/star.jpg" width="15" height="15" /><a href="postf.html" target="mainFrame">�������</a></pre></td>
  </tr>
  <tr><td style="width: 160px;" height="39" valign="top"><pre>������ � ����� ������<br />  <img src="_images/star.jpg" width="15" height="15"/><a href="Insert.php"  target="mainFrame">��������� ������</a></pre></td>
  </tr>
    <tr>
    <td style="width: 160px;" height="39" valign="top"> <pre>  <img src="_images/star.jpg" width="15" height="15"/><a href="agents.php" target="mainFrame">������</a></pre></td>
  </tr>
   <tr>
    <td  valign="top"> <pre>������<br />  <img src="_images/star.jpg" width="15" height="15"/><a href="exchanges_a.php" target="mainFrame">����� �������</a>
  <img src="_images/star.jpg" width="15" height="15" /><a href="add_exchanges_a.php" target="mainFrame">�������� �����</a> </pre></td>
  </tr>
<tr>
    <td style="width: 160px;" height="39" valign="top"> <pre>������<br />  <img src="_images/star.jpg" width="15" height="15"/><a href="allpfs.php" target="mainFrame">�� �������</a> <br>  <img src="_images/star.jpg" width="15" height="15" /><a href="allpfb.php" target="mainFrame">�� �������</a></pre></td>
  </tr>
<tr><td style="width: 160px;"><form style="width: 170px;"method="GET"  scrolling="Yes" enctype="multipart/form-data" action="base1.php" target="mainFrame">
  <font size="2"> 
   </font>
        <div align="left"> <font size="2"> 
           <label>��������� :</label>
          <br>
          <select name="agency" style="width: 160px;" >
            <option selected> �������� �� ������ </option>
            <?php
	 mysql_select_db($database_realtorplus, $realtorplus);
	$query_Recordset1= "SELECT * FROM tbl_agency";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
            <?php do { ?>
            <option value ="<?php echo $row_Recordset1['agency_cod'] ; ?>"><?php echo $row_Recordset1['agency_name']; ?></option>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </select>
          <br></span>
		  <label>��� ������� :</label>
          <br>
          <select style="width: 160px;"name="type" >
            <option selected> �������� �� ������ </option>
            <?php
	 mysql_select_db($database_realtorplus, $realtorplus);
	$query_Recordset1= "SELECT * FROM tbl_type";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
            <?php do { ?>
            <option value ="<?php echo $row_Recordset1['type_cod'] ; ?>"><?php echo $row_Recordset1['type_s']; ?></option>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </select>
          <br></span>
          <label>���������� ������ : <br>
          <select style="width: 160px;"name="room" width="100" size="1">
            <option selected> �������� �� ������ </option>
            <?php
	$query_Recordset1= "SELECT * FROM tbl_room";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
            <?php do { ?>
            <option value ="<?php echo $row_Recordset1['room_cod'] ; ?>"><?php echo $row_Recordset1['room_short']; ?></option>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </select>
          <br>
          </label>
          <label>����� : <br>
          <select style="width: 160px;"name="region" width="100" size="1">
            <option selected> �������� �� ������ </option>
            <?php
	$query_Recordset1= "SELECT* FROM tbl_region";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
            <?php do { ?>
            <option value ="<?php echo $row_Recordset1['region_cod'] ; ?>"><?php echo $row_Recordset1['region_name']; ?></option>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </select>
          <br>
          </label>
          ����� :<br>
          <select style="width: 160px;"name="floor">
            <option selected> �������� �� ������ </option>
            <option value="noferst">�� ������</option>
            <option value="nolast">�� ���������</option>
            <option value="middle">�������</option>
          </select>
          <br>
          <label>������� �������/������ : <br>
          <select style="width: 160px;"name="balcon" width="100" size="1">
            <option selected> �������� �� ������ </option>
            <?php
	$query_Recordset1= "SELECT * FROM tbl_balcon";
  	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
   ?>
            <?php do { ?>
            <option value ="<?php echo $row_Recordset1['balcon_cod'] ; ?>"><?php echo $row_Recordset1['balcon_name']; ?></option>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </select>
          <br>
          </label></p>
          ����������� �� :<br>
          <select style="width: 160px;"name="order">
            <option selected> �������� �� ������ </option>
            <option value="date">���� ����������</option>
            <option value="room">���������� ������</option>
            <option value="type">����</option>
            <option value="price">����</option>
          </select>
          <br>
          </font><font size="5" face="Arial, Helvetica, sans-serif"><br>
    <input style="width: 70px;"type=submit name="Submit" value="   �����   "></font>
    <input style="width: 70px;"type="reset" name="Reset" value="   �����   ">
    <label></label></font>
    </font></font></div>
</form></td></tr>
</table>
</body>
</html>
