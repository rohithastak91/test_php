<?php
/*for debugging the code*/
ini_set('error_reporting', 'E_ALL');
ini_set('error_reporting', 1);
error_reporting('E_ALL');
error_reporting('1');
/*Ends here*/

/*for database connection*/ 
$username = "inchora";
$password = "inchora";
$hostname = "localhost";
$database = "test";

$link = mysqli_connect($hostname, $username, $password, $database);

/*ends here*/

$urlPrefix = "http://172.10.1.5:8097/Inchora/cron/test.php/";
    
/*This section is used to check wether the entered url is already saved in DB,
 *  if present in DB then fetch as it is otherwise generate the new short code for the URL*/
    if(isset($_POST['url'])){
        $url = $_POST['url'];

        $result = mysqli_query($link, "SELECT short_url FROM url_mappings where url = '$url'");
        $row = mysqli_fetch_row($result);
        if ($row[0] != "") {
            $urlCode = $row[0];
            $finalUrl = $urlPrefix . $urlCode;
        } else {
            $urlCode = generateRandomString();
            $finalUrl = $urlPrefix . $urlCode;
            $date = date('Y-m-d H:i:s');
            $result = mysqli_query($link, "INSERT INTO `url_mappings` (`url`, `short_url`, `status`, `created`) VALUES ('$url', '$urlCode', '1', '$date');");
        }

        echo $finalUrl;
    }

   /*This section is used to get the short code for the entered URL as well as increment the count when user visit the website*/
    if(isset($_POST['pageURL'])){
        $pageURL = $_POST['pageURL']; 
   
        $pageURL = str_replace($urlPrefix,"",$pageURL);

        $result = mysqli_query($link, "SELECT url,id,no_of_hits FROM url_mappings where short_url = '$pageURL'");
        $row = mysqli_fetch_row($result);
        if($row[0] != ""){
         $count = $row[2] + 1;  
        $resultUpdate = mysqli_query($link, "UPDATE `url_mappings` SET `no_of_hits` = '$count' WHERE `url_mappings`.`id` = $row[1]");

            echo $row[0];
        }
    }
    
    /*This section is to get the counts of the number of time the site is visited*/
    if(isset($_POST['flag'])){
        $resultMostData = mysqli_query($link, "SELECT url FROM url_mappings ORDER BY no_of_hits DESC");
        $row =mysqli_fetch_all($resultMostData,MYSQLI_ASSOC);
        echo json_encode($row);
    }
    
    
    
  // function to generate random string which will be used as unique code for each url
function generateRandomString() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $string = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < 8; $i++) {
        $string .= $characters[mt_rand(0, $max)];
    }
    return $string;
}
 
 
  
   
      
        

?>
 