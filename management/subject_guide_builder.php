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
* Get subject list
*/
$query = "SELECT generalSubjectID, shortName
			FROM GeneralSubject
			ORDER BY shortName";
$result = mysqli_query($link, $query) or die(_("Bad Query Failure"));

?>
<script type='text/javascript'>
	window.onload = function() {
		sguide();
	}

	function sguide() {
		var e = document.getElementById('subject');
		var subject = e.options[e.selectedIndex].value;

		var resArray = "";
		var comma = 0;
		var isArray = 0;
		if (document.getElementById('COLL').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			resArray += "'4'";
			comma = 1;
			isArray = 1;
		}
		if (document.getElementById('DATAB').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			if (comma == 1) {
				resArray += ", ";
			}
			resArray += "'5'";
			comma = 1;
			isArray = 1;
		}
		if (document.getElementById('EBOOK').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			if (comma == 1) {
				resArray += ", ";
			}
			resArray += "'2'";
			comma = 1;
			isArray = 1;
		}
		if (document.getElementById('FREE').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			if (comma == 1) {
				resArray += ", ";
			}
			resArray += "'9'";
			comma = 1;
			isArray = 1;
		}
		if (document.getElementById('JOURN').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			if (comma == 1) {
				resArray += ", ";
			}
			resArray += "'3'";
			comma = 1;
			isArray = 1;
		}
		if (document.getElementById('OPACC').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			if (comma == 1) {
				resArray += ", ";
			}
			resArray += "'8'";
			comma = 1;
			isArray = 1;
		}
		if (document.getElementById('PCA').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			if (comma == 1) {
				resArray += ", ";
			}
			resArray += "'PCA'";
			comma = 1;
			isArray = 1;
		}
		if (document.getElementById('TOOLS').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			if (comma == 1) {
				resArray += ", ";
			}
			resArray += "'12'";
			comma = 1;
			isArray = 1;
		}
		if (document.getElementById('VIDEO').checked == true) {
			if (isArray == 0) {
				resArray += ", array(";
			}
			if (comma == 1) {
				resArray += ", ";
			}
			resArray += "'11'";
			comma = 1;
			isArray = 1;
		}
		if (isArray == 1) {
			resArray += ")";
		}

		if (document.getElementById('urlType1').checked == true) {
			resArray += ", 'adv'";
		} else if (document.getElementById('urlType2').checked == true) {
			resArray += ", 'bas'";
		}

		if (document.getElementById('tutorial1').checked == true) {
			resArray += ", 'tutorial'";
		} else if (document.getElementById('tutorial2').checked == true) {
			resArray += ", 'not'";
		}

		if (document.getElementById('graphic1').checked == true) {
			resArray += ", 'gon'";
		} else if (document.getElementById('graphic2').checked == true) {
			resArray += ", 'gof'";
		}

		if (document.getElementById('float1').checked == true) {
			resArray += ", 'flo'";
		} else if (document.getElementById('float2').checked == true) {
			resArray += ", 'und'";
		}

		if (document.getElementById('ezProxy1').checked == true) {
			resArray += "";
		} else if (document.getElementById('ezProxy2').checked == true) {
			resArray += ", 'poff'";
		}

		if (document.getElementById('newGraphic1').checked == true) {
			resArray += "";
		} else if (document.getElementById('newGraphic2').checked == true) {
			resArray += ", 'new_graphic'";
		}

		if (document.getElementById('trialGraphic1').checked == true) {
			resArray += "";
		} else if (document.getElementById('trialGraphic2').checked == true) {
			resArray += ", 'trial_graphic'";
		}

		if (document.getElementById('openStyle1').checked == true) {
			resArray += "); \?\>";
		} else if (document.getElementById('openStyle2').checked == true) {
			resArray += ", 'window'); \?\>";
		} else if (document.getElementById('openStyle3').checked == true) {
			resArray += ", 'none'); \?\>";
		}		

		document.getElementById('link').value = "\<\?php echo print_subject\(\'" + subject + "\'" + resArray;
	}
</script>

<h3>Subject Guide Builder</h3>
<br /><br />

<form onchange='sguide()'>
Select a Subject: 
<select id='subject'>
	<?php
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<option value='".$row['generalSubjectID']."'>".$row['shortName']."</option>";
	}
	?>
</select>
<br /><br />

Resource Type:<br />
<table style='margin-left: 100px;'>
	<tr>
		<td>
			<input type='checkbox' id='JOURN'>Single Journals</input> 
		</td>
		<td>
			<input type='checkbox' id='EBOOK'>eBooks</input> 
		</td>
	</tr>
	<tr>
		<td>
			<input type='checkbox' id='DATAB' checked>Database</input>
		</td>
		<td>
			<input type='checkbox' id='TOOLS'>Tools</input> 
		</td>
	</tr>
	<tr>
		<td>
			<input type='checkbox' id='FREE'>Free Websites</input> 
		</td>
		<td>
			<input type='checkbox' id='OPACC'>Open Access</input>
		</td>
	</tr>
	<tr>
		<td>
			<input type='checkbox' id='VIDEO'>Videos</input> 
		</td>
		<td>
			<input type='checkbox' id='PCA'>Post Cancellation Access (PCA)</input> 
		</td>
	</tr>
	<tr>
		<td>
			<input type='checkbox' id='COLL'>Journal from Collection</input> 
		</td>
	</tr>
</table>
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

Description float or underneath?:<br />
<input type='radio' name='float' id='float1' checked>Float</input>
<input type='radio' name='float' id='float2'>Underneath</input>
<br /><br />

EZProxy:<br />
<input type='radio' name='ezProxy' id='ezProxy1' checked>Enabled</input>
<input type='radio' name='ezProxy' id='ezProxy2'>Disabled</input>
<br /><br />

New Graphic:<br />
<input type='radio' name='newGraphic' id='newGraphic1' checked>Enabled</input>
<input type='radio' name='newGraphic' id='newGraphic2'>Disabled</input>
<br /><br />

Trial Graphic:<br />
<input type='radio' name='trialGraphic' id='trialGraphic1' checked>Enabled</input>
<input type='radio' name='trialGraphic' id='trialGraphic2'>Disabled</input>
<br /><br />

Open Style:<br />
<input type='radio' name='openStyle' id='openStyle1' checked>New Tab</input>
<input type='radio' name='openStyle' id='openStyle2'>New Window</input>
<input type='radio' name='openStyle' id='openStyle3'>Same Window</input>
<br /><br /><br /><br />

Link:
<textarea id='link' rows='4' cols= '100'>
	
</textarea>

<br /><br />

<h4 style="text-align: left;">Instructions:</h4>

<ol style="text-align: left;">
	<li>
		Select a subject for which to make a link
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

