<?php
require("db.php");

// Gets data from URL parameters.
if(isset($_GET['add_location'])) {
    add_location();
}
if(isset($_GET['confirm_location'])) {
    confirm_location();
}




function add_location(){
    $con=mysqli_connect ("localhost", 'root', '','locations');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    
   
   /* $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["imageUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $imageUpload=basename( $_FILES["imageUpload"]["name"],".jpg"); // used to store the filename in a variable
    */

    $name=$_GET['name'];
    $imageUpload = addslashes(file_get_contents($_FILES['imageUpload']['tmp_name']));
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $description =$_GET['description'];
    


    // Inserts new row with place data.
    $query = sprintf("INSERT INTO locations " .
        " (id,name,image, lat, lng, description) " .
        " VALUES (NULL, '%s', '%s', '%s', '%s', '%s');",
        mysqli_real_escape_string($con,$name),
        mysqli_real_escape_string($con,$imageUpload),
        mysqli_real_escape_string($con,$lat),
        mysqli_real_escape_string($con,$lng),
        mysqli_real_escape_string($con,$description));

    $result = mysqli_query($con,$query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}

function get_image(){
    $con=mysqli_connect ("localhost", 'root', '','locations');
 if (!$con) {
                             die('Not connected : ' . mysqli_connect_error());
                       } 
                    $result = mysql_query("SELECT image FROM locations WHERE id='".$_GET['id']."'");
                      $row = mysql_fetch_array($result, MYSQL_ASSOC);
                       header("Content-type: image/jpeg");
                         echo $row['image'];
}

function confirm_location(){
    $con=mysqli_connect ("localhost", 'root', '','locations');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id =$_GET['id'];
    $confirmed =$_GET['confirmed'];
    // update location with confirm if admin confirm.
    $query = "update locations set location_status = $confirmed WHERE id = $id ";
    $result = mysqli_query($con,$query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}

function get_confirmed_locations(){
    $con=mysqli_connect ("localhost", 'root', '','locations');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"
select id ,lat,lng,description,location_status,name,image as isconfirmed
from locations WHERE  location_status = 1
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function get_all_locations(){
    $con=mysqli_connect ("localhost", 'root', '','locations');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"
select id ,lat,lng,description,location_status,name,image as isconfirmed
from locations
  ");

    $rows = array();
    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }
  $indexed = array_map('array_values', $rows);
  //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function array_flatten($array) {
    if (!is_array($array)) {
        return FALSE;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        }
        else {
            $result[$key] = $value;
        }
    }
    return $result;
}

?>