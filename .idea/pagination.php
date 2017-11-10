<?php
/*pagination*/
$record_per_page = 5;
$page = '';
if(isset($_GET['page'])){
    $page = $_GET['page'];
}
else{
    $page = 1 ;
}
$start_from = ($page-1)*$record_per_page;

//fetching data from database
$select_sql = "SELECT * FROM category ORDER BY id ASC LIMIT $start_from,$record_per_page";
//using object data taken in result
$result = mysqli_query($conn,$select_sql) or die("cannot fetch data");

?>