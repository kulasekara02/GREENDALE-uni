<?php
	include "DBconnection.php";

if (isset($_POST['updatedata'])) {
	// Get form data
	$id = $_POST['update_id'];
	$assignmnt_id = $_POST['assignmnt_id']; 
	$batch_id = $_POST['batch_id'];

	// Upload files
	$moduleAssignments = [];
	for ($i = 1; $i <= 10; $i++) {
		if (!empty($_FILES["moduleassignment_$i"]["name"])) {
			$filename = basename($_FILES["moduleassignment_$i"]["name"]);
			$destination = 'moduleassignmentsforStudents/' . $filename;
			move_uploaded_file($_FILES["moduleassignment_$i"]["tmp_name"], $destination);
			$moduleAssignments[] = $filename;
		}
	}

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
    header('Location: admin_assignments.php');
    exit;
} else {
    echo "form not submitted";
}

}
	               


?>
