<?php require_once("header.php"); ?>
<?php require_once("functions.php"); ?>
	<h1>Filter persons</h1>
	<form method="get" class="filter">
		<table>
			<tr>
				<td>Name</td>
				<td>Surname</td>
				<td>Age</td>
				<td></td>
				<td>Category</td>
				<td>Js</td>
				<td></td>
				<td>Php</td>
				<td></td>
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
					<select name="ageto">
						<?php echo options_html(16,80); ?>
					</select>
				</td>			
				<td>
					<select name="category">
						<?php echo options_html(NULL, NULL, NULL, true); ?>
					</select>
				</td>	
				<td>
					<select name="js">
						<?php echo options_html(1,10); ?>
					</select>
				</td>			
				<td>
					<select name="jsto">
						<?php echo options_html(1,10); ?>
					</select>
				</td>			
				<td>
					<select name="php">
						<?php echo options_html(1,10); ?>
					</select>
				</td>			
				<td>
					<select name="phpto">
						<?php echo options_html(1,10); ?>
					</select>
				</td>			
				<td><input type="submit" value="Filter persons" name="filter" /></td>
			</tr>
		</table>
	</form>
<?php

	if(isset($_GET["filter"])){
		show_persons();
	}
	update();

?>
<?php require_once("footer.php"); ?>

