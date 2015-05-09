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

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1 class="text-center">ACM ICPC Programming Contest</h1>
		<h2 class="text-center">Vali-e-asr University Of Rafsanjan</h2>
		<h3 class="text-center" id = "datetime"></h3>
      </div>
<div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center">#</th>
				<th class="text-center">Name</th>
				<?php
				session_start();
				$user_names = $_SESSION["user_names"];
				$problems = $_SESSION["problems"];
				$problems_num = count ($problems);
				
				foreach ($problems as $problem_id => $problem_title):
				?>
				
                <th class="text-center"><?php echo $problem_title ?></th>
				
				<?php
				endforeach;
				?>
              </tr>
            </thead>
            <tbody>
			<?php	
			$i = 1;
			foreach ($user_names as $user_name => $val):
			?>
              <tr>
				<td class="text-center"><?php echo $i; ?></td>
                <td><?php echo $user_name; ?></td>
				<?php	
				for ($j = 0; $j < $problems_num; $j++):
				?>
                <td class="text-center">-<span class="clearfix">-</span></td>
				<?php
				endfor;
				?>
              </tr>
			<?php
			$i++;
			endforeach;
			?>
            </tbody>
          </table>
        </div>
     
      </div>
		<p> Powered By <a href="http://mojtabaanisi.com/">Mojtaba Anisi</a> <span class="pull-right">Lastest refresh: <strong id = "timer">0</strong> seconds ago</span></p>
</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script src="js/moment-jalaali.js"></script>
	<script src="js/ajaxloading.js"></script>
	<script>
		var datetime = null,
        date = null;

		var update = function () {
			date = moment(new Date())
			datetime.html(date.format('dddd, jD jMMMM jYYYY, h:mm:ss a'));
		};

		$(document).ready(function(){
			datetime = $('#datetime')
			update();
			setInterval(update, 1000);
		});
	</script>
  </body>
</html>
