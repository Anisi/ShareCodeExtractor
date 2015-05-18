<?php
date_default_timezone_set('UTC');
session_start();

function get_problems()
{
	$problems = @$_SESSION["problems"];
	$problems_num = count($problems);
	$i = 0;
	
	if(isset($problems) AND !empty ($problems))
	{
		foreach ($problems as $problem_id => $problem_title)
		{
			echo $problem_id . ':' . $problem_title;
			if ($i < $problems_num-1)
			{
				echo PHP_EOL;
			}
			$i++;
		}
	}
}

function get_usernames()
{
	$user_names = @$_SESSION["user_names"];
	$user_names_num = count($user_names);
	$i = 0;
	
	if(isset($user_names) AND !empty ($user_names))
	{
		foreach ($user_names as $username => $val)
		{
			echo $username;
			if ($i < $user_names_num-1)
			{
				echo PHP_EOL;
			}
			$i++;
		}
	}
}

function get_starttime()
{
	$starttime = @$_SESSION["starttime"];
	if(isset($starttime) AND !empty ($starttime))
	{
			echo date('H:i:s', $starttime);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mojtaba Anisi">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title>VCPC Competition Rank List</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
    <!--
	Bootstrap RTL theme 
    <link href="css/bootstrap-rtl.min.css" rel="stylesheet">
	-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.js"></script>
    <![endif]-->
  </head>

  <body role="document">
      
	<div class="container-fluid">
		<form action = "create.php" method = "post">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header">
					  <h1>CodeShare extractor <small>Create new contest</small></h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				  <div class="form-group">
					<label for="exampleInputEmail1">User names</label>
					<p class="help-block">Enter all user names that you are going to track there results.<br>Enter just one user name per line.</p>
					<textarea class="form-control" id="usernames" name="usernames" rows="15" required><?php get_usernames(); ?></textarea>
				  </div>
				  <div class="form-group">
					<input class="form-control" id="starttime" name="starttime" value ="<?php get_starttime(); ?>" placeholder="Start Time. Example: 22:12:00" required>
				  </div>
				</div>
				<div class="col-md-6">
				  <div class="form-group">
					<label for="exampleInputEmail1">Problems</label>
					<p class="help-block">Enter all problems that you are going to track them.<br>Enter just one problem per line and follow this pattern: problem id:custom title</p>
					<textarea class="form-control" id="problems" name="problems" rows="15" placeholder="Example: 1100:A" required><?php get_problems(); ?></textarea>
				  </div>
				  <button type="submit" class="btn btn-info">Let's GO!</button>
				  <a class="btn btn-danger" href="create.php?destroy=1">Destroy All Data</a>
				</div>
			</div>
		</form>
		<p> Powered By <a href="http://mojtabaanisi.com/">Mojtaba Anisi</a><a href="ranklist.php" class = "pull-right">Rank List</a></p>
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
