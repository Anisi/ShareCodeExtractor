<?php
session_start();

function get_problems()
{
	$problems = $_SESSION["problems"];
	
	if(isset($problems) AND !empty ($problems))
	{
		foreach ($problems as $problem_id => $problem_title)
		{
			echo $problem_id . ':' . $problem_title . PHP_EOL;
		}
	}
}

function get_usernames()
{
	$user_names = $_SESSION["user_names"];
	if(isset($user_names) AND !empty ($user_names))
	{
		foreach ($user_names as $username => $val)
		{
			echo $username . PHP_EOL;
		}
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
				</div>
				<div class="col-md-6">
				  <div class="form-group">
					<label for="exampleInputEmail1">Problems</label>
					<p class="help-block">Enter all problems that you are going to track them.<br>Enter just one problem per line and follow this pattern: problem id:custom title</p>
					<textarea class="form-control" id="problems" name="problems" rows="15" placeholder="Example: 1100:A" required><?php get_problems(); ?></textarea>
				  </div>
				  <button type="submit" class="btn btn-info">Let's GO!</button>
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
