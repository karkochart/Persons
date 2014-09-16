<html>
<head>
</head>
<body>
<form method="post">
<input type="text" name="name"/>
<input type="text" name="surname"/>
<input type="text" name="age"/>
<select name="category">
<option></option>
<option>Employe</option>
<option>Student</option>
<option>Intern</option>
</select>
<select name="js">
<option></option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
</select>
<select name="php">
<option></option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
</select>
<input type="submit" value="Add person" />
</form>
<?php
require_once("functions.php"); 
$add_person = get_form_result();
$person_added = add_personal_date($add_person["name"],$add_person["surname"],$add_person["age"]);


if($person_added){

	$person_id = get_id_by_name('Personal', $add_person["name"], $add_person["surname"], $add_person["age"]);
	$subjects = array('js' => $add_person['js'], 'php' => $add_person['php']);
	foreach($subjects as $key => $val){
		if($val){
			add_person_mark($person_id, get_id_by_name('Subjects', $key) , $val);
		}
	}
	if($add_person["category"]){
		add_person_cat($person_id , get_id_by_name('Categories', $add_person["category"]));
	}
}
?>

</body>
</html>
