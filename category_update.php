<!--Database Connection-->
<?php
require ('database_connection.php');
?>

<!--Fetching data in textbox-->

<?php

if(isset($_GET['category_id']))
{
    $id = $_GET['category_id'];
    $query = "SELECT * FROM category WHERE id=$id";
    $fire = mysqli_query($conn,$query) or die("cannot fetch");
    $fetched_row=mysqli_fetch_assoc($fire);
}
?>

<!--Update Data-->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-btn']))
{
$category_name = "";
$category_name_error = "";
if (empty($_POST["category_name"]))
{
    $category_name_error = "Category Name is required";
}

else if($_POST["category_name"])
{
if (!preg_match("/^[a-zA-Z ]*$/",$_POST["category_name"]))
{
    $category_name_error = "Category name should be in words.";
}
else
{
   $id = $_POST['category_id'];
      // variables for input data
        $category_name = ucwords($_POST['category_name']);
        /* $id = $_GET['upd'];
        //print_r($id) ;die;*/

        // sql query for update data into database
        $query = "UPDATE category SET name='".$category_name."' where id=".$id."";
        $fire = mysqli_query($conn,$query) or die("Cannot update");

        if($fire){
            header("location:category_list.php");
        }
    }
}

}

require ('header.php');
?>



    <div class="section banner_section who_we_help">
        <div class="container">
            <h4>Update Category</h4>
        </div>
    </div>

    <!-- Content Section Start-->
    <div class="section content_section">
        <form name="form" id="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="container">
                <div class="filable_form_container">
                    <div class="form_container_block">
                        <ul>
                            <li class="fileds">
                                <div class="name_fileds">
                                    <label>Category Name<span class="error">*</span></label>
                                    <input value="<?php echo $fetched_row['name'] ?>" class="caps" name="category_name" type="text">
                                    <input name="category_id" hidden value="<?php echo $id;?>">
                                    <span class="error"><?php echo $category_name_error;?></span>
                                </div>
                            </li>
                        </ul>
                        <div class="next_btn_block">
                            <div class="nextbtn">
                                <input class="submit_buttons" type="submit" name="update-btn" value="Update">
                                <!--<span><img src="images/small_triangle.png"  alt="small_triangle"> </span></input>-->
                                <a href="category_list.php" class="cancle">Cancle</a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Content Section End-->
<?php

require ('footer.php');
?>






