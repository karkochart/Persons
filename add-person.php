<?php
$obj = new Params;
$add_person = get_form_result($obj->get());
$person_added = add_personal_date($add_person["name"],$add_person["surname"],$add_person["age"]);


if($person_added){

        $person_id = get_id_by_name('Personal', $add_person["name"], $add_person["surname"], $add_person["age"]);
        $subjects = get_subjects();
        foreach($subjects as $id => $name){
                if($add_person['subj'.$id]){
                        add_person_mark($person_id, $id , $add_person['subj'.$id]);
                }
        }
        if($add_person["category"]){
                add_person_cat($person_id , get_id_by_name('Categories', $add_person["category"]));
        }
	echo "<p class='added' >Person successfuly added!</p>";
}

?>
