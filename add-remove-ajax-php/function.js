$(document).ready(function() {
			var max_fields      = 10; //maximum input boxes allowed
			var wrapper         = $(".input_fields_wrap"); //Fields wrapper
			var add_button      = $(".add_field_button"); //Add button ID

			

			$(add_button).click(function(e){ //on add input button click
				e.preventDefault();
				if(x < max_fields){ //max input box allowed
					x++; //text box increment
					$("#appendBefore1").before('<tr append'+x+' class="row">\
						<td><span class="sno" id="sno'+x+'">'+x+'</span></td>\
						<td>\
						<select class="sel_name" name="sel_name'+x+'" id="sel_name_'+x+'" onchange="chng_cond(this.value,this.id);">\
						<option value="">--Select--</option>\
						<option value="name">name</option>\
						<option value="email">email</option>\
						<option value="description">description</option>\
						<option value="dob">dob</option>\
						<option value="doj">doj</option>\
						</select>\
						</td>\
						<td>\
						<select class="sel_cond" name="sel_cond'+x+'" id="sel_cond_'+x+'">\
						<option value="">--Select--</option>\
						</select>\
						</td>\
						<td>\
						<div id="new'+x+'" class="new">\
						<input class="txt_data" type="text" name="txt_data'+x+'" id="txt_data'+x+'">\
						</div>\
						</td>\
						<td><button class="remove_field">Remove</button></td>\
						</tr>'
					); //table row
				}
				count=x;
				
			});

			$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
				$(this).closest("tr").remove();
				x--;
				$('.input_fields_wrap tr').each(function(i){
					$('.sel_name',this).attr('id','sel_name_'+(i+1));
					$('.sel_name',this).attr('name','sel_name'+(i+1));
					$('.sel_cond',this).attr('id','sel_cond_'+(i+1));
					$('.sel_cond',this).attr('name','sel_cond'+(i+1));
					$('.txt_data',this).attr('id','txt_data'+(i+1));
					$('.txt_data',this).attr('name','txt_data'+(i+1));
					$('.new',this).attr('id','new'+(i+1));
					$('.sno',this).html(i+1);

				});
				
				count=x;

			})

			count=x;

			$("#btnSubmit").on("click",function(){
				var maxLen=count;
				$("#hidCount").val(maxLen);
				var str="",msg="";
				for(var i=1;i<=maxLen;i++){
					if($("#sel_name_"+i).val()==''){
						str+="Name."+i+"\n";
					}
					if($("#sel_cond_"+i).val()==''){
						str+="Condition."+i+"\n";	
					}
					if($("#txt_data"+i).val()==''){
						str+="Value."+i+"\n";
					}
				}



				if(str!=''){
					msg="Please Enter below details\n";
					msg+="=============================\n";
					msg+=str;
					alert(msg);
					return false;
				}

			});

		});

function chng_cond(val,id){
	var str=String(id);
	var id_split = str.split("_");
	var num=id_split[2];
	var namevalue=val;
	var JsonObj= json_data[namevalue];

	$("#sel_cond_"+num).find('option').remove();
	html='<option value="">--Select--</option>';
	$.each(JsonObj, function(k, v) {
		html+='<option value="'+k+'">'+v+'</option>';
	}
	);

	$("#sel_cond_"+num).append(html);

	if(namevalue=='name'){
		$("#txt_data"+num).remove();
		get_names(num);
	}else if(namevalue=='email'){
		$("#txt_data"+num).remove();
		$("#new"+num).after('<input class="txt_data" type="text" id="txt_data'+num+'" name="txt_data'+num+'">');
	}else if(namevalue=='description'){
		$("#txt_data"+num).remove();
		$("#new"+num).after('<input class="txt_data" type="text" id="txt_data'+num+'" name="txt_data'+num+'">');
	}else	if(namevalue=='dob'){
		$("#txt_data"+num).remove();
		$("#new"+num).after('<input type="date" class="txt_data" id="txt_data'+num+'" name="txt_data'+num+'">');
	}else	if(namevalue=='doj'){
		$("#txt_data"+num).remove();
		$("#new"+num).after('<input type="date" class="txt_data" id="txt_data'+num+'" name="txt_data'+num+'">');
	}

}


function get_names(num){
	$.ajax({
		type: "POST",
		async: "false",
		url: "get_names.php",
		data: "num="+num,
		beforeSend: function(){
			$("#load").show();
		},
		success: function(result){
			if(result!=undefined){
				$("#new"+num).after(result);
			}else{    
				return false;
			}
		},
		complete:function(data){
			$("#load").fadeOut(1000);
		}
	});
}
