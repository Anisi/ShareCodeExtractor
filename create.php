<?php
date_default_timezone_set('UTC');

session_start();
session_unset(); 
if(@$_GET["destroy"] == 1)
{
	header('Location: index.php');
	exit();
}
$input_user_names = $_POST["usernames"];
$input_problems = $_POST["problems"];
$input_starttime = $_POST["starttime"];

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
$_SESSION["user_names"]	=	$user_names;
$_SESSION["problems"]	=	$problems;

$input_starttime = trim($input_starttime);
$ho = strval(substr($input_starttime,0,2));
$min = strval(substr($input_starttime,3,2));
$sec = strval(substr($input_starttime,6,2));
$_SESSION["starttime"]	=	mktime($ho, $min, $sec, date("m"), date("d"), date("Y"));

header('Location: ranklist.php');
?>