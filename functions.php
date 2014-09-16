<?php
function get_form_result(){
	$form_result = array();  
	if($_POST['name']){
		$form_result["name"] = $_POST['name'];
	}
	if($_POST['surname']){
		$form_result["surname"] = $_POST['surname'];
	}
	if($_POST['age']){
		$form_result["age"]= $_POST['age'];
	}
	if($_POST['category']){
		$form_result["category"] = $_POST['category'];
	}
	if($_POST['js']){
		$form_result["js"] = $_POST['js'];
	}
	if($_POST['php']){
		$form_result["php"] = $_POST['php'];
	}
	return($form_result);
}
function connect_DB(){

	//connect DB
	$connect=mysqli_connect("localhost","root","pas","Persons");
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	return $connect;
}
function close_DB(){

	mysql_close(connect_DB());
}
function add_personal_date($name,$surname,$age){

	if((preg_match('/^[A-Z][-a-zA-Z]+$/', $name))&&(preg_match('/^[A-Z][-a-zA-Z]+$/', $surname))&&(preg_match('/^[0-9,]{1,2}+$/', $age))){

		$con = connect_DB();
		$sql="INSERT INTO `Personal` ( `ID` , `Name` , `Surname` , `Age` )
			VALUES ( NULL, '$name', '$surname', '$age' );";

		//Query DB
		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error($con));
		}
		close_DB();
		return true;
	}else{
		return false;
	}

}

function get_id_by_name($table, $name, $surname="NULL", $age="NULL"){

	$con = connect_DB();

	if(($surname!="NULL") && ($age!="NULL")){
		$surname_age = " and `Surname`='$surname' and `Age`='$age'" ;
	}
	$result = mysqli_query($con,"SELECT `ID` FROM `$table` WHERE `Name`='$name' ".$surname_age);

	while($row = mysqli_fetch_array($result)) {
		if($row["ID"]){
			return $row["ID"];
		}
	}
	close_DB();
}

function add_person_cat($pers_id, $cat_id){

	$con = connect_DB();
	$sql="INSERT INTO `State` ( `ID` , `Pers_ID` , `Cat_ID` ) VALUES ( NULL, '$pers_id', '$cat_id' );";

	//Query DB
	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error($con));
	}


	close_DB();
}


function add_person_mark($pers_id, $subj_id,$mark){

	$con = connect_DB();
	$sql="INSERT INTO `Marks` ( `ID` , `Pers_ID` , `Subj_ID`, `Mark` ) VALUES ( NULL, '$pers_id', '$subj_id', '$mark' );";

	//Query DB
	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error($con));
	}


	close_DB();
}
