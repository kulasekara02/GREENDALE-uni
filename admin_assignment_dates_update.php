<?php
	include "DBconnection.php";

	if (isset($_POST['updatedata'])){
		$id = $_POST['update_id'];
		$assignmnt_id = $_POST['assignmnt_id']; 
		$batch_id = $_POST['batch_id']; 
		$modules = array(
			array($_POST['module_1_issued'], $_POST['module_1_deadl']),
			array($_POST['module_2_issued'], $_POST['module_2_deadl']),
			array($_POST['module_3_issued'], $_POST['module_3_deadl']),
			array($_POST['module_4_issued'], $_POST['module_4_deadl']),
			array($_POST['module_5_issued'], $_POST['module_5_deadl']),
			array($_POST['module_6_issued'], $_POST['module_6_deadl']),
			array($_POST['module_7_issued'], $_POST['module_7_deadl']),
			array($_POST['module_8_issued'], $_POST['module_8_deadl']),
			array($_POST['module_9_issued'], $_POST['module_9_deadl']),
			array($_POST['module_10_issued'], $_POST['module_10_deadl'])
		);

		$query = "UPDATE module_assignments SET assignmnt_id=?, batch_id=?, ";
		for ($i=1; $i<=10; $i++) {
			$query .= "module_".$i."_issued=?, module_".$i."_deadl=?, ";
		}
		$query = rtrim($query, ', ');
		$query .= " WHERE assignmnt_id=?";

		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, 'i'.str_repeat('ss', 10).'i', $assignmnt_id, $batch_id, ...array_column($modules, 0), ...array_column($modules, 1), $assignmnt_id);

		if(mysqli_stmt_execute($stmt)){
			echo "submitted";   
			header('location:admin_assignments_dates.php');
			exit();
		} else {
			echo "form not submitted";
		}
		mysqli_stmt_close($stmt);               
	}
?>