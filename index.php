<html>
<head>
</head>
<body>
	<form method="post">
		<table>
			<tr>
				<td>Name</td>
				<td>Surname</td>
				<td>Age</td>
				<td>Category</td>
				<td>Js</td>
				<td>Php</td>
				<td></td>
			</tr>
			<tr>
				<td><input type="text" name="name"/></td>
				<td><input type="text" name="surname"/></td>
				<td><input type="text" name="age"/></td>
				<td>
					<select name="category">
						<option></option>
						<option>Employe</option>
						<option>Student</option>
						<option>Intern</option>
					</select>
				</td>	
				<td>
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
				</td>			
				<td>
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
				</td>			
				<td><input type="submit" value="Add person" /></td>
			</tr>
		</table>
	</form>
<?php
require_once("functions.php"); 
require_once("add-person.php");

?>

</body>
</html>
