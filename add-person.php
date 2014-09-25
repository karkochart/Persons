<?php

$add_person = get_form_result($_POST);
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
	echo "<p class='added' >Person successfuly added!</p>";
}

?>
