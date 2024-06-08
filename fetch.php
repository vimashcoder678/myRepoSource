<?php
include 'config.php';
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Assuming $connect is your mysqli connection
    $get_by_id = "SELECT * FROM users WHERE id = $userId";
    $id_query = mysqli_query($connect, $get_by_id); 
   
   // $file_data = json_decode(file_get_contents($row), true);

		//$key = array_search($_POST["id"], array_column($file_data, 'id'));


		 while ($rowbyid = mysqli_fetch_assoc($id_query)) {
		    $useridresult[] = $rowbyid;
		}

		
		$json=json_encode($useridresult);
        echo $json;
   
}

?>