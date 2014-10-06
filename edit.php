<?php require_once("header.php"); ?>
<?php require_once("functions.php"); ?>
<?php
	
	$obj = new Params;
	$filter_result = $obj->get();
	if(isset($filter_result['edit'])){
		$editing_pers_ides = array();
		foreach($filter_result as $k => $v){
			if($k=='edit'){continue;}
				$editing_pers_ides[] = $k;
       		}
	
		$persons_edit = get_persons_by_ides($editing_pers_ides);
		get_form_by_edit($persons_edit);
	}

	update($filter_result);

?>
<?php require_once("footer.php"); ?>

