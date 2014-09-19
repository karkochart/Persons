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
	if($_POST['ageto']){
		$form_result["ageto"]= $_POST['ageto'];
	}
	if($_POST['category']){
		$form_result["category"] = $_POST['category'];
	}
	if($_POST['js']){
		$form_result["js"] = $_POST['js'];
	}
	if($_POST['jsto']){
		$form_result["jsto"] = $_POST['jsto'];
	}
	if($_POST['php']){
		$form_result["php"] = $_POST['php'];
	}
	if($_POST['phpto']){
		$form_result["phpto"] = $_POST['phpto'];
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

function show_persons(){


        $filter=get_form_result();

	//Get personal date values
        if($filter['name']){
                $personal.=" `name`='$filter[name]' and ";
        }
        if($filter['surname']){
                $personal.=" `surname`='$filter[surname]' and ";
        }
        if($filter['age']){
                $personal.=" `age` BETWEEN '$filter[age]' AND ";
        }else{
                $personal.=" `age`  BETWEEN '0' AND ";
        }
        if($filter['ageto']){
                $personal.=" '$filter[ageto]' and ";
        }else{
                $personal.=" '100' and ";
        }
	
	//Get person category 
	if($filter['category']){
                $cat_id = get_id_by_name('Categories', $filter['category']);
        }	

	//Get persons marks
	$filter_status = array();
	$filter_status = filter_by_pers_dates($personal);
	$ides=array_to_str($filter_status);
	if($ides){
		$pers_ides_str = " and `Pers_ID` IN (".$ides.")";
 		if($cat_id){
			$ides = array_to_str(filter_by_category($cat_id, $pers_ides_str));
			if($ides){
				$pers_ides_str = " and `Pers_ID` IN (".$ides.")";
			}
		}
		if($filter['js'] || $filter['jsto']){
			$js_marks = subject_marks_limit('js', $filter['js'], $filter['jsto'], $pers_ides_str);
			$js_marks_filter = filter_by_subjects_marks($js_marks);
		}
		if($filter['php'] || $filter['phpto']){
			$php_marks = subject_marks_limit('php', $filter['php'], $filter['phpto'], $pers_ides_str);
			$php_marks_filter = filter_by_subjects_marks($php_marks);
		}
		if($js_marks_filter===NULL){
			$js_marks_filter = $filter_status;
		}
		if($php_marks_filter===NULL){
			$php_marks_filter = $filter_status;
		}
		$filter_status = array_uintersect($php_marks_filter, $js_marks_filter, "strcasecmp");
	}
	print_r($filter_status);
}

function subject_marks_limit($subject, $from, $to ,$pers_ides_str){
             
        if($from || $to){
       		if($from && $to){

        	}elseif($from){
                	$to = 10;
		}else{
                	$from = 1;
		}
        
		return " WHERE  Subj_ID='".get_id_by_name("Subjects","$subject")."' and `Mark` BETWEEN '$from' AND '$to' $pers_ides_str";
	}else{
		return '';
	}
} 

function filter_by_subjects_marks($marks){
	$con = connect_DB();	

	$result = mysqli_query($con,"SELECT `Pers_ID` FROM `Marks` ".$marks);
	$pers_ides = array();

	while($row = mysqli_fetch_array($result)) {
		if($row["Pers_ID"]){
			$pers_ides[] = $row["Pers_ID"];
		}
	}
	return $pers_ides;
	close_DB();
}

function filter_by_pers_dates($pers_dates){
	$con = connect_DB();	

	$result = mysqli_query($con,"SELECT `ID` FROM `Personal` WHERE ".substr($pers_dates, 0, -4));
	$pers_ides = array();
	while($row = mysqli_fetch_array($result)) {
		if($row["ID"]){
			$pers_ides[] = $row["ID"];
		}
	}
	return $pers_ides;

	close_DB();
}

function filter_by_category($cat_id, $pers_ides_str){
	$con = connect_DB();	

	$result = mysqli_query($con,"SELECT `Pers_ID` FROM `State` WHERE `Cat_ID`='$cat_id' ".$pers_ides_str);
	$pers_ides = array();
	while($row = mysqli_fetch_array($result)) {
		if($row["ID"]){
			$pers_ides[] = $row["ID"];
		}
	}
	return $pers_ides;

	close_DB();
}

function array_to_str($array){
	$i = 0;
	$str = '';
	while($i < count($array)){
		$str .= $array[$i].",";
		$i++;
	}

	return substr($str, 0, -1);
}
