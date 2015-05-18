<?php
	set_time_limit ( 15 );
	session_start();
	include_once('inc/analyser.php');
	
	$user_names = $_SESSION["user_names"];
	$problems = $_SESSION["problems"];
	
	foreach ($problems as $problem_id => $problem_title)
	{
		$problem_url = "http://sharecode.io/runs/problemset/problem/" . $problem_id;
		$results [$problem_id] = analyser ($problem_url, $user_names);
	}
	
	foreach ($results as $problem_results)
	{
		foreach ($problem_results as $username => $result)
		{
			if ($result['result'] === TRUE)
			{
				$_SESSION[$username] = 0;
			}
		}
	}
	$results ['error'] = false;
	echo json_encode($results);
?>