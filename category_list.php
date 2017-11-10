<!--Database Connection-->
<?php

//ini_set('display_errors', '1'); //php function for displaying error
require 'database_connection.php';?>

<!--Fetching Data-->
<?php

/*$query= "SELECT * FROM category";
$result= mysqli_query($conn,$query) or die("cannot fetch data");
$total_rows = mysqli_num_rows($result);*/
$result=$conn->query("SELECT count(*) FROM category");

$rows = mysqli_fetch_row($result);
$total_rows = $rows[0];

$limit = 3;
$offset = 0;

if(isset($_GET['page']))
{
    $page = $_GET['page'];
    $offset = ($page -1) * $limit;
}
else
{
    $page=1;
}

$total_pages = ceil($total_rows / $limit);

$result = $conn->query("SELECT * FROM category limit $offset,$limit ");

/*$result= mysqli_query($conn,$select_sql) or die("cannot fetch data");*/
?>


<!--Delete Data-->
<?php
    if(isset($_GET['category_id'])) {
       $id = $_GET['category_id'];
        $query = "DELETE From category WHERE id=$id";
        $fire = mysqli_query($conn,$query) or die("cannot delete");
        if($fire) {
         $res = "Data deleted sucessfully";
         header("location:category_list.php");
        }
    }
?>


<?php require ('header.php');?>

  <div class="section banner_section who_we_help">
  	<div class="container">
  		<h4>Manage Category</h4>
  	</div>
  </div>

  <!-- Content Section Start-->
  <div class="section content_section">
	<div class="container">
		<div class="filable_form_container">
			<div class="mange_buttons">
				<ul>
					<!--<li class="search_div">
				 <div class="Search">
				 	<input name="search" type="text" /> 
				 	<input type="submit" class="submit" value="submit">
				 </div>
					</li> -->
					<li><a href="index.php">Create Category</a></li>
					<li><a href="#">Delete</a></li>
				</ul>
			</div>
			<div class="table_container_block">
				<table width="100%">
					<thead>
                    <!--<h3><?php /*echo $res*/?></h3>-->
						<tr>
						<th width="10%">
							<input class="checkbox" id="checkbox_sample18" type="checkbox"> <label class="css-label mandatory_checkbox_fildes" for="checkbox_sample18"></label>
						</th>
						<th style="width:60%">Name <!--<a href="#" class="sort_icon"><img src="images/sort.png"></a>--></th>
						<th>Action</th>
						</tr>
					</thead>

					<tbody>
                    <?php
                        if(!empty($result)){
                            /*printing various rows in table
                            mysqli_fetch_object($result)-->giving data with fields from database
                            */
                            while ($row = mysqli_fetch_assoc($result)){
                   ?>
                                <tr>
                                    <td>
                                        <input class="checkbox" value="<?php echo $row['id'] ?>" id="name" type="checkbox" > <label class="css-label mandatory_checkbox_fildes" for="checkbox_sample19"></label>
                                    </td>
                                    <td><?php echo $row['name'];?></td>
                                    <td>
                                        <div class="buttons">
                                            <a href="category_update.php?category_id=<?php echo $row['id'] ?>" name="btn-edit" class="btn btn_delete">update</a>
                                            <a href="<?php $_SERVER['PHP_SELF']?>?category_id=<?php echo $row['id'] ?>" name="btn-delete" class="btn btn_edit" onclick="Delete()">Delete</a>
                                        </div>
                                    </td>
                                </tr>

                    <?php        }
                        }
                    ?>
					</tbody>
				</table>
			</div>
			
			<div class="pagination_listing">
               <?php
/*                    $page_query = "SELECT * FROM category ORDER BY id ASC ";
                    $page_result = mysqli_query($conn,$page_query);
                    $total_records = mysqli_num_rows($page_result);
                    $total_pages = ceil($total_records/$record_per_page);
                    for($i=1 ; $i<= $total_pages; $i++)
                    {
                        echo '<a href="pagination.php?page='.$i.'">'.$i.'</a>';
                    }

                */?>
                <ul>
                    <?php
                    if($page > 1){
                        ?>
                        <li><a href="?page=<?php echo ($page-1);?>">Prev</a></li>
                        <?php
                    }
                    for($i = 1;$i <= $total_pages ;$i++){

                    ?>
                     <li><a href="?page=<?php echo $i; ?>"

                           <?php if (($page == "") || ($_GET['page'] == $i)) {
                         echo ' class="active"';
                         }?>


                         ><?php echo $i; ?></a></li>
                    <?php
                    }

                    if($page != $total_pages){
                    ?>
                    <li><a href="?page=<?php echo ($page+1); ?>">Next</a></li>
                    <?php
                    }
                    ?>
                </ul>
			</div>

		</div>
	</div>		
  </div>
  <!-- Content Section End-->





<?php require ('footer.php');?>