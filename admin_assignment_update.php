<?php
	include "DBconnection.php";

if (isset($_POST['updatedata'])) {
	// Get form data
	$id = $_POST['update_id'];
	$assignmnt_id = $_POST['assignmnt_id']; 
	$batch_id = $_POST['batch_id'];

	// Upload files
// define constant for maximum number of files to process
const MAX_FILES = 10;

function uploadModuleAssignments($files) {
  $moduleAssignments = [];

  // loop through files
  for ($i = 1; $i <= MAX_FILES; $i++) {
	// check if file is set and not empty
	if (isset($files["moduleassignment_$i"]) && !empty($files["moduleassignment_$i"]["name"])) {
	  $filename = basename($files["moduleassignment_$i"]["name"]);
	  $destination = 'moduleassignmentsforStudents/' . $filename;

	  // move file to destination folder
	  if (move_uploaded_file($files["moduleassignment_$i"]["tmp_name"], $destination)) {
		$moduleAssignments[] = $filename;
	  }
	}
  }

  return $moduleAssignments;
}

// Usage: call uploadModuleAssignments($_FILES) to upload module assignments from form submission.
	// Build query
	$query = "UPDATE module_assignments SET assignmnt_id=?, batch_id=?, ";
	for ($i = 1; $i <= count($moduleAssignments); $i++) {
		$query .= "moduleassignment_$i=?,";
	}
	$query = rtrim($query, ',') . " WHERE assignmnt_id=?";

	// Execute query using prepared statement
	$stmt = mysqli_prepare($conn, $query);
	$params = array_merge([$assignmnt_id, $batch_id], $moduleAssignments, [$assignmnt_id]);
	mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
	$query_run = mysqli_stmt_execute($stmt);

	// Handle result
	if ($query_run) {
		echo "submitted";    
		header('location:admin_assignments.php');
	} else {
		echo "form not submitted";
	}
}
	               


?>
