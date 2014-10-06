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
		<?php 
			$subjs = get_subjects();
			foreach($subjs as $id => $name){
				echo "<td colspan=2>$name</td>";
			}
		?>
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
		<?php 
			$subjs = get_subjects();
			foreach($subjs as $id => $name){ ?>
				<td>
					<select name="subj<?php echo $id; ?>">
						<?php echo options_html(1,10); ?>
					</select>
				</td>			
				<td>
					<select name="subjto<?php echo $id; ?>">
						<?php echo options_html(1,10); ?>
					</select>
				</td>			
		<?php } ?>
				<td><input type="submit" value="Filter persons" name="filter" /></td>
			</tr>
		</table>
	</form>
<?php

	show_persons();
	update();

?>
<?php require_once("footer.php"); ?>

