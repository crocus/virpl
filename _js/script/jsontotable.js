function drawtable(inputjson, mydiv)
{
var i, imax, shtml;
var inputjson = "{'records': [{'id':'234','name':'marco','age':24},{'id':'0783', 'name':'silvia','age':33}]}";
 
var myJSONobj = eval('(' + inputjson + ')');   //convert the data to an object - prefer JSON parse here
 
var irowmax = myJSONobj.records.length;
 
if (irowmax < 1) {
  alert ('No rows in table');
  return;
  }
 
 
var cols = new Array();
                                        //get an array of column names
for (var key in myJSONobj.records[0]) {  //assumign all columns present in first record
   cols[cols.length] = key;
   }
 
icolmax = cols.length
 
shtml = "<table border=1><tr>";          //create header row - save html of table in shtml
for (i=0;i<icolmax;i++) {
  shtml += "<th>" + cols[i] + "</th>";
  }
shtml += "</tr>";
 
 
var irowmax = myJSONobj.records.length;
 
for (irow = 0; irow < irowmax; irow++) {  //add the rows
  shtml += "<tr>";
  for (i=0;i<icolmax;i++) {
    shtml += "<td>" + myJSONobj.records[irow][cols[i]] + "</td>";
    }
  shtml += "</tr>";
  }
 
document.getElementById(mydiv).innerHTML = shtml;   //write the table into div mydiv
}