$(document).ready(function(){

	validation();
	$(".add input[type='text'], select[name='age']"). change(function(){
		validation();
	});
	$(".add input[type='button']").click(function(){
		$('.error').show();
		$('.added').hide();
	});
	
	countChecked();
	$( ".show-pers input[type=checkbox]" ).on( "click", countChecked );	
	
	$("select[name='age']").append(options_html(16,80));
	$("select[name^='subj']").append(options_html(1,10));

});//end Ready

//Functions

function validation(){
	
	var regx = /^[A-Z][-a-zA-Z]+$/;
	result = true;

	$('.add input[type="text"]').each(function(){
	
		if(!regx.test($(this).val())){
			result = false;
		}
	});

        if($(".add select[name='age']").val()==''){
		result = false;
	}

	if(result){
		$('.add input[type="button"]').attr('type','submit');
	}else{
		$('.add input[type="submit"]').attr('type','button');
	}

}
	
function countChecked() {
	
	var n = $( ".show-pers input:checked" ).length;
	if(n>0){
		$('.show-pers input[type="button"]').attr('type','submit');
	}else{
		$('.show-pers input[type="submit"]').attr('type','button');
	}
}

function options_html(from, to, select = false, cat = false){
        options = "";
        i = from;
       // if(from && to){
                while(i<=to){
                        if(select == i){
                                selected = " selected ";
                        }else{
                                selected = '';
                        }
                        options += "<option " + selected + ">" + i + "</option>";
                        i++;
                }
       // }
        return options;
}

