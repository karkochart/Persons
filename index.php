<?php require_once("functions.php"); ?>
<?php require_once("header.php"); ?>
	<h1>Add person</h1>
	<form class="add" method="post">
		<table>
			<tr>
				<td>Name *</td>
				<td><input type="text" name="name"/></td>
			</tr>
			<tr>
				<td>Surname *</td>
				<td><input type="text" name="surname"/></td>
			</tr>
			<tr>
				<td>Age *</td>
				<td>
					<select name="age">
						 <?php echo options_html(16,80); ?>
					</select>
				</td>			
			</tr>
			<tr>
				<td>Category</td>
				<td>
					<select name="category">
						 <?php echo options_html(NULL, NULL); ?>
					</select>
				</td>	
			</tr>
			<tr>
				<td>Js</td>
				<td>
					<select name="js">
						 <?php echo options_html(1,10); ?>
					</select>
				</td>			
			</tr>
			<tr>
				<td>Php</td>
				<td>
					<select name="php">
						 <?php echo options_html(1,10); ?>
					</select>
				</td>			
			</tr>
			<tr>
				<td colspan= 2><input type="submit" value="Add person" name="add-person" /></td>
			</tr>
		</table>
	</form>
	<p class='error red'>
		Please complete required fields(*)!
	</p>
<?php require_once("add-person.php"); ?>
<?php require_once("footer.php"); ?>
