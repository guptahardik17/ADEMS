<?php
//connect to the mysql
$db = mysql_connect('localhost', 'prayaasc', '******') or die("Could not connect database");
mysql_select_db('prayaasc_adems', $db) or die("Could not select database");
 
//database query
$sql = mysql_query("select lat,lon from location");
 
$rows = array();
while($r = mysql_fetch_assoc($sql)) {
  $rows[] = $r;
}
 
//echo result as json
echo json_encode($rows);
?>