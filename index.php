<?php require_once("functions.php"); ?>
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
				<td>
					<select name="age">
						 <?php echo options_html(16,80); ?>
					</select>
				</td>			
				<td>
					<select name="category">
						 <?php echo options_html(NULL, NULL); ?>
					</select>
				</td>	
				<td>
					<select name="js">
						 <?php echo options_html(1,10); ?>
					</select>
				</td>			
				<td>
					<select name="php">
						 <?php echo options_html(1,10); ?>
					</select>
				</td>			
				<td><input type="submit" value="Add person" /></td>
			</tr>
		</table>
	</form>
<a href='filter.php'>Filter</a>
<?php
require_once("add-person.php");

?>

</body>
</html>
