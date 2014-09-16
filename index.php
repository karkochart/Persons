<html>
<head>
</head>
<body>
<form method="post">
<input type="text" name="name"/>
<input type="text" name="surname"/>
<input type="text" name="age"/>
<select name="category">
<option>Employe</option>
<option>Student</option>
<option>Intern</option>
</select>
<select name="js">
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
add_personal_date($add_person["name"],$add_person["surname"],$add_person["age"]);
//print_r($add_person);
?>

</body>
</html>
