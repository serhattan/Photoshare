<?php
require_once "include/init.php";

if(!empty($_POST['ratingPoints'])){
    //Her resim için postID yoluyor mu bak 
    $postID = $_POST['postID'];
    $ratingNum = 1;
    $ratingPoints = $_POST['ratingPoints'];
    $ratingAverage = number_format(($ratingAverage/$ratingNum),1);
    
    //Check the rating row with same post ID
    $prevRatingQuery = "SELECT * FROM rating_system WHERE media_id = ".$postID;
    $prevRatingResult = $conn->query($prevRatingQuery);

    if($prevRatingResult->rowCount() > 0){

        $prevRatingRow = $prevRatingResult->fetch(PDO::FETCH_ASSOC);
        $ratingNum = $prevRatingRow['rating_number'] + $ratingNum;
        $ratingPoints = $prevRatingRow['total_points'] + $ratingPoints;
        $ratingAverage = number_format(($ratingPoints / $ratingNum),1);
        //Update rating data into the database
        $query = "UPDATE rating_system SET rating_number = '".$ratingNum."',  rating_average = '".$ratingAverage."', total_points = '".$ratingPoints."', modified = '".date("Y-m-d H:i:s")."' WHERE media_id = ".$postID;
        $update = $conn->query($query);
    }else{

    //Insert rating data into the database
        $sql = "INSERT INTO rating_system (media_id,rating_number,rating_average,total_points,created,modified)  VALUES(".$postID.",'".$ratingNum."','".$ratingAverage."','".$ratingPoints."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
        $conn->exec($sql);

    }

  //Fetch rating deatails from database
    $query2 = "SELECT rating_number, FORMAT((total_points / rating_number),1) as average_rating FROM rating_system WHERE media_id = ".$postID." AND status = 1";
    $result = $conn->query($query2);
    $ratingRow = $result->fetch(PDO::FETCH_ASSOC);

    if($ratingRow){
        $ratingRow['status'] = 'ok';
    }else{
        $ratingRow['status'] = 'err';
    }

    //Return json formatted rating data
    echo json_encode($ratingRow);
}else{
   redirectedIfNotLoggedIn();
   redirectedIfLoggedIn();
}
?>