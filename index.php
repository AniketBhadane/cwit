<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	include 'db_config.php';
	$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

	function test_input($data, $con)
	{
		 $data = trim($data);
		 $data = stripslashes($data);
		 $data = htmlspecialchars($data);
		 $data = mysqli_real_escape_string($con, $data);
		 return $data;
	}

	$id = test_input($_POST["id"], $con);
	$password = test_input($_POST["password"], $con);

	if(!empty($id) and !empty($password)) {
		$sql = "SELECT * from staff WHERE staff_login_id = '$id' AND staff_password = '$password'";
		$res = mysqli_query($con,$sql);

		if (mysqli_num_rows($res) > 0) {

			$row = mysqli_fetch_array($res);
			
			//if (!isset($_SESSION['id'])) {

			$_SESSION['name'] = $row["staff_name"];
			$_SESSION['id'] = $row["staff_login_id"];
			$_SESSION['priv'] = $row["privilege"];
			
			if($row["privilege"] == "admin") {
				header("Location: admin.php");
			} else if($row["privilege"] == "staff") {
				header("Location: staff.php");
			}
			
			die();
			//}
		} else {
			$error = " [ <em><u>Invalid Id/Password</u></em> ]";
		}
	}
}

?>
<!DOCTYPE html>
<html>
	
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="An initiative by CWIT to let students have online access to study material and notes. Find notes by department, year and subject.">
		<meta name="author" content="Aniket Bhadane">
		<link rel="icon" href="favicon.ico">

		<title>CWIT Learning Management System</title>

		<!-- Bootstrap core CSS -->
		<link href="docs/bootstrap.min.css" rel="stylesheet">

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="docs/ie10-viewport-bug-workaround.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="docs/ext_css.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
	<body>
	
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">CWIT LMS</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">			  
				<form class="navbar-form navbar-right" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="form-group">
					<input name="id" id="login_id" type="text" placeholder="Login Id" class="login_input form-control">
					</div>
					<div class="form-group">
					<input name="password" id="login_password" type="password" placeholder="Password" class="login_input form-control">
					</div>
					<button id="btnSignin" type="submit" class="btn btn-success">Sign in</button>
				</form>			
				<p class="navbar-text navbar-right" id="login_label">Staff / Admin Login<?php echo $error;?></p>			  
			</div><!--/.navbar-collapse -->
		  </div>
		</nav>
	
		<!-- Main jumbotron for a primary message or call to action -->
		<div class="jumbotron">
		  <div class="container">
		  
			<div class="row">
				<div class="col-md-3 col-md-offset-0 col-xs-8 col-xs-offset-2 vcenter">
					<img src="college_logo.png" />
				</div><!-- refer this as to why comments are added here: http://stackoverflow.com/a/20548578/5155835
				--><div class="col-md-9 vcenter">
					<h1>Cusrow Wadia Institute of Technology, Pune - 1</h1>
				</div>
			</div>
			
			<h2>Learning Management System</h2>
			<p>An initiative by CWIT to let students have online access to study material and notes. Find the notes by selecting appropriate department, year and subject.</p>
			<!--p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p-->
			<!--p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p-->
			<div class="row">
				<div class="form-group col-md-4">
					<select id="dept_select" class="form-control">
						<option selected disabled>Select Department</option>
						<option value="comp">Computer</option>
						<option value="electrical">Electrical</option>
						<option value="mech">Mechanical</option>
						<option value="civil">Civil</option>
						<option value="electronics">Electronics</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<select id="year_select" class="form-control">
						<option selected disabled>Select Year</option>
						<option value="fy">FY</option>
						<option value="sy">SY</option>
						<option value="ty">TY</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<select id="subject_select" class="form-control">
						<option selected disabled>Select Subject</option>
					</select>
				</div>
			</div>
			<div class="alert alert-danger hidden" id="missing_select" role="alert"></div>
			<button id="btnSubmit" class="btn btn-primary">Submit</button>
		  </div>
		</div>
	
		<div class="container-fluid hidden" id="results_container">
		
			<p id="results_desc"></p>			
			
			<div class="alert alert-info ch_results" role="alert">Chapter 1</div>
			<div class="results" id="ch1"></div>
			<div class="alert alert-info ch_results" role="alert">Chapter 2</div>
			<div class="results" id="ch2"></div>
			<div class="alert alert-info ch_results" role="alert">Chapter 3</div>
			<div class="results" id="ch3"></div>
			<div class="alert alert-info ch_results" role="alert">Chapter 4</div>
			<div class="results" id="ch4"></div>
			<div class="alert alert-info ch_results" role="alert">Chapter 5</div>
			<div class="results" id="ch5"></div>
			<div class="alert alert-info ch_results" role="alert">Chapter 6</div>
			<div class="results" id="ch6"></div>
	
		</div>
		
		<footer class="footer">
		  <div class="container">
			<p class="text-muted">Made by <a href="https://in.linkedin.com/in/aniketbhadane" target="_blank">Aniket Bhadane</a> for CWIT.</p>
		  </div>
		</footer>

	<!-- on admin page, admin can create and delete staff login, and add and delete subjects from dept dropdown ->year dropdown ->subjects listed
	
	<!-- dropdowns: dept, year, subject : chapter wise notes will be displayed -->
	
		
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="docs/jquery.min.js"><\/script>')</script>
		<script src="docs/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="docs/ie10-viewport-bug-workaround.js"></script>
		<script>
		
			$(function(){

				$(".login_input").keyup(function (e) {
					var keyCode = e.keyCode || e.which;
					if (keyCode == 13) {
						$("#btnSignin").click();
					}
				});
			
				/*$("#btnSignin").click(function(){
					$.ajax({
						url: "login.php",
						type: "POST",
						beforeSend: function() {
							$("#btnSignin").prop('disabled', true);
						},
						data: {
							id: $("#login_id").val(),
							password: $("#login_password").val(),
						}
					}).done(function (data) {					
						
						if(data == "Success")
							window.location = "http://localhost/cwit/staff.php";	
						else {
							$("#login_label").html("Staff / Admin Login [ <em><u>Invalid Id/Password</u></em> ]");
							$("#btnSignin").prop('disabled', false);
						}
						
					}).fail(function( jqXHR, textStatus, errorThrown ) {
						alert( "Request failed: " + textStatus + " , " + errorThrown );
					});
				});*/
			
				$("#dept_select").change(function () {
					var dept = this.value;
					var year = $('#year_select').val();

					get_subjects_list(dept, year);
					
				});
				
				$("#year_select").change(function () {
					var year = this.value;
					var dept = $('#dept_select').val();
					
					get_subjects_list(dept, year);
					
				});
				
				
				function get_subjects_list(dept, year) {
					$.ajax({
						url: "fetch_subjects.php",
						type: "POST",
						beforeSend: function() {
							$("#subject_select").empty();
							$('#subject_select').append("<option selected disabled>Please Wait</option>");
							$("#subject_select").prop('disabled', true);
						},
						data: {
							dept: dept,
							year: year,
						}
					}).done(function (data) {
						
						//alert(data);
						var arr = JSON.parse(data);
						$("#subject_select").empty();
						$("#subject_select").prop('disabled', false);
						$('#subject_select').append("<option selected disabled>Select Subject</option>");
						$.each(arr, function(key, val) {
							if(val!="")
								$('#subject_select').append("<option value='" + val + "'>" + val + "</option>");
						});
						
						
					}).fail(function( jqXHR, textStatus, errorThrown ) {
						alert( "Request failed: " + textStatus + " , " + errorThrown );
					});
				}
			
			// $("#results").append("<button class='deleteNotes' value='" + arr[i] + "'>DELETE</button><br />");
				$("#btnSubmit").click(function(){
					
					var dept = $('#dept_select').val();
					var year = $('#year_select').val();
					var subj_code = $('#subject_select').val();
					
					var missing = "Missing";
					
					if(dept == null)
						missing = missing + " Department,"
					if(year == null)
						missing = missing + " Year,"
					if(subj_code == null)
						missing = missing + " Subject,"
					if(missing != "Missing") {
						missing = missing.slice(0, -1);
						$('#missing_select').empty();
						$('#missing_select').removeClass('hidden').addClass('show');
						$('#missing_select').append(missing);
						return;						
					}				
					
					$.ajax({
						url: "fetch_links.php",
						type: "POST",
						data: {
							dept: dept,
							year: year,
							subj_code: subj_code,
						}
					}).done(function (data) {
						
						// append(), after(), before()
						
						//alert(data);
						
						$("#results_desc").text("Showing results for " + dept + " " + year + " " + subj_code);
						$(".results").empty();
						
						$('#results_container').removeClass('hidden').addClass('show');
						$('#missing_select').removeClass('show').addClass('hidden');
						
						var arr = JSON.parse(data);
						
						var i = 0;

						while(arr[i].split("\\").slice(-2, -1)[0] == "ch1") {									
							$("#ch1").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-11'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div></div>");
							i++;
						}		

						while(arr[i].split("\\").slice(-2, -1)[0] == "ch2") {
							$("#ch2").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-11'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div></div>");
							i++;
						}		

						while(arr[i].split("\\").slice(-2, -1)[0] == "ch3") {
							$("#ch3").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-11'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div></div>");
							i++;
						}		

						while(arr[i].split("\\").slice(-2, -1)[0] == "ch4") {
							$("#ch4").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-11'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div></div>");
							i++;
						}		
						
						while(arr[i].split("\\").slice(-2, -1)[0] == "ch5") {
							$("#ch5").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-11'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div></div>");
							i++;
						}		
						
						while(arr[i].split("\\").slice(-2, -1)[0] == "ch6") {
							$("#ch6").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-11'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div></div>");
							i++;
						}								
						
						/*for(var i = 0; i < arr.length; i++) {
							$("#results").append("<a href = '" + arr[i] + "'>" + arr[i].split("\\").pop() + "</a><br />");
							
						}*/
					}).fail(function( jqXHR, textStatus, errorThrown ) {
						alert( "Request failed: " + textStatus + " , " + errorThrown );
					});
				}); 
				
				
				
			
			}); 
			
		</script>
	
	</body>

</html>

