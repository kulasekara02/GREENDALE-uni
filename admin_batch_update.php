<?php
	include "DBconnection.php";
if (isset($_POST['updatedata'])){

	$id = $_POST['update_id']; 
	$batch_id = $_POST['batch_id'];
	$batch_name = $_POST['batch_name'];
	$batch_code = $_POST['batch_code'];
	$course_id = $_POST['course_id'];
	$assignment_id =$_POST['assignment_id'];

	$query = "UPDATE student_batches SET batch_id=?, batch_name=?, batch_code=?, course_id=?, assignment_id=? WHERE batch_id=?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, 'ssssss', $batch_id, $batch_name, $batch_code, $course_id, $assignment_id, $id);
	$result = mysqli_stmt_execute($stmt);
	if($result)
	{   
		echo "submitted";   
		header('location:admin_batch.php') ;         
	}
	else
	{
		echo "form not submitted";
	}               
}
?>
