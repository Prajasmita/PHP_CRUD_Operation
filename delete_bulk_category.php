
<?php
require ("database_connection.php");
/*print_r($_POST['checkbox']);

exit;*/

if(isset($_POST['checkbox']))
{
    foreach ($_POST['checkbox'] as $i)
    {
        print_r($i);

        if(    $sql = $conn->query("DELETE FROM category WHERE id ='".$i."'"))
        {
            header("location:category_list.php");
        }

    }
}
?>