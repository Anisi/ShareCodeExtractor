<?php
$input_user_names = $_POST["usernames"];
$input_problems = $_POST["problems"];

// explode textarea inputs into arrays
// user names
$input_user_names	= 	explode (PHP_EOL, $input_user_names);
foreach ($input_user_names as $user_name)
{
	if (!empty ($user_name))
	{
		$user_names [$user_name] = 1;
	}
}
// problems
$input_problems	= 	explode (PHP_EOL, $input_problems);
foreach ($input_problems as $problem)
{
	if (!empty ($problem))
	{
		$problem = explode (':', $problem);
		$problem_id = trim($problem [0]);
		if (isset ($problem [1]))
		{
			$problems[$problem_id] = trim($problem [1]);
		}
		else
		{
			$problems[$problem_id] = $problem_id;
		}
	}
}

// putting arrays in session
session_start();
session_unset(); 
$_SESSION["user_names"]	=	$user_names;
$_SESSION["problems"]	=	$problems;

header('Location: ranklist.php');
?>