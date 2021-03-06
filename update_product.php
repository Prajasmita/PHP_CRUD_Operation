<?php
require ('database_connection.php');
?>
<?php

if(isset($_GET['product_id']))
{
    $id = $_GET['product_id'];
    $query = "SELECT * FROM products WHERE id=$id";
    $fire = mysqli_query($conn,$query) or die("cannot fetch");
   /* if($fire)
        echo "we got";*/
    $fetched_row=mysqli_fetch_assoc($fire);

}
?>

<!--Create Product With Validation-->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-btn'])) {
    $product_name = "";
    $product_price = "";

    $product_name_error = "";
    $product_price_error = "";


    if (empty($_POST["product_name"]) || empty($_POST["product_price"])) {

        if (empty($_POST["product_name"]))
            $product_name_error = "Product Name is required";

        if (empty($_POST["product_price"]))
            $product_price_error = "Product price is required";
    } else {
        $check_name = preg_match("/^[a-zA-Z0-9 ]*$/", $_POST["product_name"]);
        $check_price = preg_match("/^\d+(\.\d{1,2})?$/", $_POST["product_price"]);

        if (!$check_name || !$check_price) {
            if (!$check_name)
                $product_name_error = "Product name should be alphanumeric.";

            if (!$check_price)
                $product_price_error = "Product price should be in decimal";
        } else {

            $product_name = ucwords($_POST['product_name']);
            $product_price = $_POST['product_price'];
            $category_id = $_POST['category'];
            // print_r($category_id); die;

            $id = $_POST['product_id'];

            $name = $_FILES['product_image']['name'];
            $target_dir = "photo/";
            $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
            // print_r($target_dir); die;
            //file type
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            //validation for file extensions
            $extensions_arr = array("jpg", "png");


            // Checking for extension
            if (in_array($imageFileType, $extensions_arr)) {

                $query="UPDATE products SET name='$product_name' , price='$product_price' , image= '$name' , category_id='$category_id' where id=".$id."";
                $fire = mysqli_query($conn,$query)or die("cannot update");


                if ($fire) {
                    // Upload file
                    move_uploaded_file($_FILES['product_image']['tmp_name'], $target_dir . $name);
                    /* echo "Product added";*/
                    header("location:product_list.php?page=1");
                }
            }
        }
    }
}
?>




<!--web page for add product-->
<?php require ('header.php') ; ?>
<div class="section banner_section who_we_help">
    <div class="container">
        <h4>Update Product</h4>
    </div>
</div>

<!-- Content Section Start-->
<div class="section content_section">
    <form name="form" id="form" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
        <div class="container">
            <div class="filable_form_container">
                <div class="form_container_block">
                    <ul>
                        <li class="fileds">
                            <div class="name_fileds">
                                <label>Product Name<span class="error">*</span></label>
                                <input class="caps" value="<?php echo $fetched_row['name']?>" name="product_name" type="text" />
                                <input name="product_id" hidden value="<?php echo $id;?>">
                                <span class="error"><?php echo $product_name_error;?></span>
                            </div>
                        </li>
                        <li class="fileds">
                            <div class="name_fileds">
                                <label>Product Price<span class="error">*</span></label>
                                <input value="<?php echo $fetched_row['price']?>" name="product_price" type="text" />
                                <input name="product_id" hidden value="<?php echo $id;?>">
                                <span class="error"><?php echo $product_price_error;?></span>
                            </div>
                        </li>
                        <li class="fileds">
                            <div class="upload_fileds">
                                <label>Upload Image</label>
                                <input name="product_image" value="<?php echo $fetched_row['image']?>" id="uploadFile" type="file" placeholder="Choose File">
                                <input name="product_id" hidden value="<?php echo $id;?>">
                                <span class="error"><?php echo $product_image_error;?></span>
                            </div>
                        </li>
                        <li class="fileds">
                            <div class="name_fileds">
                                <label>Select Category<span class="error">*</span></label>
                                <select name="category" value="<?php echo $fetched_row['name']?>" id="categories_id" class="select category">

                                    <?php
                                    echo $query= "SELECT * FROM category";

                                    $result= mysqli_query($conn,$query) or die("cannot fetch data");
                                    while($row = mysqli_fetch_assoc($result)) {
                                    		$selected = '';
                                    		if($row['id']==$fetched_row['category_id']){
                                				$selected = 'selected';
                                    		}
                                        ?>
                                        <option <?php echo $selected;?> value="<?php echo $row['id'] ?>" > <?php echo $row['name'] ?></option>

                                        <?php
                                    }
                                    ?>


                                  <!--$query = "SELECT * FROM category";
                                    $result =  mysqli_query($query) or die (mysqli_error());


                                    while($row = mysql_fetch_assoc($result_category)){
                                    ?>
                                    <option value="<?php /*echo $row['id']; if ($row['id']==$category_id) echo '" selected="true'; */?>" ><?php /*echo $row['categry_id']; */?></option>
                                    --><?php
/*                                    }
                                    */?>
                                </select>




                            </div>
                        </li>
                    </ul>
                    <div class="next_btn_block">
                        <div class="nextbtn">
                            <input class="submit_buttons" type="submit" name="update-btn" value="Update">
                            <!--<span><img src="images/small_triangle.png"  alt="small_triangle"> </span></input>-->
                            <a href="product_list.php" class="cancle">Cancle</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Content Section End-->



<?php require ('footer.php') ?>
<!-- Sticky Contact Number Start
<div class="fixed_contact_number">
    <div class="container">
        <div class="contact_number">
            <span>Call Us Today! (02) 9017 8413</span>
            <a href="contact_us.html">Conatct Us</a>
        </div>
    </div>
</div>
 Sticky Contact Number End-->

</div>

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
</body>
</html>