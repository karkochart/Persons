<?php require_once("header.php"); ?>
<?php require_once("functions.php"); ?>
<?php
	$editing_pers_ides = array();
	foreach($_GET as $k => $v){
		if($k=='edit'){continue;}
			$editing_pers_ides[] = $k;
                }

		$persons_edit = get_persons_by_ides($editing_pers_ides);
		get_form_by_edit($persons_edit);
		if(isset($_GET['update'])){
       	        for($i=1;$i<=floor(count($_GET)/8);$i++){
                        if(!$_GET['del'.$i]){
                                add_personal_date($_GET['Name'.$i],$_GET['Surname'.$i],$_GET['Age'.$i],$_GET['key'.$i]);
                                $cat_id = get_id_by_name('Categories',$_GET['Category'.$i]);
                                add_person_cat($_GET['key'.$i], $cat_id);
                                $subj_id = get_id_by_name('Subjects', 'php');
                                add_person_mark($_GET['key'.$i], $subj_id, $_GET['php'.$i]);
                                $js_id = get_id_by_name('Subjects', 'js');
                                add_person_mark($_GET['key'.$i], $js_id, $_GET['js'.$i]);
                        }else{
                                delete_person($_GET['key'.$i]);
                        }
                }
        }

?>
<?php require_once("footer.php"); ?>

