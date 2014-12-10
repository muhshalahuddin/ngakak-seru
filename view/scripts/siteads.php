<?php 
if($AdsSql = $database->prepare("SELECT * FROM siteads WHERE id='1'")){
	$AdsSql->execute();
	

    $AdsRow = $AdsSql->fetch();
	
	$Ad1 = stripslashes($AdsRow['ad1']);
	$Ad2 = stripslashes($AdsRow['ad2']);
	$Ad3 = stripslashes($AdsRow['ad3']);

}else{
	
     printf("Error: %s\n", $db->error);
}