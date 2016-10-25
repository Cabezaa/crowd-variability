<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
	<?php
	include '_headincludes.php';
	?>
	<title>Design</title>

	<script src="./js/csstheme.js"></script>
	<script src="./js/backbone_views.js"></script>
	<script src="./js/GUIState.js"></script>
	<script src="./js/gui.js"></script>
	<script src="./js/interface.js"></script>
	
	<?php if (array_key_exists('prueba', $_GET) && $_GET['prueba'] == 1){ ?>
	    <script src="./js/prueba.js"></script>
	<?php } ?>

        <link rel="stylesheet" href="./css/interfaz.css" />
    </head>

    <body>
	<div data-role="page" id="diagram-page">
	    <div data-role="panel" data-display="overlay" data-position="left" id="tools-panel" class="comandos ui-corner-all" id="comandos">
		<div style="text-align: right">
		    <a href="#comandos" data-rel="close" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all ui-btn-inline ui-mini">Close</a>
		</div>
		<div id="crearclase"></div>
	    </div><!-- /panel -->

	    <div data-role="header" class="wicom-header">
		<h1 class="crowd-header">c r o w d</h1>
		<div id="trafficlight"></div>
		<div data-role="navbar">
		    <ul>
			<li><a href="#tools-panel" class="ui-btn ui-icon-bars ui-btn-icon-left">Tools</a></li>
			<li><a href="#details-page" data-transition="slide" class="ui-btn ui-btn-icon-right ui-icon-forward">Details</a></li>
		    </ul>
		</div>
	    </div> <!-- /header -->

	    <!-- ---------------------------------------------------------------------- -->
	    
	    <div role="main" class="ui-content">
		<div id="errorwidget_placer"></div>
		<div id="container"></div>
	    	    
		
		<!-- ---------------------------------------------------------------------- -->
		<!-- Templates -->

		<!-- Tools Navbar -->
		<script type="text/template" id="template_errorwidget">
		    <div class="error-popup" data-dismissible="false"  data-role="popup">
			<div data-role="header" class="error-header">
			    <h1> Error: </h1>
			</div>
			<div data-role="main" class="ui-content error-content">
			    <dl>
				<dt>Status:</dt><dd>
				    <div id="errorstatus_text"></div>
				</dd>
				<dt>Server Answer:</dt><dd>
				    <pre>
					<div id="errormsg_text"></div>
				    </pre>
				</dd>
			    </dl>
			    <a data-rel="back" id="errorwidget_hide_btn"
			       class="ui-corner-all ui-btn ui-icon-back ui-btn-icon-left">Hide</a>
			</div>
		    </div>
		</script>
		
		<script type="text/template" id="template_tools_navbar">
		    <div data-role="navbar">
			<label>Translate</label>
			<select data-mini="true" data-inline="true" data-native-menu="false" id="format_select">
			    <option value="owllink" selected="true">OWLlink</option>
			    <option value="html">HTML</option>
			</select>
		    	<a class="ui-btn ui-icon-edit ui-btn-icon-left ui-corner-all" type="button" id="translate_button">Translate</a>
						
			<label>New Class</label>
			<input data-mini="true" placeholder="ClassName" type="text" id="crearclase_input"/>
			<a class="ui-btn ui-icon-plus ui-btn-icon-left ui-corner-all" type="button" id="crearclase_button">New</a>

			<label>Insert OWLlink data</label>
			<a class="ui-btn ui-icon-edit ui-btn-icon-left ui-corner-all" type="button" id="insertowllink_button">Insert OWLlink</a>
			<label>Import JSON</label>
			<a class="ui-btn ui-icon-edit ui-btn-icon-left ui-corner-all" type="button" id="importjson_open_dialog">Import JSON</a>
		    </div>
		</script>
		<!-- EditClass -->
		<script type="text/template" id="template_editclass">
		    <form>
			<input type="hidden" id="editclass_classid" name="classid" value="<%= classid %>" />
			<input data-mini="true" placeholder="ClassName" type="text" id="editclass_input"  />
			<div data-role="controlgroup" data-mini="true" data-type="horizontal">
			    <a class="ui-btn ui-corner-all ui-icon-check ui-btn-icon-notext" type="button" id="editclass_button">Accept</a>
			    <a class="ui-btn ui-corner-all ui-icon-back ui-btn-icon-notext" type="button" id="close_button">Close</a>
			</div>
		    </form>
		</script>
		<!-- ClassOptions -->
		<script type="text/template" id="template_classoptions">
		    <div class="classOptions" data-role="controlgroup" data-mini="true" data-type="vertical" style="visible:false, z-index:1, position:absolute" >
			<input type="hidden" id="cassoptions_classid" name="classid" value="<%= classid %>" />
			<a class="ui-btn ui-corner-all ui-icon-edit ui-btn-icon-notext" type="button" id="editclass_button">Edit</a>
			<a class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-notext" type="button" id="deleteclass_button">Delete</a>
		    </div>
		</script>
		<!-- RelationOptions -->
		<script type="text/template" id="template_relationoptions">
		    <div class="relationOptions" style="visible:false, z-index:1, position:absolute">
			<input type="hidden" id="relationoptions_classid"  name="classid"  value="<%= classid %>" />
			<div data-role="controlgroup" data-mini="true" data-type="horizontal">
			    <select data-mini="true" data-inline="true" data-native-menu="false" id="cardfrom">
				<option value="zeromany">0..*</option>
				<option value="onemany">1..*</option>
				<option value="zeroone">0..1</option>
				<option value="oneone">1..1</option>
			    </select>
			    <a class="ui-btn ui-corner-all ui-icon-arrow-r ui-btn-icon-notext" type="button" id="association_button">Association</a>
			    <select data-mini="true" data-inline="true" data-native-menu="false" id="cardto" >
				<option value="zeromany">0..*</option>
				<option value="onemany">1..*</option>
				<option value="zeroone">0..1</option>
				<option value="oneone">1..1</option>
			    </select>
			</div>

			<a class="ui-btn ui-corner-all ui-icon-arrow-u ui-btn-icon-notext" type="button" id="isa_button">Is A</a>
			<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
			    <input type="checkbox" name="chk-covering" id="chk-covering"/>
			    <label for="chk-covering">Covering</label>
			    <input type="checkbox" name="chk-disjoint" id="chk-disjoint" />
			    <label for="chk-disjoint">Disjoint</label>
			</fieldset>
		    </div>		    
		</script>
		<!-- TrafficLights -->
		<script type="text/template" id="template_trafficlight">
		    <a class="ui-btn ui-btn-right ui-corner-all" id="traffic_btn">
			<img id="traffic_img" src="imgs/h-traffic-light.svg" alt="Reasoner answer..."/>
		    </a>			
		</script>
		<!-- OWLlink Editor -->
		<script type="text/template" id="template_insertowllink">
		    <p>Use this for adding your own personal <a href="http://owllink.org/"> OWLlink</a> data.</p>
		    <p>Remember: this will be used when you check for satisfiability or send any diagram information to the server.</p>			    
		    <textarea cols="40" class="ui-body" id="insert_owllink_input"></textarea>
		    <div data-role="controlgroup" data-mini="true" data-type="horizontal">
			<a id="insert_owlclass" data-mini="true" class="ui-btn ui-corner-all">owl:Class</a>
		    </div>
		</script>
		
		<!-- Import JSON Dialog -->
		<!-- Import JSON template -->
		<script type="text/template" id="template_importjson">
		    <div data-role="popup" id="popupImport" data-theme="a" class="ui-corner-all">
			<form>
			    <h3>Paste the JSON string here</h3>
			    <textarea cols="40" class="ui-body" id="importjson_input"></textarea>
			    <a id="importjson_import" data-mini="true" class="ui-btn ui-corner-all">Import</a>
			</form>
		    </div>
		</script>
   		
		<div id="editclass"></div>
		<div id="classoptions"></div>
		<div id="relationoptions"></div>
		
 	    </div> <!-- /main ui-content -->

	    <!-- ---------------------------------------------------------------------- -->
	
	    <div data-role="footer">
		<address>
		    <a href="mailto:christian@Harmonia">Giménez, Christian</a>,
		    10 feb 2016
		</address>
		
	    </div><!-- /footer -->
	</div> <!-- /page -->

	<!-- ---------------------------------------------------------------------- -->
	<!-- Details page -->
	<div data-role="page" id="details-page">
	    <div data-role="header" class="wicom-header">
		<h1>Details</h1>
		<div data-role="navbar">
		    <ul>
			<li><a class="ui-btn ui-icon-back ui-btn-icon-left" href="#" data-rel="back">Back</a></li>
		    </ul>
		</div>
	    </div>

	    <div role="main" class="ui-content">
		<div id="details_panel">
		    <h1 id="details">Details</h1>
		    <div id="translation_details">
			<h3 class="ui-bar ui-bar-a ui-corner-all">Translation Output</h3>
			<div class="ui-body">
			    <div id="html-output"></div>
			    <textarea cols="10" id="owllink_source"></textarea>
		    	    <a class="ui-btn ui-icon-edit ui-btn-icon-left ui-corner-all" type="button" id="translate_button"
			    onclick="guiinst.translate_owllink()">Translate Again</a>
			</div>
		    </div>
		    <div class="insert_owllink_details" data-role="collapsible"  data-collapsed="true"
		    	 data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
			<h2>Insert OWLlink</h2>
			<div id="owllink_placer"></div>
		    </div>
		    <div class="reasoner_details" data-role="collapsible" data-collapsed="true"
			 data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
			<h2>Reasoner Details</h2>
			<h3 class="ui-bar ui-bar-a ui-corner-all">Reasoner Input</h3>
			<textarea cols="40" class="ui-body" id="reasoner_input"></textarea>
			<h3 class="ui-bar ui-bar-a ui-corner-all">Reasoner Output</h3>
			<textarea cols="40" class="ui-body" id="reasoner_output"></textarea>			
		    </div>
		</div>
	    </div>
	    
	    <div data-role="footer"></div>
	</div> <!-- /page -->
    </body>
</html>
