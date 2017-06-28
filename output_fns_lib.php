<?php
/*  File name: output_fns_lib
	File description: Output functions library 
	File author: Lens Kamdem
	Update date: 14/12/2015 at 11:22
*/
function output_header($title)
{
/*  Outputs the html header of the page
	Input: title 'string'; return: null
*/
?>
  <!DOCTYPE html>
  <html lang="en">
		<head>
			<title><?php echo $title;?></title>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial_scale=1" />
			<meta name="description" content="quizz management system, online test" />
			<meta name="keywords" content="programming, web disign, web development, network, telecommunication, test, quizz, cisco" />
			<!-- CSS sheet links -->
			<link href="styles/bootstrap-cosmo.min.css" rel="stylesheet" type="text/css" /> <!-- App main style -->
			<link href="styles/user-style.css" rel="stylesheet" type="text/css" />
			<!-- end -->
			
			<!-- HTML5 elements for all broswer script -->
			<script src="javascript/html5.js" type="text/javascript"></script>
		</head>
		<body>
		<!-- Body wrapper -->
		<div id="wrapper" class="container">
			<!-- Header Start -->
			<nav id="header" class="navbar navbar-default navbar-static-top" >
				<div class="container-fluid" >
				<div class="row">
					<div id="logo" class="navbar-header ">
						<a class="navbar-brand" href="index.php">QMS</a>
					</div>
					
					<div id="account_bar" class="nav navbar-nav navbar-right" >
				
						<?php
						if ($title != "login")
						{
							if(auth_check_valid_user())
							{
								echo "<form action=\"logout.php\" method=\"post\">
									<p>Hi ";
								if (auth_is_admin())
								{
									echo 	"<b>Administrator</b>";
								}
								echo 		"<br /> <span class=\"hl_text\"> ".$_SESSION['valid_user']." </span></p>
									<input type=\"submit\" value=\"Logout\" /> 
									</form>";
							}
						}
						?>
					</div>
				</div>
				<div class="row">
					<ul class="nav navbar-nav">
						<li class="active"><a href="main.php">Home</a></li>
						<li><a href="statistics.php">Statistics</a></li>
						<li><a href="about.php">About</a></li>
					</ul>
					<form action="test.php" method="get" class="navbar-form navbar-right inline-form">
						<div class="form-group">
							<label class="sr-only" for="search">Search</label>
							<input type="search" name="search" placeholder="find a test" class="form-control" />
							<button type="submit" class="btn btn-primary" />Find</button>
						</div>
					</form>
				</div>
				</div>
			</nav>
			<!-- Header END -->
			<!-- Main Content -->
			<div id="Container">
<?php
}
function output_scripts()
{
/*  It outputs the app's javascript scripts
	Input: null; return: null;
*/
?>
	</div>
	<!-- END body wrapper -->
	<!-- javascript scripts -->
	<script src="javascript/respond-min.js" type="text/javascript"></script>
	<!-- Users javascript libraires -->
	<script src="javascript/httprequest.js" type="text/javascript"></script>
	<script src="javascript/javascript_fns_lib.js" type="text/javascript"></script>
<?php	
}
function output_login_form($error)
{
/*  Outputs the login form
	Input: error 'boolean'; return: null
*/
?>
		<h1>Welcome to  QMS</h2>	
			<div id="login" class="center-box col-lg-offset-3 col-lg-6">
				<h2 class="text-center">Login</h2>
					<form method="post" name="login" class="form" role="form">
						<div class="alerts">
						<?php if ($error)
						{
							echo	"<p>".$_SESSION['error_msg']."</p>";
						}
						?>
					</div>
				<div class="form-group">
					<label for="user_name">Name</label>
					<input type="text" name="user_name" class="form-control">
				</div>
				<div class="form-group">
					<label for="code">Code</label>
					<input type="text" name="code" class="form-control" />
				</div>
				<div class="form-group">
				<button type="button" class="btn btn-primary" onclick="javascript_validate_login()">Login</button>
			
		</form>
	</div>
<?php
}
function output_footer()
{
/* Output the html footer of the page
	Input: null; return: null
*/
?>
			<footer id="footer">
	
			</footer>
		</body>
  </html>
  
<?php	
}
function output_view_field()
{
/*  It outputs and handles the processes of the view test page
	(An AJAX enable page)
	Input: null; return: null
*/
?>
  <div id="principal" class="col2">
 <?php
  $fields = test_get_field();
/* do_ajax function variables */

echo "<h2>Fields</h2>";
if (is_array($fields))
{
/* if rows return, execute function */
  echo "<ul id=\"list\">";
  $i = 1;
  foreach($fields as $field)
  {
    /* create counter for anchor elements id */
	echo "<li id=\"list_a".$i."\"><a onclick=\"javascript_goto('ass_get_level.php','?field=".stripslashes($field['id'])."')\">
	".stripslashes($field['name'])."</a></li>";
	$i++;
  }
  echo "</ul>";
  
}
else
{
  echo "<p>".$_SESSION['error_msg']."</p>";
}
?>  
  </div>
<?php
}
function output_view_level()
{
echo "<div id=\"principal\" class=\"col2\">";

$levels = test_get_level();
$field = test_get_name($_GET['field']);
/* do_ajax function variables */

echo "<hgroup>
			<h2>Levels</h2>
			<h3>".$field['name']."</h3>
		</hgroup>";
if (is_array($levels))
{
/* if rows are returned */
  echo "<ul id=\"list2\">";
  $i = 1;
  foreach($levels as $level)
  {
	echo "<li id=\list_a".$i."\"><a onclick=\"javascript_goto('ass_get_course.php','?level=".stripslashes($level['levels'])."&field=".$_GET['field']."')\">
	Year ".stripslashes($level['levels'])."</a></li>";
	$i++;
  }
  echo "</ul>";
}
else
{
  echo "<p>".$_SESSION['error_msg']."</p>";
}
echo "</div>";
}
function output_view_course()
{

echo "<div id=\"principal\" class=\"col2\">";

$courses = test_get_course($_GET['level'],$_GET['field']);
$field = test_get_name($_GET['field']);
/* do_ajax function variables */

echo "<hgroup>
			<h2>Courses</h2>
			<h3>Year ".$_GET['level']." ".$field['name']."</h3>
		</hgroup>";
if (is_array($courses))
{
/* if courses returned */
  echo "<ul id=\"list\">";
  $i = 1;
  foreach($courses as $course)
  {
	echo "<li><a onclick=\"javascript_goto('ass_get_test.php','?course=".stripslashes($course['id'])."&level=".$_GET['level']."&field=".$_GET['field']."')\">
	".stripslashes($course['id'])." ".stripslashes($course['name'])."</a></li>";
	$i++;
  }
  echo "</ul>";
}
else
{
/* Error, show error message */
  echo "<p>".$_SESSION['error_msg']."</p>";
}

echo "</div>";

}
function output_view_test()
{

echo "<div id=\"principal\" class=\"col2\">";

$error = false;
if (isset($_POST['field']))
{
/* if variables passed via post */
	$field_id = $_POST['field'];
	$level = $_POST['level'];
	$course_id = $_POST['course'];
	
	/* format and clean data */
	$test_name = datavalid_clean_data($_POST['test_name']);
	$test_description = datavalid_clean_data($_POST['test_description']);
	$test_topics = datavalid_clean_data($_POST['test_topics']);
	$test_duration = (int) datavalid_clean_data($_POST['test_duration']);
	$date = date("H:i");
	$no_questions = (int) $_POST['no_questions'];
	
	/* save test information */
	$conn = database_db_connect();
	$query = "insert into test values
				('','".$test_name."','".$test_duration."',".$no_questions.",'".$test_description."','".$test_topics."','".$date."',
				 '".$_SESSION['valid_user']."','".$course_id."')";
	$result = $conn->query($query);
	if (!$result)
	{
		$_SESSION['error_msg'] = "Error, could not execute query. Please try again";
		$error = true;
	}
	
	/* save questions */
	$test_inf = test_get_test_id($course_id,$test_name,$test_description,$_SESSION['valid_user']);
	$test_id = stripslashes($test_inf['id']);
	for($i=1;$i <= $no_questions;$i++)
	{
		$statement = datavalid_clean_data($_POST['statement_'.$i]);
		$answers = datavalid_clean_data($_POST['answers_'.$i]);
		$valid_answer = datavalid_clean_data($_POST['valid_answer_'.$i]);
		$file = datavalid_clean_data($_POST['file_'.$i]);
		if (!isset($_POST['file_'.$i]))
		{
			$file = "";
		}
		test_save_question($i,$test_id,$statement,$answers,$valid_answer,$file);
	}
}
else if (isset($_GET['field']))
{
/* if variables passed via get */
	$field_id = $_GET['field'];
	$level = $_GET['level'];
	$course_id = $_GET['course'];
}
$tests = test_get_test($course_id);
$course = test_get_a_course_info($course_id);
/* do_ajax function variable */
$field = test_get_name($field_id);
$query = "?level=".$level."&field=".$field_id."&course=".$course_id;

echo "<div class=\"wrapper\">
		<hgroup>
			<h2>Tests</h3>
			<h3>Year ".$level." ".$field['name']."</h3>
			<h4>".$course['name']."</h4>
		</hgroup>";
if ($error)
{
	echo "<div id=\"error\">
				<p>".$_SESSION['error_msg']."</p>
			</div>";
}
if (is_array($tests))
{
/* if tests returned */
  echo "<section id=\"test_list\" >";
  echo "<h5>Tests</h5>
			<ul>";
  foreach($tests as $test)
  {
	echo "<li><a href=\"view_test.php?test=".stripslashes($test['id'])."&level=".$level."&field=".$field_id."\">".stripslashes($test['name'])."</a></li>";
  }
  echo "</ul>
		</section>
		<section id=\"test_date\">
			<h5>Upload date</h5>
			<ul>";
	foreach($tests as $test)
  {
	echo "<li>".stripslashes($test['the_date'])."</li>";
  }
  echo "</ul>
		</section>";
}
else
{
/* Error, show error message */
  echo "<p>".$_SESSION['error_msg']."</p>";    
}
if (auth_is_admin())
  {
    echo "<form name=\"add_test\" method=\"get\" action=\"add_test.php\" class=\"clear wrapper\">
		    <input type=\"submit\" value=\"Add Test\" class=\"button margin_horiz_O left\">
			 <input type=\"hidden\" name=\"level\" value=\"".$level."\">
			 <input type=\"hidden\" name=\"field\" value=\"".$field_id."\">
			 <input type=\"hidden\" name=\"course\" value=\"".$course_id."\">
		  </form>";
  }
 echo "</div>";
 
 echo "</div>";
}
function output_view_stats()
{
/*  It outputs the tests and users statistics in a sidebar
	Input: null; return: null;
*/
?>
	<div id="statistics" class="col1">
		<h2>Statistics</h2>
			<section id="first_stats">
<?php			
				if (auth_is_admin())
				{
				/* Test results for courses where admin user is the lecturer */
				
					if (auth_is_lecturer($_SESSION['valid_user']))
					{
						$user_id = test_get_user_id($_SESSION['valid_user']);
						$test_stats = test_get_test_stats(stripslashes($user_id));
						if (is_array($test_stats))
						{
							$count = count($test_stats);
							if ($count > 5)
							{
								$count = 5;
							}
							echo "<ul>";
							for ($i=0;$i<+$count;$i++)
							{
								$test = test_get_a_test_info(stripslashes($test_stats[$i]['test_id']));
								$course = test_get_a_course_info(stripslashes($test['course_id']));
								echo "<li>".stripslashes($course['name'])."\t ".stripslashes($test['name'])."\t ".stripslashes($test_stats[$i]['percentade_pass'])."
									</li>";
							}
							echo "<ul>";
						}
						else
						{
							echo "<p>".$_SESSION['error_msg']."</p>";
						}
					}
				}
				else
				{
				/* Most recent users' test results */
				
					$user_id = test_get_user_id($_SESSION['valid_user']);
					$test_results = test_get_all_user_test_result(stripslashes($user_id));
					if (is_array($test_results))
					{
						$count = count($test_results);
						if ($count > 5)
						{
							$count = 5;
						}
						echo "<ul>";
						for ($i=0;$i<+$count;$i++)
						{
							$test = test_get_a_test_info(stripslashes($test_results[$i]['test_id']));
							echo 	"<li>".stripslashes($test['name'])."\t ".stripslashes($test['percentade_pass'])."\t ".stripslashes($test['grade'])."\t</li>";
						}
						echo "</ul>";
					}
					else
					{
						echo "<p>".$_SESSION['error_msg']."</p>";
					}
				}
?>
			</section>
			<section id="second_stats">
<?php
				if (auth_is_admin())
				{
				/* Most recent test results */
				
					$test_stats = test_get_stats();
				   if (is_array($test_stats))
					{
						$count = count($test_stats);
						if ($count > 5)
						{
							$count = 5;
						}
						echo "<ul>";
						for ($i=0;$i<+$count;$i++)
						{
							$test = test_get_a_test_info(stripslashes($test_stats[$i]['test_id']));
							$course = test_get_a_course_info(stripslashes($test['course_id']));
							echo "<li>".stripslashes($course['name'])."\t ".stripslashes($test['name'])."\t ".stripslashes($test_stats[$i]['percentade_pass'])."
									</li>";
						}
						echo "<ul>";
					}
					else
					{
						echo "<p>".$_SESSION['error_msg']."</p>";
					}
				}
				else
				{
				/* Tests' top scores in users' field and level */
				
					$user = test_get_user_info($_SESSION('valid_user'));
					$test_results2 = test_get_test_top_scores(stripslashes($user['levels']),stripslashes($user['field']));
					if (is_array($test_results2))
					{
						$count = count($test_results2);
						if ($count > 5)
						{
							$count = 5;
						}
						echo "<ul>";
						for ($i=0;$i<+$count;$i++)
						{
							$user_name = test_get_user_name(stripslashes($test_results2[$i]['user_id']));
							$test = test_get_a_test_info(stripslashes($test_results2[$i]['test_id']));
							$course = test_get_a_course_info(stripslashes($test['course_id']));
							echo "<li>".stripslashes($user_name)."\t ".stripslashes($test_results[$i]['percentade_pass'])." %\t ".stripslashes($test_results2[$i]['grade'])." \t 
									".stripslashes($test['name'])." \t ".stripslashes($course['name'])."</li>";
						}
						echo "</ul>";
					}
					else
					{
						echo "<p>".$_SESSION['error_msg']."</p>";
					}
				}
?>
			</section>
	</div>
<?php
}
function output_add_test()
{
/*  It outputs the add test HTML code
	 Input: null; return: null
*/
 $course = test_get_a_course_info($_GET['course']);
 $field = test_get_name($_GET['field']);
 
 echo "<div id=\"test_page\">";
 echo "<hgroup>
			<h2>Test</h2>
			<h3>Year ".$_GET['level']." ".$field['name']."</h3>
			<h4>".$course['name']."</h4>
		</hgroup>";
?>
  <form name="questionnaire" method="post" enctype="multipart/form-data" action="ass_get_test.php">
  <fieldset>
    <legend>Test Information</legend>
	  <ul>
	   <li><label>Name</label>
	     <input type="text" name="test_name"></li>
	   <li><label>Description</label>
	    <input type="text" name="test_description"></li>
       <li><label>Topics</label>
	     <input type="text" name="test_topics"></li>
	   <li><label>Duration (min)</label>
	     <input type="text" name="test_duration"> <span id="label">minutes</span></li>
	  </ul>
	  <?php echo "
			 <input type=\"hidden\" name=\"level\" value=\"".$_GET['level']."\">
			 <input type=\"hidden\" name=\"field\" value=\"".$_GET['field']."\">
			 <input type=\"hidden\" name=\"course\" value=\"".$_GET['course']."\">";
		?>
	</fieldset>
	<fieldset>
	  <legend>Questions</legend>
	  <ul id="questions">
	    
	  </ul>
	</fieldset>
	<div class="wrapper">
	   <input type="button" value="Add question" onclick="javascript_do_add_question()" class="button" />
		<input type="button" value="Save" onclick="javascript_save_test(question_counter,test_info)" class="button" />
	</div>	
	</form>
<?php
echo "</div>";
}
?>
  