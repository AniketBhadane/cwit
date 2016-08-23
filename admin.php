<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['priv'] != "admin") {
    header("Location: index.php");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	unset($_SESSION['name']);  
	unset($_SESSION['id']);  
	unset($_SESSION['priv']);  
	session_destroy();  
	header("Location: index.php");
	die();
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
				<p class="navbar-text">Signed in as <?php echo $_SESSION['name'] . " (" . $_SESSION['priv'] . ")";?></p>
				<form class="navbar-form navbar-right" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<button id="btnLogout" type="submit" class="btn btn-success">Logout</button>	
				</form>
			</div><!--/.navbar-collapse -->
		  </div>
		</nav>
	
		<div class="container admin-tabs-container">
			<nav class="text-center">
				<ul class="nav nav-tabs center-tabs">
					<li role="presentation" id="staff-tab" class="active"><a href="#">Staff</a></li>
					<li role="presentation" id="subjects-tab"><a href="#">Subjects</a></li>
				</ul>
			</nav>
		</div>
		
		<div class="container" id="staff-container">
			<div class="row">
				<div class="form-group col-md-3 col-md-offset-3">
					<select id="dept_select_staff" class="form-control">
						<option selected disabled>Select Department</option>
						<option value="comp">Computer</option>
						<option value="electrical">Electrical</option>
						<option value="mech">Mechanical</option>
						<option value="civil">Civil</option>
						<option value="electronics">Electronics</option>
					</select>
				</div>
				<div class=" form-group col-md-3" style="text-align: left">
					<button id="btnStaffSubmit" class="btn btn-primary">Submit</button>
				</div>
			</div>
			
			<div id="staff_results_container" class="hidden">
			
				<div id="add_new_staff_container">
					<div class="row">
						<h3>Add New Staff</h3>
						<div class="form-group col-md-3">
							<input type="text" placeholder="Staff Name" id="staff_name_input" class="form-control">
						</div>
						<div class="form-group col-md-2">
							<input type="text" placeholder="Login Id" id="staff_id_input" class="form-control">
						</div>
						<div class="form-group col-md-2">
							<input type="password" placeholder="Password" id="staff_pass_input" class="form-control">
						</div>
						<div class="form-group col-md-3">
							<select id="staff_dept_input" class="form-control">
								<option selected disabled>Select Department</option>
								<option value="comp">Computer</option>
								<option value="electrical">Electrical</option>
								<option value="mech">Mechanical</option>
								<option value="civil">Civil</option>
								<option value="electronics">Electronics</option>
							</select>
						</div>
						<div class="form-group col-md-2">
							<select id="staff_priv_input" class="form-control">
								<option selected disabled>Select Privilege</option>
								<option value="admin">Admin</option>
								<option value="staff">Staff</option>
							</select>
						</div>
					</div>
					<div class="alert alert-danger hidden" id="missing_new_staff" style="margin-bottom: 10px;" role="alert">Missing</div>
					<button class="btn btn-default" id="add_new_staff_btn">Add</button>
					
				</div>
							
				<h3>View / Delete Staff</h3>
				
				<table class="table table-hover" id="staff_results_table">
					<thead>
						<tr> <th class="col-xs-1">#</th> <th class="col-xs-3">Name</th> <th class="col-xs-3">Id</th> <th class="col-xs-3">Privilege</th> <th class="col-xs-2">Operation</th> </tr>
					</thead>
					<tbody style="text-align: left"></tbody>
				</table>
			</div>	
		</div>
		
		<div class="container hidden" id="subjects-container">
			<div class="row">
				<div class="form-group col-md-3 col-md-offset-3">
					<select id="dept_select" class="form-control">
						<option selected disabled>Select Department</option>
						<option value="comp">Computer</option>
						<option value="electrical">Electrical</option>
						<option value="mech">Mechanical</option>
						<option value="civil">Civil</option>
						<option value="electronics">Electronics</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<select id="year_select" class="form-control">
						<option selected disabled>Select Year</option>
						<option value="fy">FY</option>
						<option value="sy">SY</option>
						<option value="ty">TY</option>
					</select>
				</div>
			</div>
			<div class="alert alert-danger hidden" id="missing_select" role="alert"></div>
			<button id="btnSubjectsSubmit" class="btn btn-primary">Submit</button>
			
			<div id="results_container" class="hidden">
				<p class="text-muted" id="results_desc">Showing results for</p>
				
				<div class="row" id="add_new_subj_container">
					<h3>Add New Subject</h3>
					<div class=" form-group col-md-3 col-md-offset-3">
						<input type="text" placeholder="Add New Subject" id="add_new_subj_input" class="form-control">
					</div>
					<div class=" form-group col-md-3" style="text-align: left">
						<button class="btn btn-default" id="add_new_subj_btn">Add</button>
					</div>
				</div>
				
				<h3>View / Delete Subject</h3>
				<p class="text-danger" style="text-align: left">* Deleting a subject will also delete all notes in it.</p>
				
				<table class="table table-hover" id="results_table">
					<thead>
						<tr> <th class="col-xs-2">#</th> <th class="col-xs-8">Subject</th> <th class="col-xs-2">Operation</th> </tr>
					</thead>
					<tbody style="text-align: left"></tbody>
				</table>
			</div>
			
		</div>
		
		
		
		<footer class="footer">
		  <div class="container">
			<p class="text-muted">Made by <a href="https://in.linkedin.com/in/aniketbhadane" target="_blank">Aniket Bhadane</a> for CWIT.</p>
		  </div>
		</footer>
		
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
			
				$("#staff-tab").click(function(){
					$('#subjects-tab').removeClass('active');
					$('#staff-tab').addClass('active');
					$('#subjects-container').removeClass('show').addClass('hidden');
					$('#staff-container').removeClass('hidden').addClass('show');
				});
				
				$("#subjects-tab").click(function(){
					$('#staff-tab').removeClass('active');
					$('#subjects-tab').addClass('active');
					$('#subjects-container').removeClass('hidden').addClass('show');
					$('#staff-container').removeClass('show').addClass('hidden');
				});
				
				$("#add_new_staff_btn").click(function(){
					
					var name = $('#staff_name_input').val();
					var id = $('#staff_id_input').val();
					var pass = $('#staff_pass_input').val();
					var staff_dept = $('#staff_dept_input').val();
					var priv = $('#staff_priv_input').val();
					
					var missing = "Missing";
					
					if(name == null || name == "")
						missing = missing + " Name,";
					if(id == null || id == "")
						missing = missing + " Id,";
					if(pass == null || pass == "")
						missing = missing + " Password,";
					if(staff_dept == null)
						missing = missing + " Department,";
					if(priv == null)
						missing = missing + " Privilege,";
					if(missing != "Missing") {
						missing = missing.slice(0, -1);
						$('#missing_new_staff').empty();
						$('#missing_new_staff').removeClass('hidden').addClass('show');
						$('#missing_new_staff').append(missing);
						return;						
					}
					
					if(confirm("Do you really want to add new staff?")) {
						
						$.ajax({
							url: "add_staff.php",
							type: "POST",
							beforeSend: function() {
								$("#add_new_staff_btn").prop('disabled', true);
							},
							data: {
								name: name,
								id: id,
								pass: pass,
								dept: staff_dept,
								priv: priv
							}
						}).done(function (data) {
							$("#add_new_staff_btn").prop('disabled', false);
							$('#missing_new_staff').removeClass('show').addClass('hidden');
							if(data == "Success") {
								alert(data);
								$('#staff_name_input').val("");
								$('#staff_id_input').val("");
								$('#staff_pass_input').val("");
								$("#staff_dept_input").prop('selectedIndex',0);
								$("#staff_priv_input").prop('selectedIndex',0);
								$("#btnStaffSubmit").click();
							} else
								alert(data);
						}).fail(function( jqXHR, textStatus, errorThrown ) {
							alert( "Request failed: " + textStatus + " , " + errorThrown );
						});
					}
				});
				
				$("#btnStaffSubmit").click(function(){
					var staff_dept = $('#dept_select_staff').val();
					
					if(staff_dept == null)
						return;						
					
					$.ajax({
						url: "fetch_staff.php",
						type: "POST",
						beforeSend: function() {
							$("#btnStaffSubmit").prop('disabled', true);
						},
						data: {
							dept: staff_dept,
						}
					}).done(function (data) {
					
						$('#staff_results_container').removeClass('hidden').addClass('show');
						
						var arr = JSON.parse(data);
						
						$("#staff_results_table tbody").empty();
						
						$("#btnStaffSubmit").prop('disabled', false);
						
						for(var i = 0; i < arr.length; i++) {
							$('#staff_results_table tbody').append("<tr><td class='col-xs-1'>" + (i + 1) + "</td><td class='col-xs-3'>" + arr[i]["Name"] + "</td><td class='col-xs-3'>" + arr[i]["Id"] + "</td><td class='col-xs-3'>" + arr[i]["Privilege"] + "</td><td class='col-xs-2'><button class='deleteStaff btn btn-default' value='" + arr[i]["Id"] + "'>DELETE</button></td></tr>");							
						}
												
					}).fail(function( jqXHR, textStatus, errorThrown ) {
						alert( "Request failed: " + textStatus + " , " + errorThrown );
					});
				});
				
				$(document).on("click", ".deleteStaff", function(){
					
					if(confirm("Do you really want to delete staff?")) {
						var id = $(this).val();
						$.ajax({
							url: "delete_staff.php",
							type: "POST",
							data: {
								id: id,
							}
						}).done(function (data) {
							if(data == "Success") {
								alert(data);
								$("#btnStaffSubmit").click();
							} else
								alert(data);
						}).fail(function( jqXHR, textStatus, errorThrown ) {
							alert( "Request failed: " + textStatus + " , " + errorThrown );
						});
					}
				});
				
				var dept;
				var year;
				
				$("#btnSubjectsSubmit").click(function(){
					
					dept = $('#dept_select').val();
					year = $('#year_select').val();
					
					var missing = "Missing";
					
					if(dept == null)
						missing = missing + " Department,";
					if(year == null)
						missing = missing + " Year,";
					if(missing != "Missing") {
						missing = missing.slice(0, -1);
						$('#missing_select').empty();
						$('#missing_select').removeClass('hidden').addClass('show');
						$('#missing_select').append(missing);
						return;						
					}

					get_subjects_list();
				
				});
				
				function get_subjects_list() {
					$.ajax({
						url: "fetch_subjects.php",
						type: "POST",
						beforeSend: function() {
							//$("#subject_select").empty();
							//$('#subject_select').append("<option selected disabled>Please Wait</option>");
							$("#btnSubjectsSubmit").prop('disabled', true);
						},
						data: {
							dept: dept,
							year: year,
						}
					}).done(function (data) {
						
						//alert(data);
						
						$("#results_desc").text("Showing results for " + dept + " " + year);
						$('#results_container').removeClass('hidden').addClass('show');
						$('#missing_select').removeClass('show').addClass('hidden');
						
						var arr = JSON.parse(data);
						$("#results_table tbody").empty();
						$("#btnSubjectsSubmit").prop('disabled', false);
						$.each(arr, function(key, val) {
							if(val!="")
								$('#results_table tbody').append("<tr><td class='col-xs-2'>" + (key + 1) + "</td><td class='col-xs-8'>" + val + "</td><td class='col-xs-2'><button class='deleteSubject btn btn-default' value='" + val + "'>DELETE</button></td></tr>");
						});
						
						//alert(arr);
						
					}).fail(function( jqXHR, textStatus, errorThrown ) {
						alert( "Request failed: " + textStatus + " , " + errorThrown );
					});
				}
				
				
				$("#add_new_subj_btn").click(function(){
					
					if(confirm("Do you really want to add new subject?")) {
						var subject = $("#add_new_subj_input").val();
						
						$.ajax({
							url: "add_subject.php",
							type: "POST",
							beforeSend: function() {
								$("#add_new_subj_btn").prop('disabled', true);
							},
							data: {
								dept: dept,
								year: year,
								subject: subject,
							}
						}).done(function (data) {
							$("#add_new_subj_btn").prop('disabled', false);
							if(data == "Success") {
								alert(data);
								$("#add_new_subj_input").val("");
								$("#btnSubjectsSubmit").click();
							} else
								alert(data);
						}).fail(function( jqXHR, textStatus, errorThrown ) {
							alert( "Request failed: " + textStatus + " , " + errorThrown );
						});
					}
					
				});
				
				$(document).on("click", ".deleteSubject", function(){
					
					if(confirm("Do you really want to delete?")) {
						var subject = $(this).val();
						//alert(link);
						$.ajax({
							url: "delete_subject.php",
							type: "POST",
							data: {
								dept: dept,
								year: year,
								subject: subject,
							}
						}).done(function (data) {
							if(data == "Success") {
								alert(data);
								$("#btnSubjectsSubmit").click();
							} else
								alert(data);
						}).fail(function( jqXHR, textStatus, errorThrown ) {
							alert( "Request failed: " + textStatus + " , " + errorThrown );
						});
					}
				});
				
			}); 
			
		</script>
	
	</body>

</html>

