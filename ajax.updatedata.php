<?php
error_reporting(0);
//set_time_limit(30);
session_start();
include_once('inc/analyser.php');
$problems = $_SESSION["problems"];

// geeting results for each problem
foreach ($problems as $problem_id => $problem_title) {
    $analyser = new analyser;
    $results [$problem_id] = $analyser->get_result($problem_id);
    unset($analyser);
}

// outmode solved problems for each user
foreach ($results as $problem_id => $problem_results) {
    foreach ($problem_results as $user_name_hashed => $result) {
        if ($result['result'] === TRUE) {
            $_SESSION['user_names'][$user_name_hashed][$problem_id] = 0;
        }
    }
}
$results ['error'] = false;
echo json_encode($results);
?>