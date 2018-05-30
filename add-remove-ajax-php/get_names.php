<?php
require_once "database.php";
$query="select name from tbl_user";
$result=$conn->query($query);
if ($result->num_rows > 0) {
	$html="<select class='txt_data' name='txt_data".$_POST['num']."' id='txt_data".$_POST['num']."'><option value=''>--Select--</option>";
	while($row = $result->fetch_assoc()) {
		$html.="<option value='".$row['name']."' >".$row['name']."</option>";
	}
	$html.="</select>";
}
echo $html;

?>
