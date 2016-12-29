<html>
<head>
<!-- css -->
	<link href="sec.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php	
	$con = mysql_connect('localhost','root','0418162');
	if (!$con) {
		die("Cannot establish a connection");
	}
	$db_selected = mysql_select_db("hw4",$con);
	// get data
	$form_chosen = $_GET['form_chosen'];
	$forms = explode(",", $form_chosen);
	// split data and get the list of recommended forms
	$i = 0;
	$j = 0;
	foreach ($forms as $form) {
		$text[$i] = "";
		$form = trim($form);
		$formnames[$i] = $form;
		$sql = 'select distinct a.Name from Items as a, Items as b where a.OrderID=b.OrderID and b.Name="'.$form.'" and a.Name!="'.$form.'"';
		$res = mysql_query($sql);
		while ($row = mysql_fetch_assoc($res)) {
			$names[$j] = $row['Name'];
			$j++;
		}
		$i++;
	}
	// delete duplicates and exclude existing selected
	if (!isset($names[0])) {
		echo "No Recommendation";
	}
	else {
		$names_unique = array_unique($names);
		foreach ($names_unique as $key => $name) {
			if (in_array($name, $formnames)) {
				unset($names_unique[$key]);
			}
		}
		// combine to print out text
		$prints = "";
		foreach ($names_unique as $name) {
			if ($prints=="") {
				$prints = $name;
			}
			else $prints = $prints.", ".$name;
		}
		echo $prints;
	}

?>
</body>
</html>