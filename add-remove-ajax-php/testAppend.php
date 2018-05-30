<?php

require_once "database.php";
require_once "function.php";

$array_data=array_data();

if(!empty($_POST['btnSubmit'])){
	$totCount=$_POST['hidCount'];

	for($i=1;$i<=$totCount;$i++){
		$name=$_POST["sel_name$i"];
		$value=$_POST["txt_data$i"];
		$condition=$_POST["sel_cond$i"];
		$where=get_condition($name,$value,$condition);
		$text_data[$i]="Search Result For Name: ".ucwords($name)." && Condition: ".ucwords($condition)." && Value: ".ucwords($value);
		$sql="select * from tbl_user where $where";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$data_view[$i][]=$row;
		}
		if(empty($data_view[$i])){
			$data_view[$i][]="";
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
		var json_data=JSON.parse('<?php echo (!empty($array_data))?json_encode($array_data):'false';?>');
		var count;
		var x = <?php echo (!empty($_POST['hidCount']))?$_POST['hidCount']:1;?> //initlal text box count
	</script>
	<script type="text/javascript" src="function.js"></script>
	<style type="text/css">
	td{padding:5px;text-align:center;}
	td select{width:200px;}
	td input[type="text"]{width:200px;}
	td input[type="date"]{width:200px;}
	.mask{
		display: none; /*This hides the mask*/
	}
	#load {
		position: absolute;
		background: white url('loading.gif') no-repeat center center;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		opacity:1;
	}
</style>
</head>
<body>
	<div id="load" style="display: none;"></div>
	<form name="frmAdd" action="" method="post">
		<input type="hidden" name="hidCount" id="hidCount">
		<table width="50%" align="center" border="1">
			<tr>
				<th>S.No</th>
				<th>Name</th>
				<th>Condition</th>
				<th colspan="2">Value</th>
			</tr>

			<tbody class="input_fields_wrap">
				<?php if(!empty($_POST['btnSubmit'])){ 
					$count=$_POST['hidCount'];
					for($i=1;$i<=$count;$i++){?>
						<tr id="append<?php echo $i;?>" class="row">
							<td><span id="sno<?php echo $i;?>" class="sno"><?php echo $i;?></span></td>
							<td>
								<select class="sel_name" name="sel_name<?php echo $i;?>" id="sel_name<?php echo $i;?>" onchange="chng_cond(this.value,this.id);">
									<option value="" >--Select--</option>
									<option value="name" <?php echo ($_POST["sel_name$i"]=='name')?"selected":"";?>>name</option>
									<option value="email" <?php echo ($_POST["sel_name$i"]=='email')?"selected":"";?>>email</option>
									<option value="description" <?php echo ($_POST["sel_name$i"]=='description')?"selected":"";?>>description</option>
									<option value="dob" <?php echo ($_POST["sel_name$i"]=='dob')?"selected":"";?>>dob</option>
									<option value="doj" <?php echo ($_POST["sel_name$i"]=='doj')?"selected":"";?>>doj</option>
								</select>
							</td>
							<td>
								<select class="sel_cond" name="sel_cond<?php echo $i;?>" id="sel_cond<?php echo $i;?>">
									<option value="">--Select--</option>
									<?php $name=$_POST["sel_name$i"];foreach ($array_data[$name] as $key => $value) {?>
										<option value="<?php echo $key;?>" <?php echo ($_POST["sel_cond$i"]==$key)?"selected":"";?>><?php echo $value;?></option>
									<?php }?>
								</select>
							</td>
							<td>
								<div id="new<?php echo $i;?>">
									<?php 
									if($name=='name'){
										$query="select name from tbl_user";
										$result_data=$conn->query($query);
										while($row=$result_data->fetch_assoc()){
											$row_data[]=$row;
										}
										?>
										<select class="txt_data" name="txt_data<?php echo $i;?>" id="txt_data<?php echo $i;?>">
											<option value=''>--Select--</option>											
											<?php foreach ($row_data as $key => $value) {?>
												<option value="<?php echo $value['name'];?>" <?php echo ($_POST["txt_data$i"]==$key)?"selected":"";?>><?php echo $value['name'];?></option>
											<?php }?>
										</select>
									<?php }else{$text=($name=='email' || $name=='description')?"text":"date";?>
									<input class="txt_data" type="<?php echo $text;?>" name="txt_data<?php echo $i;?>" id="txt_data<?php echo $i;?>" value='<?php echo $_POST["txt_data$i"];?>'>
								<?php }?>
							</div>					
						</td>
						<td>
							<?php if($i==1){?>
								<button class="add_field_button">Add</button>
							<?php }else{?>
								<button class="remove_field">Remove</button>
							<?php }?>
						</td>
					</tr>	
				<?php }}else{?>
					<tr id="append<?php echo $i;?>" class="row">
						<td><span id="sno1" class="sno">1</span></td>
						<td>
							<select class="sel_name" name="sel_name1" id="sel_name_1" onchange="chng_cond(this.value,this.id);">
								<option value="">--Select--</option>
								<option value="name">name</option>
								<option value="email">email</option>
								<option value="description">description</option>
								<option value="dob">dob</option>
								<option value="doj">doj</option>
							</select>
						</td>
						<td>
							<select class="sel_cond" name="sel_cond1" id="sel_cond_1">
								<option value="">--Select--</option>
							</select>
						</td>
						<td>
							<div id="new1" class="new">
								<input class="txt_data" type="text" name="txt_data1" id="txt_data1">
							</div>					
						</td>
						<td><button class="add_field_button">Add</button></td>
					</tr>		
				<?php }?>
				<tr id="appendBefore1">
					<th colspan="5" height="50" align="center"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit"></th>
				</tr>
			</tbody>
		</table>
	</form>

	<div style="margin-top:50px;">
		<?php 
		if(!empty($data_view)){?>
			<table border="1" width="58%" align="center"> 
				<?php 
				foreach ($data_view as $key => $value) {
					if(!empty($value[0])){
						foreach ($value as $kkey => $vvalue) {
							if($kkey==0){?>
								<tr>
									<th colspan="5" height="50"><?php echo $text_data[$key];?></th>
								</tr>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Description</th>
									<th>DOB</th>
									<th>DOJ</th>
								</tr>
							<?php }?>
							<tr>
								<td><?php echo $vvalue['name'];?></td>
								<td><?php echo $vvalue['email'];?></td>
								<td><?php echo $vvalue['description'];?></td>
								<td><?php echo $vvalue['dob'];?></td>
								<td><?php echo $vvalue['doj'];?></td>
							</tr>
							<?php 
						}
					}else{
						?>
						<tr>
							<th colspan="5" height="50"><?php echo $text_data[$key];?></th>
						</tr>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Description</th>
							<th>DOB</th>
							<th>DOJ</th>
						</tr>
						<tr>
							<td align="center" colspan="5">No Record Found..</td>
						</tr>
						<?php 
					}
				}
				?>
			</table>
		<?php	}	?>
	</div>
</body>
</html>