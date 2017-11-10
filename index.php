
<!--Database Connection-->
<?php

require ('database_connection.php');
?>

<!--Create Category With Validation-->
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
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
               $category_name = ucwords($_POST['category_name']);
               $query = "INSERT INTO category (name) VALUES ('".trim($category_name)."')";
               $fire = mysqli_query($conn,$query) or die("Cannot Added.");
               if($fire){
                   header("location:category_list.php?page=1");
               }
            }
        }
}
?>

<?php require ('header.php'); ?>

  <div class="section banner_section who_we_help">
  	<div class="container">
  		<h4>Create Category</h4>
  	</div>
  </div>

  <!-- Content Section Start-->
  <div class="section content_section">
      <form name="form" id="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="container">
            <div class="filable_form_container">
                <div class="form_container_block">
                    <span class="result">
                        <?php if(isset($result)){
                            echo $result;
                        }?>
                    </span><br/><br/>
                    <ul>
                        <li class="fileds">
                            <div class="name_fileds">
                                <label>Category Name<span class="error">*</span></label>
                                <input class="caps" name="category_name" type="text">
                                <input name="category_id" hidden value="<?php echo $category_name;?>">
                                <span class="error"><?php echo $category_name_error;?></span>
                            </div>
                        </li>
                    </ul>
                    <div class="next_btn_block">
                        <div class="nextbtn">
                            <input class="submit_buttons" type="submit" name="submit" value="submit">
				<!--<span><img src="images/small_triangle.png"  alt="small_triangle"> </span></input>-->
                            <a href="category_list.php" class="cancle">Cancle</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
  </div>

    <?php require ('footer.php'); ?>

