<?php

$mysqli = new mysqli('localhost','root','','greendale') or die(mysqli_error($mysqli));

if (isset($_POST['submit'])){

	$batch_id = $_POST['batch_id'];
	$batch_name = $_POST['batch_name'];
	$batch_code = $_POST['batch_code'];
	$course_id = $_POST['course_id'];
	$assignment_id = $_POST['assignment_id'];

	// Sanitize values
	$batch_id = mysqli_real_escape_string($mysqli, $batch_id);
	$batch_name = mysqli_real_escape_string($mysqli, $batch_name);
	$batch_code = mysqli_real_escape_string($mysqli, $batch_code);
	$course_id = mysqli_real_escape_string($mysqli, $course_id);
	$assignment_id = mysqli_real_escape_string($mysqli, $assignment_id);

	// Prepare the statement
	$stmt = $mysqli->prepare("INSERT INTO module_assignments (assignmnt_id ,batch_id ) VALUES(?,?)");
	$stmt->bind_param("ss", $batch_id, $assignment_id);
	$stmt->execute();

	$stmt2 = $mysqli->prepare("INSERT INTO student_batches ( batch_id, batch_name, batch_code, course_id, assignment_id  )VALUES(?,?,?,?,?)");
	$stmt2->bind_param("sssss", $batch_id, $batch_name, $batch_code, $course_id, $assignment_id);
	$stmt2->execute();

	// Close the statements
	$stmt->close();
	$stmt2->close();

	header("location:admin_batch.php");
}

$batch_id = $_POST['batch_id'];

if (isset($_GET['delete'])) {
	$batch_id = $_GET['delete'];
	$mysqli->query("DELETE FROM student_batches WHERE batch_id=$batch_id") or die ($mysqli->error());
    $mysqli->query("DELETE FROM module_assignments WHERE batch_id=$batch_id") or die ($mysqli->error());  
      header("location:admin_batch.php");
}


