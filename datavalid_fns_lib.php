<?php
/*  File name: data_valid_fns_lib.php
	File description: data validation functions library
	File author: Lens Kamdem
	File update date: 10/10/2015 at 18:57
*/

function datavalid_turn_to_array($result)
{
/*  It gets the rows given and put them in an array
	Input: rows queried 'query object'; return: array 'array'
*/
  $result_array = array();
  for ($i = 0; $row = $result->fetch_array();$i++)
  {
    $result_array[$i] = $row;
  }
  return $result_array;
}
function datavalid_form_filled($form_variables)
{
/*  It checks if the form was completely filled
	Input: form entry values 'post variable'; return: true or false (if filled or not)
*/
  foreach ($form_varaibles as $key => $value)
  {
    if ((!isset($key)) or ($value == ''))
	{
	  return false;
	}
  }
  return true;
}
function datavalid_format_time($time)
{
/*  It gets a time value in the hour:minutes format
	Input: time value "integer"; return: time "string"
*/
  /* cast type as integer */
  if (($time/60) > 1)
  {
   $hours = $time/60;
	$hours = (int) $hours;
	$min = $time%60;
	$time = $hours." h : ".$min." m";
	if ($min = 0)
	{
	  $time = $hours." H";
	}
  }
  else
  {
    $hours = "";
    $min = $time;
	$time = $min." m";
  }
  return $time;
}
function datavalid_add_query($variable)
{
	foreach($variable as $key => $value)
	{
		$_SESSION[$key] = $value;
	}
}
function datavalid_clean_data($data)
{
/*  It clean and secured entered data ie $data
	 Input: data "string"; return: clean data "string"
*/
	$data = trim($data);
   $data = htmlspecialchars($data);
   if (!get_magic_quotes_gpc())
   {
      $data = addslashes($data);
	}
	return $data;
}
function datavalid_get_hour_n_min($time)
{
/*  It gets the number of hours and minutes from a time value
	 Input: time value "integer"; return: time "string"
*/
  /* cast type as integer */
  if (($time/60) > 1)
  {
   $hours = $time/60;
	$hours = (int) $hours;
	$min = $time%60;
  }
  else
  {
    $hours = 0;
    $min = $time%60;
  }
  $time = array($hours,$min);
  return $time;
}
?>