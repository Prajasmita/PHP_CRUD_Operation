<!--Database Connection-->
<?php

//ini_set('display_errors', '1'); //php function for displaying error
require 'database_connection.php';?>

<!--Delete Data-->
<?php
if(isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    $query = "DELETE From products WHERE id=$id";
    $fire = mysqli_query($conn,$query) or die("cannot delete");
    if($fire) {
        $res = "Data deleted sucessfully";
        header("location:product_list.php");
    }
}
?>

<!--pagination-->
<?php

/*$query= "SELECT * FROM category";
$result= mysqli_query($conn,$query) or die("cannot fetch data");
$total_rows = mysqli_num_rows($result);*/
$result=$conn->query("SELECT count(*) FROM products");

$rows = mysqli_fetch_row($result);
$total_rows = $rows[0];

$limit = 2;
$offset = 0;

if(isset($_GET['page']))
{
    $page = $_GET['page'];
    $offset = ($page -1) * $limit;
    //print_r($offset);die;
}
else
{
    $page=1;
}

$total_pages = ceil($total_rows / $limit);

//$result = $conn->query("SELECT  p.id,p.name,p.image,p.price,c.name as c_name from products p join category c on category_id=c.id $offset,$limit ");

/*$result= mysqli_query($conn,$select_sql) or die("cannot fetch data");*/
?>








<?php require ('header.php') ?>

    <div class="section banner_section who_we_help">
        <div class="container">
            <h4>Manage Product</h4>
        </div>
    </div>

    <!-- Content Section Start-->
    <div class="section content_section">
        <div class="container">
            <div class="filable_form_container">
                <form action="delete_bulk_product.php" id="form_delete" method="post">
                <div class="mange_buttons">
                    <ul>
                        <!--<li class="search_div">
                     <div class="Search">
                         <input name="search" type="text" />
                         <input type="submit" class="submit" value="submit">
                     </div>
                        </li> -->
                        <li><a href="add_product.php">Add Product</a></li>
                        <li><a href="category_list.php">Category List</a></li>
                        <li>

                            <a href="#"  onclick="deleteConfirm()" id="delete" name="delete" class="btn btn_edit">Delete</a>
                        </li>
                    </ul>
                </div>
                <div class="table_container_block">
                    <table width="100%">
                        <thead>
                        <tr>
                            <th width="10%">
                                <input type="checkbox" class="checkbox" id="bulk_select" /> <label class="css-label mandatory_checkbox_fildes" for="bulk_select"></label>
                            </th>
                            <th style="">Product Name </th>
                            <th style="">Product Image</th>
                            <th style="">Product Price</th>
                            <th style="">Product Category</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $query= "SELECT  p.id,p.name,p.image,p.price,c.name as c_name from products p join category c on category_id=c.id limit $offset,$limit ";
                        $products = mysqli_query($conn,$query)or die("cannot fetch");


                        if( mysqli_num_rows($products) > 0){

                            while($product=mysqli_fetch_assoc($products)){
                                ?>
                                <tr id="<?php echo $product["id"]; ?>">
                                    <td>
                                        <input type="checkbox" class="checkbox" value="<?php echo $product['id'] ?>" name="checkbox[]" id="checkbox_sample<?php echo $product['id'] ?>" />
                                        <label class="css-label mandatory_checkbox_fildes" for="checkbox_sample<?php echo $product['id'] ?>"></label>
                                    </td>
                                    <td><?php echo $product['name'] ?></td>
                                    <td><img class="image" src="<?php echo "photo/".$product['image'] ?>"></td>
                                    <td><?php echo $product['price'] ?></td>


                                    <td><?php echo $product['c_name']; ?></td>

                                    <td>
                                        <div class="buttons">
                                            <a href="update_product.php?product_id=<?php echo $product['id'] ?>" name="btn-edit" class="btn btn_delete">update</a>
                                            <a href="<?php $_SERVER['PHP_SELF']?>?product_id=<?php echo $product['id'] ?>" name="btn-delete" class="btn btn_edit" onclick="Delete()">Delete</a>
                                        </div>
                                    </td>
                                </tr>


                                <?php
                            }
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






    <?php require ('footer.php') ?>
<!--wrapper-starts-->

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.select').each(function(){
            var title = $(this).attr('title');
            if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
            $(this).css({'z-index':10,'opacity':0,'-khtml-appearance':'none'}).after('<span class="select">' + title + '</span>').change(function(){
                val = $('option:selected',this).text();
                $(this).next().text(val);
            })
        });
    });


</script>

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


<!--<script type="text/javascript">
    $(document).ready( function() {

        // select ans deselect all checkbox
        $('#bulk_select').on('click', function (e) {
            if ($(this).is(':checked', true)) {
                $(".checkbox").prop('checked', true);
            }
            else {
                $(".checkbox").prop('checked', false);
            }
        });

    });
-->


</body>
</html>