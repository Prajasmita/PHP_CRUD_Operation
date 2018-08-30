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

$limit = 5;
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
            <form action="delete_bulk_category.php" id="form_delete" method="post">
                <div class="mange_buttons">
                    <ul>
                        <!--<li class="search_div">
                     <div class="Search">
                         <input name="search" type="text" />
                         <input type="submit" class="submit" value="submit">
                     </div>
                        </li> -->
                        <li><a href="product_list.php">Product List</a></li>

                        <li><a href="add_category.php">Create Category</a></li>

                        <li>

                            <a href="#"  onclick="deleteConfirm()" id="delete" name="delete" class="btn btn_edit">Delete</a>
                        </li>

                    </ul>
                </div>
                <div class="table_container_block">
                    <table width="100%">
                        <thead>
                        <!--<h3><?php /*echo $res*/?></h3>-->
                        <tr>
                            <th width="10%">
                                <input type="checkbox" class="checkbox" id="bulk_select" /> <label class="css-label mandatory_checkbox_fildes" for="bulk_select"></label>
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
                                <tr id="<?php echo $row["id"]; ?>">

                                    <!--                                    <td><input name="checkbox[]" type="checkbox" class="checkbox" id="--><?php //echo $row["id"]; ?><!--"></td>-->

                                    <td>
                                        <input type="checkbox" name="checkbox[]" value="<?php echo $row['id'] ?>" class="checkbox" id="checkbox_sample<?php echo $row['id'] ?>" />
                                        <label class="css-label mandatory_checkbox_fildes" for="checkbox_sample<?php echo $row['id'] ?>"></label>
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
            </form>
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

                                <?php if (($page == "") || ($page == $i)) {
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

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

    function deleteConfirm(){
        var result = confirm("Are you sure to delete?");
        if(result){
//            return true;
            $("#form_delete").submit();
        }else{
            return false;
        }
    }


    $(document).ready( function() {
        // select ans deselect all checkbox
        $('#bulk_select').on('click', function(e) {
            if($(this).is(':checked',true)) {
                $(".checkbox").prop('checked', true);
            }
            else {
                $(".checkbox").prop('checked',false);
            }
        });
    });
</script>

<?php require ('footer.php');?>