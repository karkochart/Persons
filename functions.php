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
function add_personal_date($name,$surname,$age){

	if((preg_match('/^[A-Z][-a-zA-Z]+$/', $name))&&(preg_match('/^[A-Z][-a-zA-Z]+$/', $surname))&&(preg_match('/^[0-9,]{1,2}+$/', $age))){
		//connect DB
		$con=mysqli_connect("localhost","root","pas","Persons");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		$sql="INSERT INTO `Personal` ( `ID` , `Name` , `Surname` , `Age` )
			VALUES ( NULL, '$name', '$surname', '$age' );";

		//Query DB
		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error($con));
		}
	}
}
