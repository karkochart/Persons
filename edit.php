<?php
require_once('functions.php');
	$editing_pers_ides = array();
	foreach($_GET as $k => $v){
		if($k=='edit'){continue;}
			$editing_pers_ides[] = $k;
                }

	$persons_edit = get_persons_by_ides($editing_pers_ides);
	get_form_by_edit($persons_edit);
