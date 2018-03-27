<?php

/**
* Includes
*/
include_once 'directory.php';
$pageTitle=_('Link Builder');
include 'templates/header.php';

/**
* Database Configuration
*/
$config = new Configuration;
$host = $config->database->host;
$username = $config->database->username;
$password = $config->database->password;
$license_databaseName = $config->database->name;
$resource_databaseName = $config->settings->resourcesDatabaseName;
$link = mysqli_connect($host, $username, $password) or die(_("Could not connect to host."));
mysqli_select_db($link, $license_databaseName) or die(_("Could not find License database."));
mysqli_select_db($link, $resource_databaseName) or die(_("Could not find Resource database."));

/**
* Get resource list where status = in progress
*/
$query = "SELECT resourceID, titleText
			FROM resource
			WHERE statusID = 1
			ORDER BY titleText";
$result = mysqli_query($link, $query) or die(_("Bad Query Failure"));

?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type='text/javascript'>
	/**
	* Run function on page load
	*/
	window.onload = function() {
		sguide();
	}

	/**
	* Activate select2  on page load
	*/
	$(document).ready(function() {
	    $('.js-example-basic-multiple').select2();
	});

	/**
	* Updates textarea with with current form values
	*/
	function sguide() {
		//var e = document.getElementById('subject');
		//var subject = e.options[e.selectedIndex].value;
		var subject = $('#subject').select2('val');
		var resArray = "";
		var testArray = "";

		/**
		* Adding commas in between each select2 value
		*/
		for (var i=0; i<subject.length;i++) {
			testArray += "\'" + subject[i] + "\'";
			if (i!=subject.length-1) {
				testArray += ", ";	
			}
		}

		/**
		* Adding values to string based on form values
		*/
		if (document.getElementById('urlType1').checked == true) {
			resArray += ", 'advanced'";
		} else if (document.getElementById('urlType2').checked == true) {
			resArray += ", 'basic'";
		}

		if (document.getElementById('graphic1').checked == true) {
			resArray += ", 'graphic'";
		} else if (document.getElementById('graphic2').checked == true) {
			resArray += "";
		}

		if (document.getElementById('float1').checked == true) {
			resArray += ", 'float_description'";
		} else if (document.getElementById('float2').checked == true) {
			resArray += ", 'print_description'";
		} else if (document.getElementById('float3').checked == true) {
			resArray += ", 'no_description'";
		}

		if (document.getElementById('tutorial1').checked == true) {
			resArray += ", 'tutorial'";
		} else if (document.getElementById('tutorial2').checked == true) {
			resArray += "";
		}

		if (document.getElementById('listBreak1').checked == true) {
			resArray += ", 'in-li'";
		} else if (document.getElementById('listBreak2').checked == true) {
			resArray += ", 'no-li'";
		}		

		if (document.getElementById('openStyle1').checked == true) {
			resArray += "";
		} else if (document.getElementById('openStyle2').checked == true) {
			resArray += ", 'window'";
		} else if (document.getElementById('openStyle3').checked == true) {
			resArray += ", 'none'";
		}

		if (document.getElementById('newGraphic1').checked == true) {
			resArray += ", 'new_graphic'";
		} 

		if (document.getElementById('trial1').checked == true) {
			resArray += ", 'trial_graphic'";
		}

		if (document.getElementById('ezProxy1').checked == true) {
			resArray += "); \?\>";
		} else if (document.getElementById('ezProxy2').checked == true) {
			resArray += ", 'no_proxy'); \?\>";
		}

		/**
		* Updates textarea
		*/
		document.getElementById('link').value = '\<\?php echo print_resource\(\"' + testArray + '\"' + resArray;
	}
</script>
</head>
<body>
<h3>Link Builder</h3>
<br /><br />

<form onchange='sguide()'>
Select a Resource: 
<select class="js-example-basic-multiple" name="states[]" multiple="multiple" id='subject'>
	<?php
	/**
	* Populate select2 field with resources in DB
	*/
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<option value='".$row['resourceID']."'>".$row['titleText']."</option>";
	}
	?>
</select>
<br /><br />

URL Type:<br />
<input type='radio' name='urlType' id='urlType2' checked>Basic</input>
<input type='radio' name='urlType' id='urlType1'>Advanced</input>
<br /><br />

Tutorial:<br />
<input type='radio' name='tutorial' id='tutorial1' checked>Enabled</input>
<input type='radio' name='tutorial' id='tutorial2'>Disabled</input>
<br /><br />

Graphic:<br />
<input type='radio' name='graphic' id='graphic1' checked>Enabled</input>
<input type='radio' name='graphic' id='graphic2'>Disabled</input>
<br /><br />

Description type:<br />
<input type='radio' name='float' id='float1' checked>Float</input>
<input type='radio' name='float' id='float2'>Underneath</input>
<input type='radio' name='float' id='float3'>None</input>
<br /><br />

Inside list?:<br />
<input type='radio' name='lineBreak' id='listBreak1' checked>Enabled</input>
<input type='radio' name='lineBreak' id='listBreak2'>Disabled</input>
<br /><br />

Open Style:<br />
<input type='radio' name='openStyle' id='openStyle1' checked>New Tab</input>
<input type='radio' name='openStyle' id='openStyle2'>New Window</input>
<input type='radio' name='openStyle' id='openStyle3'>Same Window</input>
<br /><br />

EZProxy:<br />
<input type='radio' name='ezProxy' id='ezProxy1' checked>Enabled</input>
<input type='radio' name='ezProxy' id='ezProxy2'>Disabled</input>
<br /><br />

<!-- if this is checked, it looks for the field in the DB that says when it stops being new. If it is before that date, then the new grapic shows up -->
New Graphic:<br />
<input type='radio' name='newGraphic' id='newGraphic1' checked>Yes</input>
<input type='radio' name='newGraphic' id='newGraphic2'>No</input>
<br /><br />

<!-- if this is checked, it looks for the field in the DB that determines if it is a trial or not then it puts the graphic on if it is -->
Trial Graphic:<br />
<input type='radio' name='trial' id='trial1' checked>Yes</input>
<input type='radio' name='trial' id='trial2'>No</input>
<br /><br /><br /><br />

Link:
<textarea id='link' rows='4' cols= '100'>
	
</textarea>

<br /><br />

<h4 style="text-align: left;">Instructions:</h4>

<ol style="text-align: left;">
	<li>
		Select resource(s) for which to make a link
	</li>
	<li>
		Select the type of resource(s) to include in this resource set
		<ul>
			<li>
				Multiple resource types are allowed
			</li>
		</ul>
	</li>
	<li>
		Select the type of URLs to be used
	</li>
	<li>
		Indicate if there is a tutorial available, and if so, what type of tutorial
	</li>
	<li>
		Select whether or not you want a graphic for this set
	</li>
	<li>
		Select if you want a floating description or a description underneath your link for this set
	</li>
	<li>
		Copy/Paste the link into your website
	</li>
</ol>

</form>
</body>
</html>