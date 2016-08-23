<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['priv'] != "staff") {
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
	
		<!--Upload-->
		<div class="container" id="upload_container">
			<div class="jumbotron">	

				<h2>Upload Notes</h2>
				<form id="upload_form" enctype="multipart/form-data"> 
				
					<div class="row">
					<div class="form-group col-md-3">
					<select id="dept_select_u" name = "dept" class="form-control">
						<option selected disabled>Select Department</option>
						<option value="comp">Computer</option>
						<option value="electrical">Electrical</option>
						<option value="mech">Mechanical</option>
						<option value="civil">Civil</option>
						<option value="electronics">Electronics</option>
					</select>
					</div>
					<div class="form-group col-md-3">
					<select id="year_select_u" name = "year" class="form-control">
						<option selected disabled>Select Year</option>
						<option value="fy">FY</option>
						<option value="sy">SY</option>
						<option value="ty">TY</option>
					</select>
					</div>
					<div class="form-group col-md-3">
					<select id="subject_select_u" name = "subject" class="form-control">
						<option selected disabled>Select Subject</option>
					</select>
					</div>
					<div class="form-group col-md-3">
					<select id="chapter_select_u" name = "chapter" class="form-control">
						<option selected disabled>Select Chapter</option>
						<option value="ch1">Ch1</option>
						<option value="ch2">Ch2</option>
						<option value="ch3">Ch3</option>
						<option value="ch4">Ch4</option>
						<option value="ch5">Ch5</option>
						<option value="ch6">Ch6</option>
					</select>
					</div>
				
					</div>
					<div class="form-group">
					<input type="file" name="myFile" />
					</div>
					<div class="alert alert-danger hidden" id="missing_select_upload" role="alert"></div>
					<input type="submit" name="upload" value="Upload" class="btn btn-primary" />
				</form>
		
			</div>
		</div>
		
		<!--View-->
		<div class="container">
			<div class="jumbotron">		  
			
				<h2>View Notes</h2>
				
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

				$("#dept_select_u").change(function () {
					var dept = this.value;
					var year = $('#year_select_u').val();

					get_subjects_list(dept, year, "#subject_select_u");
					
				});
				
				$("#year_select_u").change(function () {
					var year = this.value;
					var dept = $('#dept_select_u').val();
					
					get_subjects_list(dept, year, "#subject_select_u");
					
				});
			
				$("#dept_select").change(function () {
					var dept = this.value;
					var year = $('#year_select').val();

					get_subjects_list(dept, year, "#subject_select");
					
				});
				
				$("#year_select").change(function () {
					var year = this.value;
					var dept = $('#dept_select').val();
					
					get_subjects_list(dept, year, "#subject_select");
					
				});
				
				
				function get_subjects_list(dept, year, dropdown) {
					$.ajax({
						url: "fetch_subjects.php",
						type: "POST",
						beforeSend: function() {
							$(dropdown).empty();
							$(dropdown).append("<option selected disabled>Please Wait</option>");
							$(dropdown).prop('disabled', true);
						},
						data: {
							dept: dept,
							year: year,
						}
					}).done(function (data) {
						
						//alert(data);
						var arr = JSON.parse(data);
						$(dropdown).empty();
						$(dropdown).prop('disabled', false);
						$(dropdown).append("<option selected disabled>Select Subject</option>");
						$.each(arr, function(key, val) {
							if(val!="")
								$(dropdown).append("<option value='" + val + "'>" + val + "</option>");
						});
						
						
					}).fail(function( jqXHR, textStatus, errorThrown ) {
						alert( "Request failed: " + textStatus + " , " + errorThrown );
					});
				}		

				
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
							$("#ch1").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-9'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div>"
							+ "<div class='form-group col-md-2'><button class='deleteNotes btn btn-default' value='" + arr[i] + "'>DELETE</button></div></div>");
							i++;
						}		

						while(arr[i].split("\\").slice(-2, -1)[0] == "ch2") {
							$("#ch2").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-9'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div>"
							+ "<div class='form-group col-md-2'><button class='deleteNotes btn btn-default' value='" + arr[i] + "'>DELETE</button></div></div>");
							i++;
						}		

						while(arr[i].split("\\").slice(-2, -1)[0] == "ch3") {
							$("#ch3").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-9'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div>"
							+ "<div class='form-group col-md-2'><button class='deleteNotes btn btn-default' value='" + arr[i] + "'>DELETE</button></div></div>");
							i++;
						}		

						while(arr[i].split("\\").slice(-2, -1)[0] == "ch4") {
							$("#ch4").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-9'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div>"
							+ "<div class='form-group col-md-2'><button class='deleteNotes btn btn-default' value='" + arr[i] + "'>DELETE</button></div></div>");
							i++;
						}		
						
						while(arr[i].split("\\").slice(-2, -1)[0] == "ch5") {
							$("#ch5").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-9'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div>"
							+ "<div class='form-group col-md-2'><button class='deleteNotes btn btn-default' value='" + arr[i] + "'>DELETE</button></div></div>");
							i++;
						}		
						
						while(arr[i].split("\\").slice(-2, -1)[0] == "ch6") {
							$("#ch6").append("<div class='row note'><div class='form-group col-md-offset-1 col-md-9'><a class='btn btn-default' role='button' href = '" + arr[i] + "' target='_blank'>" + arr[i].split("\\").pop() + "</a></div>"
							+ "<div class='form-group col-md-2'><button class='deleteNotes btn btn-default' value='" + arr[i] + "'>DELETE</button></div></div>");
							i++;
						}								
						
						/*for(var i = 0; i < arr.length; i++) {
							$("#results").append("<a href = '" + arr[i] + "'>" + arr[i].split("\\").pop() + "</a><br />");
							
						}*/
					}).fail(function( jqXHR, textStatus, errorThrown ) {
						alert( "Request failed: " + textStatus + " , " + errorThrown );
					});
				}); 
				
			
				$(document).on("click", ".deleteNotes", function(){
					
					if(confirm("Do you really want to delete?")) {
						var link = $(this).val();
						
						$.ajax({
							url: "delete_notes.php",
							type: "POST",
							data: {
								link: link,
							}
						}).done(function (data) {
							if(data == "Success")
								$("#btnSubmit").click();
							else
								alert(data);
						}).fail(function( jqXHR, textStatus, errorThrown ) {
							alert( "Request failed: " + textStatus + " , " + errorThrown );
						});
					}
				});
			
			
			
				// Variable to hold request
				var request;
			
				// Bind to the submit event of our form
				$("#upload_form").submit(function(event){

					// Prevent default posting of form
					event.preventDefault();
				
					// Abort any pending request
					if (request) {
						request.abort();
					}
					var formData = new FormData($(this)[0]);
					
					// setup some local variables
					var $form = $(this);
					
					// Let's select and cache all the fields
					var $inputs = $form.find("input, select, button, textarea");

					// Serialize the data in the form
					//var serializedData = $form.serialize();

					
					// Let's disable the inputs for the duration of the Ajax request.
					// Note: we disable elements AFTER the form data has been serialized.
					// Disabled form elements will not be serialized.
					$inputs.prop("disabled", true);

					// Fire off the request to upload.php
					request = $.ajax({
						url: "upload.php",
						type: "POST",
						data: formData, // earlier was serializedData, but it does not support sending files, hence using formData
						contentType: false,
						processData: false //jQuery processes the data attribute and converts the values into strings, so make it false
					});

					// Callback handler that will be called on success
					request.done(function (response, textStatus, jqXHR){
						
						if(response == "Success") {
							$('#missing_select_upload').removeClass('show').addClass('hidden');
							$("#dept_select").prop('selectedIndex',0);
							$("#year_select").prop('selectedIndex',0);
							$("#subject_select").empty();
							$("#subject_select").append("<option selected disabled>Select Subject</option>");
							$("#results_desc").empty();
							$(".results").empty();
							$('#results_container').removeClass('show').addClass('hidden');
							alert("File added successfully.");
						} else {
							$('#missing_select_upload').empty();
							$('#missing_select_upload').removeClass('hidden').addClass('show');
							$('#missing_select_upload').append(response);
						}
					});

					// Callback handler that will be called on failure
					request.fail(function (jqXHR, textStatus, errorThrown){
						// Log the error to the console
						alert(
							"The following error occurred: "+
							textStatus + errorThrown
						);
					});

					// Callback handler that will be called regardless
					// if the request failed or succeeded
					request.always(function () {
						// Reenable the inputs
						$inputs.prop("disabled", false);
					});

					
				});
			
			
			}); 
			
		</script>
	
	</body>

</html>