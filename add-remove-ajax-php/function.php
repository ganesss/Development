<?php
function get_condition($name,$value,$cond){
	$get_condition['is equal to']=$name." ='".$value."'";
	$get_condition['is not equal to']=$name." !='".$value."'";
	$get_condition['is like %%']=$name." like '%".$value."%'";
	$get_condition['is not like %%']=$name." not like '%".$value."%'";
	$get_condition['is less than']=$name." <'".$value."'";
	$get_condition['is greater than']=$name." >'".$value."'";
	return $get_condition[$cond];
}

function array_data(){

	$array_data['name']['is equal to']='is equal to';
	$array_data['name']['is not equal to']='is not equal to';

	$array_data['email']['is equal to']='is equal to';
	$array_data['email']['is not equal to']='is not equal to';
	$array_data['email']['is like %%']='is like %%';
	$array_data['email']['is not like %%']='is not like %%';

	$array_data['description']['is equal to']='is equal to';
	$array_data['description']['is not equal to']='is not equal to';
	$array_data['description']['is like %%']='is like %%';
	$array_data['description']['is not like %%']='is not like %%';

	$array_data['doj']['is equal to']='is equal to';
	$array_data['doj']['is not equal to']='is not equal to';
	$array_data['doj']['is less than']='is less than';
	$array_data['doj']['is greater than']='is greater than';

	$array_data['dob']['is equal to']='is equal to';
	$array_data['dob']['is not equal to']='is not equal to';
	$array_data['dob']['is less than']='is less than';
	$array_data['dob']['is greater than']='is greater than';
	return $array_data;
}
?>