<?php
class Params {
	private $params = Array();

  	public function __construct() {
    		$this->_parseParams();
  	}

  /**
    * @brief Lookup request params
    * @param string $name Name of the argument to lookup
    * @param mixed $default Default value to return if argument is missing
    * @returns The value from the GET/POST/PUT/DELETE value, or $default if not set
    */
 	public function get($name) {
    		if (isset($this->params[$name])) {
     	 		return $this->params[$name];
    		} else {
      			return $this->params;
    		}
  	}

  	private function _parseParams() {
    		$method = $_SERVER['REQUEST_METHOD'];
    		if ($method == "PUT" || $method == "DELETE") {
        		parse_str(file_get_contents('php://input'), $this->params);
        		$GLOBALS["_{$method}"] = $this->params;
        		// Add these request vars into _REQUEST, mimicing default behavior, PUT/DELETE will override existing COOKIE/GET vars
        		$_REQUEST = $this->params + $_REQUEST;
    		} else if ($method == "GET") {
        		$this->params = $_GET;
    		} else if ($method == "POST") {
        		$this->params = $_POST;
    		}
  	}
}

function get_form_result($method){
	
	$form_result = array();  

	if($method['name']){
		$form_result["name"] = $method['name'];
	}
	if($method['surname']){
		$form_result["surname"] = $method['surname'];
	}
	if($method['age']){
		$form_result["age"]= $method['age'];
	}
	if($method['ageto']){
		$form_result["ageto"]= $method['ageto'];
	}
	if($method['category']){
		$form_result["category"] = $method['category'];
	}

	$subjs = get_subjects();
	foreach($subjs as $id =>$name){
		if($method["subj".$id]){
			$form_result["subj".$id] = $method["subj".$id];
		}
		if($method["subjto".$id]){
			$form_result["subjto".$id] = $method["subjto".$id];
		}
	}

	return($form_result);
}

function connect_DB(){

	//query DB
	$connect=mysqli_connect("localhost","root","pas","Persons");
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	return $connect;
}

function close_DB(){

	mysql_close(connect_DB());
}

function add_personal_date($name, $surname, $age, $key = NULL){
//if person is there, $key is ID for this person in DB.
//persons dates are adding in DB

	if((preg_match('/^[A-Z][-a-zA-Z]+$/', $name))&&(preg_match('/^[A-Z][-a-zA-Z]+$/', $surname))&&(preg_match('/^[0-9,]{1,2}+$/', $age))){

		$con = connect_DB();
		if($key){
			$sql = "UPDATE `Persons`.`Personal` set 
			`Name` = '$name',
			`Surname` = '$surname',
			`Age` = '$age' 
			WHERE `Personal`.`ID` = '$key' ";
		}else{
			$sql="INSERT INTO `Personal` ( `ID` , `Name` , `Surname` , `Age` )
				VALUES ( NULL, '$name', '$surname', '$age' );";
		}

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

function add_person_cat($pers_id, $cat_id){
//person category is adding(updating) in DB

	$con = connect_DB();

	if($cat_id){
	 	if(isset_date_in_table('State', $pers_id)){
			$sql = "UPDATE `Persons`.`State` set 
			`Cat_ID` = '$cat_id'
			WHERE `State`.`Pers_ID` = '$pers_id' ";
		}else{
			$sql="INSERT INTO `State` ( `ID` , `Pers_ID` , `Cat_ID` ) VALUES ( NULL, '$pers_id', '$cat_id' );";
		}
	}else{
		$sql = "DELETE FROM `Persons`.`State` WHERE `State`.`Pers_ID` = '$pers_id' ";
	}
	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error($con));
	}

	close_DB();
}

function add_person_mark($pers_id, $subj_id, $mark){
//adding  mark from person and subject exactly.

	$con = connect_DB();

	if(!$mark==''){
	 	if(isset_date_in_table('Marks', $pers_id, $subj_id)){
			$sql = "UPDATE `Persons`.`Marks` set 
			`Mark` = '$mark'
			WHERE `Marks`.`Pers_ID` = '$pers_id' and `Subj_ID` = '$subj_id' ";
		}else{
			$sql="INSERT INTO `Marks` ( `ID` , `Pers_ID` , `Subj_ID`, `Mark` ) VALUES ( NULL, '$pers_id', '$subj_id', '$mark' );";
		}
	}else{
		$sql = "DELETE FROM `Persons`.`Marks` WHERE `Marks`.`Pers_ID` = '$pers_id' and `Subj_ID` = $subj_id ";
	}

	//Query DB
	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error($con));
	}


	close_DB();
}

function delete_person($pers_id){
//person is deleting by Pers id (all dates from this person).

	$con = connect_DB();
	
	$sql = "DELETE FROM `Persons`.`Personal` WHERE `Personal`.`ID` = '$pers_id' ";
	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error($con));
	}

	close_DB();

}

function show_persons(){

	$obj = new Params;
       	$filter = $obj->get();
	if(isset($filter["filter"])){
	
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
		$ides = implode(',', $filter_status) ;
		if($ides){
			$pers_ides_str = " and `Pers_ID` IN (".$ides.")";
 			if($cat_id){
				$filter_status = filter_by_category($cat_id, $pers_ides_str);
				if(filter_by_category($cat_id, $pers_ides_str)){
					$ides = implode(',', $filter_status);
					if($ides){
						$pers_ides_str = " and `Pers_ID` IN (".$ides.")";
					}
				}
			}
			
			$subj = get_subjects();
			$filter_status_copy = $filter_status;
			foreach($subj as $id => $name){
				if($filter["subj".$id] || $filter["subjto".$id]){
					$marks = subject_marks_limit($name, $filter["subj".$id], $filter["subjto".$id], $pers_ides_str);
					$marks_filter[$id] = filter_by_subjects_marks($marks);
				}
				if($marks_filter[$id]===NULL){
					$marks_filter[$id] = $filter_status;
				}
				$filter_status_copy = array_uintersect($filter_status_copy, $marks_filter[$id], "strcasecmp");
			}
			$filter_status = $filter_status_copy;
		}

		//Get personal dates
	
		$persons = get_persons_by_ides($filter_status);
		show_filter_result($persons);
	}
}

function update($update){

	if(isset($update['update'])){
		for($i=1;$i<=floor(count($update)/8)+1;$i++){
        		if(!$update['del'.$i]){
				add_personal_date($update['Name'.$i],$update['Surname'.$i],$update['Age'.$i],$update['key'.$i]);
				$cat_id = get_id_by_name('Categories',$update['Category'.$i]);	
				add_person_cat($update['key'.$i], $cat_id);
				
				$subjs = get_subjects();
				foreach($subjs as $id => $name){
					add_person_mark($update['key'.$i], $id, $update[$i.'subj'.$id]);
				}
        		}else{
        			delete_person($update['key'.$i]);
			}
		}
		echo "<p>Dates updated successfully!</p>";
	}
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
		if($row["Pers_ID"]){
			$pers_ides[] = $row["Pers_ID"];
		}
	}
	return $pers_ides;

	close_DB();
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

function get_persons_by_ides($persons_ides){

	$con = connect_DB();	

	$result = mysqli_query($con,"SELECT * FROM `Personal` WHERE ID IN (".implode(',', $persons_ides).")");
	$persons = array();
	while($row = mysqli_fetch_array($result)) {
		$persons[$row["ID"]]['Name'] = $row["Name"];
		$persons[$row["ID"]]['Surname'] = $row["Surname"];
		$persons[$row["ID"]]['Age'] = $row["Age"];
	}


	$result = mysqli_query($con,"SELECT * FROM `Categories` ");
	$categories = array();
	while($row = mysqli_fetch_array($result)) {
		$categories[$row["ID"]] = $row["Name"];
	}


	$result = mysqli_query($con,"SELECT * FROM `Subjects` ");
	$subjects = array();
	while($row = mysqli_fetch_array($result)) {
		$subjects[$row["ID"]] = $row["Name"];
	}

	$result = mysqli_query($con,"SELECT * FROM `State` WHERE Pers_ID IN (".implode(',', $persons_ides).")");
	while($row = mysqli_fetch_array($result)) {
		$persons[$row['Pers_ID']]['Category'] = $categories[$row["Cat_ID"]];
	}


	$result = mysqli_query($con,"SELECT * FROM `Marks` WHERE Pers_ID IN (".implode(',', $persons_ides).")");
	while($row = mysqli_fetch_array($result)) {
		$persons[$row['Pers_ID']][$subjects[$row["Subj_ID"]]] = $row["Mark"];
	}


	close_DB();
	
	return $persons;
}

function options_html($from, $to,$select = NULL, $cat = NULL){
	$options = "<option></option>";
	$i = $from;
	if($from && $to){
		while($i<=$to){
			if($select==$i){
				$selected = " selected ";
			}else{
				$selected = '';
			}
			$options .= "<option $selected >$i</option>";
			$i++;
		}
	}else{
		$con = connect_DB();	
		$result = mysqli_query($con,"SELECT * FROM `Categories` ");
		while($row = mysqli_fetch_array($result)) {
			if($row["Name"]===$cat){
				$selected = " selected ";
			}else{
				$selected = '';
			}
			$options.="<option $selected>".$row["Name"]."</option>";
		}
		close_DB();
	} 
	return $options;
}

function isset_date_in_table($table, $pers_id, $subj_id = NULL){
	
	$con = connect_DB();	

	if($subj_id){
		$subj_id = " and `Subj_ID` = $subj_id ";
	}
	$result = mysqli_query($con,"SELECT `ID` FROM `$table` WHERE `Pers_ID` = '$pers_id' ".$subj_id);

	while($row = mysqli_fetch_array($result)) {
		if($row["ID"]){
			$id = $row["ID"];
		}
	}
	if($id){
		return $id;
	}else{
		return NULL;
	}

	close_DB();
}

function show_filter_result($persons){
	if($persons){
?>
		<form  method='put' action='edit.php' class="show-pers" >	
			<table>
				<tr>
                        	        <td>Name</td>
                               		<td>Surname</td>
                           	    	<td>Age</td>
               	                	<td>Category</td>
		<?php $subjs = get_subjects();
			foreach($subjs as $id => $name){
		?> 
                                <td><?php echo $name; ?></td>
		<?php } ?>
               		                <td></td>
                        	</tr>

<?php
		foreach($persons as $key => $person){
?>
				<tr>
					<td>
						<?php echo $person["Name"]; ?>
					</td>
					<td>
						<?php echo $person["Surname"]; ?>
					</td>
					<td>
						<?php echo $person["Age"]; ?>
					</td>
					<td>
						<?php echo $person["Category"]; ?>
					</td>
		<?php 
			foreach($subjs as $id => $name){
		?> 
					<td>
						<?php echo $person[$name]; ?>
					</td>
		<?php } ?>
					<td>
						<input type='checkbox'name='<?php echo $key; ?>' >
					</td>
				</tr>
<?php
		}
?>	
				<tr>
					<td colspan=7>
						<input type='submit' value='Edit' name='edit'/>
					</td>
				</tr>
			</table>
		</form>
<?php
	}else{
		echo "<p class='red'>No result!</p>";
	}
}

function get_form_by_edit($persons_edit){
	
?>
	<form method='get' >	
		<table class="edit" >
			<tr>
                                <td>Name</td>
                                <td>Surname</td>
                                <td>Age</td>
                                <td>Category</td>
		<?php $subjs = get_subjects();
			foreach($subjs as $id => $name){
		?> 
                                <td><?php echo $name; ?></td>
		<?php } ?>
                                <td class="red">Delete</td>
                        </tr>

	<?php	$n = 1;
		foreach($persons_edit as $key => $person){
	?>
			<tr>
				<td>
					<input type='text' name='key<?php echo $n; ?>'value='<?php echo $key; ?>'style='display:none;'/>
					<input type='text' value='<?php echo $person["Name"]; ?>'name='Name<?php echo $n; ?>' />
				</td>
				<td>
					<input type='text' value='<?php echo $person["Surname"]; ?>'name='Surname<?php echo $n; ?>' />
				</td>
				<td>
					<select name='Age<?php echo $n; ?>' >
						<?php echo options_html(16, 80, $person['Age']); ?>
					</select>
				</td>
				<td>
					<select name='Category<?php echo $n; ?>' >
						<?php echo options_html(NULL, NULL, NULL, $person['Category']); ?>
					</select>
				</td>

		<?php 
			foreach($subjs as $id => $name){
		?>	
				<td>
					<select name='<?php echo $n."subj".$id; ?>' >
						<?php echo options_html(1, 10, $person[$name]); ?>
					</select>
				</td>
		<?php } ?>
				<td>
					<input type='checkbox'name='del<?php echo $n; ?>' >
				</td>
			</tr>
	<?php	
		$n++;	}
	?>
			<tr>
				<td colspan=7>
					<input type='submit' name='update' value='Update' />
				</td>
			</tr>
		</table>
	</form>
<?php
}

function get_subjects(){

	$con = connect_DB();
                
        $result = mysqli_query($con,"SELECT * FROM `Subjects` ");
        $subjects = array();

        while($row = mysqli_fetch_array($result)) {
                $subjects[$row["ID"]] = $row["Name"];
        }
	return $subjects;

        close_DB(); 
}
