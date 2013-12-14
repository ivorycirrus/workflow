<?php
$wiki_url = 'http://zvezda.iptime.org:8080/wiki/index.php/';

$url=$wiki_url.$_GET["data"];
$text=file_get_contents($url);

$temp=@explode('[!workflow!]',$text);
$temp=@explode('[/!workflow!]',$temp[1]);

$text=$temp[0];
$text=str_replace('&quot;','"',$text);
$text=preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '',$text);

$script = json_decode($text);
$node = $script->{'node'};
$connection = $script->{'connection'};

//echo("NODE:".json_encode($flowscript->{'node'}));

$tooltip_text="";

$data = '<!doctype html>
<html>
	<head>
		<meta charset="utf-8"> 
		<link rel="stylesheet" href="lib/jquery-ui.css">
		<style type="text/css">
/** DISABLE TEXT SELECTION (SET ON BODY WHEN DRAGGING IS OCCURRING) **/
._jsPlumb_drag_select * {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: -moz-none;
    -ms-user-select: none;
    user-select: none
}

/** OPEN SANS FONT **/
@font-face {
  font-family: "Open Sans";
  font-style: normal;
  font-weight: 400;
 	src:local("Open Sans"), 
 		local("OpenSans"),
 		url("fonts/OpenSans-Regular.ttf") format("truetype"),
 		url("fonts/OpenSans.woff") format("woff"); 		
}

/** PAGE STRUCTURE **/

/** FB **/
#like {
    position: fixed;
    width: 50px;
    height: 70px;
    border: 0;
    right: 13px;
    bottom: 8px;
}

body {
    padding:0;
    margin:0;
    background-color:white;    
    font-family:"Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;    
    background-color:#eaedef;
   
}

#headerWrapper {
	width:100%;
	background-color:black;
	position:fixed;
	top:0;left:0;
  z-index:10000;
	height:44px;
  padding:0;
  opacity:0.8;
}

#header {
	margin-top:0;
  height:44px;
  font-size:13px;
	margin-left:auto;
	margin-right:auto;    
  width:950px;
  background-image:url(logo_bw_44h.jpg);
  background-repeat:no-repeat;    
}

/*
 #main {  
  margin-top:44px;
  position: relative;
  font-size: 80%;    
}*/

#sidebar {            
  width: 420px;
  font-size: 12px;
  position: fixed;
  right: 20px;
  top: 90px;    
}

#explanation {
    text-align: center;
    padding: 10px;        
}


/* demo elements */

a, a:visited {
    text-decoration:none;
    color:#5c96bc;        
    border-radius:0.2em;
    -webkit-transition: color 0.15s ease-in;
    -moz-transition: color 0.15s ease-in;
    -o-transition: color 0.15s ease-in;
    transition: color 0.15s ease-in;
}

a:hover {
    color:#1b911b;
}

.menu, #render, #explanation {   
	background-color:#fff;	    
}

.menu {    
  height: 15px;
	float:right;     
  padding-top:1em;
  padding-bottom:0.4em;   
  background-color: transparent;
	margin-right:30px;
  font-size:12px;
}

.menu a, #render a {
    color:white;
}

.menu a {
  margin-right: 19px;
}

.menu a:hover {
    color:orange;
}

.menu a:active {
    color:#5c96bc;
}

#render a:hover {
    color:orange;
}

#render {
	padding-top:2px;
    margin-left:auto;
	margin-right:auto;
    z-index:5000;
	margin-top:0px;  
    text-align: center;
    background-color:white;
    font-size:11.5px;
    background-color: #5c96bc;
    color:white;
}


#render ul {
    padding-left:1em;
}
#render ul li {
    list-style-type:none;
}
#render h5 {
    display:inline;
}

.otherLibraries {
    display:inline;
}

#render a {
    margin-right:10px;
}

.selected {
	color:orange !important;
}

.window, .label { 
    
    text-align:center;
    z-index:24;
	cursor:pointer;
	box-shadow: 2px 2px 19px #aaa;
   -o-box-shadow: 2px 2px 19px #aaa;
   -webkit-box-shadow: 2px 2px 19px #aaa;
   -moz-box-shadow: 2px 2px 19px #aaa;
    
}
path, ._jsPlumb_endpoint { cursor:pointer; }

.cmd { padding:0.5em; width:60px;}
.cmd:hover { 
  border:2px solid #5c96bc;
  background-color:#89bcde;
  color:white;
}
.cmd:active {
  border:2px solid orange;
  color:orange;
}

.label {
  font-size:13px; 
  padding:8px;
  padding:8px;
}

.component { 
  border:1px solid #346789; 
  border-radius:0.5em;        
  opacity:0.8; 
  filter:alpha(opacity=80);
  background-color:white;
  color:black;
  padding:0.5em;   
  font-size:0.8em;
}

.component:hover {
    border:1px solid #123456;
    box-shadow: 2px 2px 19px #444;
   -o-box-shadow: 2px 2px 19px #444;
   -webkit-box-shadow: 2px 2px 19px #444;
   -moz-box-shadow: 2px 2px 19px #fff;
    opacity:0.9;
    filter:alpha(opacity=90);
}

.window {
    background-color:white;
    border:1px solid #346789;
    box-shadow: 2px 2px 19px #e0e0e0;
    -o-box-shadow: 2px 2px 19px #e0e0e0;
    -webkit-box-shadow: 2px 2px 19px #e0e0e0;
    -moz-box-shadow: 2px 2px 19px #e0e0e0;
    -moz-border-radius:0.5em;
    border-radius:0.5em;        
    width:5em; height:5em;        
    position:absolute;    
    color:black;
    padding:0.5em;
    width:8em; 
    height:8em;
    line-height: 8em; 
    font-size:0.8em;
    -webkit-transition: -webkit-box-shadow 0.15s ease-in;
    -moz-transition: -moz-box-shadow 0.15s ease-in;
    -o-transition: -o-box-shadow 0.15s ease-in;
    transition: box-shadow 0.15s ease-in;
}

.window:hover {
    border:1px solid #123456;
    box-shadow: 2px 2px 19px #444;
   -o-box-shadow: 2px 2px 19px #444;
   -webkit-box-shadow: 2px 2px 19px #444;
   -moz-box-shadow: 2px 2px 19px #fff;
    opacity:0.9;
    filter:alpha(opacity=90);
}

.window a {
    font-family:helvetica;
}

/** Z-INDEX **/

._jsPlumb_connector { z-index:18; }
._jsPlumb_endpoint { z-index:19; }
._jsPlumb_overlay { z-index:20; }
._jsPlumb_connector._jsPlumb_hover {
    z-index:21 !important;
}
._jsPlumb_endpoint._jsPlumb_hover {
    z-index:22 !important;
}
._jsPlumb_overlay._jsPlumb_hover {
    z-index:23 !important;
}

#demo {
	margin-top:5em;
}

.w { 
	width:5em;
	padding:1em;
	position:absolute;
	border: 1px solid black;
	z-index:4;
	border-radius:1em;
	border:1px solid #2e6f9a;
	box-shadow: 2px 2px 19px #e0e0e0;
	-o-box-shadow: 2px 2px 19px #e0e0e0;
	-webkit-box-shadow: 2px 2px 19px #e0e0e0;
	-moz-box-shadow: 2px 2px 19px #e0e0e0;
	-moz-border-radius:0.5em;
	border-radius:0.5em;
	opacity:0.8;
	filter:alpha(opacity=80);
	cursor:move;
	background-color:white;
	font-size:11px;
	-webkit-transition:background-color 0.25s ease-in;
	-moz-transition:background-color 0.25s ease-in;
	transition:background-color 0.25s ease-in;	
}

.w:hover {
	background-color: #FBB;
	color:black;
}

.aLabel {
	-webkit-transition:background-color 0.25s ease-in;
	-moz-transition:background-color 0.25s ease-in;
	transition:background-color 0.25s ease-in;
}

.aLabel._jsPlumb_hover,.bLabel._jsPlumb_hover,.cLabel._jsPlumb_hover, ._jsPlumb_source_hover, ._jsPlumb_target_hover {
	background-color:#FBB;
	color:black;
}

.aLabel {
	background-color:white;
	opacity:0.8;
	padding:0.3em;				
	border-radius:0.5em;
	border:1px solid #346789;
	cursor:pointer;
	font-family: "맑은 고딕";
	font-size: 0.5em;
	color: violet;
}

.bLabel {
	background-color:white;
	opacity:0.8;
	padding:0.3em;				
	border-radius:0.5em;
	border:1px solid #346789;
	cursor:pointer;
	font-family: "맑은 고딕";
	font-size: 0.5em;
	color: lime;
}

.cLabel {
	background-color:white;
	opacity:0.8;
	padding:0.3em;				
	border-radius:0.5em;
	border:1px solid #346789;
	cursor:pointer;
	font-family: "맑은 고딕";
	font-size: 0.5em;
	color: deeppink;
}

.ep {
	position:absolute;
	bottom: 37%;
	right: 5px;
	width:1em;
	height:1em;
	background-color:orange;
	cursor:pointer;
	box-shadow: 0px 0px 2px black;
	-webkit-transition:-webkit-box-shadow 0.25s ease-in;
	-moz-transition:-moz-box-shadow 0.25s ease-in;
	transition:box-shadow 0.25s ease-in;
}

.ep:hover {
	box-shadow: 0px 0px 6px black;
}

._jsPlumb_endpoint {
	z-index:3;
}

.dragHover { border:2px solid orange; }

path { cursor:pointer; }

.serverfarm_title{
	width:80%;
	text-align:center;	
	border:1px #666 solid;
	padding-top:3px;
	padding-bottom:3px;
	border-radius: 3px;
	background-color: #4CC;
}

table.tb_tooltip, table.tb_tooltip th, table.tb_tooltip td{border:1px #FFF solid;border-spacing: 0px;border-collapse: collapse;}

</style>

	</head>
	<body data-demo-id="statemachine" data-library="jquery">

        <div id="main">';

for($i=0; $i<sizeof($node); ++$i)
{
	$title='';
	if(isset($node[$i]->tooltip)){    	
		$tmp_url=$wiki_url.$node[$i]->tooltip;
		$tmp_text=file_get_contents($tmp_url);

		$temp=@explode('[!workflow!]',$tmp_text);
		$temp=@explode('[/!workflow!]',$temp[1]);

		$tmp_text=$temp[0];
		$tmp_text=str_replace('&quot;','"',$tmp_text);
		$tmp_text=str_replace('&lt;','<',$tmp_text);
		$tmp_text=str_replace('&gt;','>',$tmp_text);

		$tmp_text = '$("#'.$node[$i]->id.'").tooltip({content:"'.$tmp_text.'"});';
		$tmp_text = str_replace("\n","",$tmp_text); 
		$tmp_text = str_replace("\r","",$tmp_text); 
		$tooltip_text = $tooltip_text.$tmp_text;
		$title=' title="title" ';
    }

    $data = $data.'<div class="w" id="'.$node[$i]->id
    	.'" style="left:'.$node[$i]->position_left.';top:'.$node[$i]->position_top.';" '.$title.'>';
    if(isset($node[$i]->link)&&$node[$i]->link){
    	$data = $data.'<a href="'.$node[$i]->link.'" target="_blank"><img src="images/'.$node[$i]->type.'.png"></a>';
    }else{
    	$data = $data.'<img src="images/'.$node[$i]->type.'.png">';
    }
    $data = $data.'<br/>'.$node[$i]->label
    	/*.'<div class="ep"></div>'*/
    	.'</div>';	
   
}
//$data = $data.'<div class="w" id="switch1" style="left:5em;top:6em;"><img src="images/switch.png"><br/>SWITCH1<div class="ep"></div></div>';

$data = $data.'
		</div>

		<div id="dialog-confirm" title="Delete connections." style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This connection will be removed.<br/>Are you sure?</p>
</div>
		<!--
		<div id="sidebar">
			<div id="explanation">
				<h4>SAMPLE</h4>
				<p>Sample map</p>
			</div>	    			
		</div>
		-->
	
        <!-- DEP -->
	    <script src="lib/jquery-1.9.0.js"></script>
		<script src="lib/jquery-ui-1.9.2-min.js"></script>
        <script src="lib/jquery.ui.touch-punch.min.js"></script>
		<!-- /DEP -->
				
		<!-- JS -->
		<!-- support lib for bezier stuff -->
		<script src="lib/jsBezier-0.6.js"></script>        
		<!-- jsplumb geom functions -->   
		<script src="lib/jsplumb-geom-0.1.js"></script>
		<!-- jsplumb util -->
		<script src="lib/util.js"></script>
        <!-- base DOM adapter -->
		<script src="lib/dom-adapter.js"></script>        
		<!-- main jsplumb engine -->
		<script src="lib/jsPlumb.js"></script>
        <!-- endpoint -->
		<script src="lib/endpoint.js"></script>                
        <!-- connection -->
		<script src="lib/connection.js"></script>
        <!-- anchors -->
		<script src="lib/anchors.js"></script>        
		<!-- connectors, endpoint and overlays  -->
		<script src="lib/defaults.js"></script>
		<!-- bezier connectors -->
		<script src="lib/connectors-bezier.js"></script>
		<!-- state machine connectors -->
		<script src="lib/connectors-statemachine.js"></script>
        <!-- flowchart connectors -->
		<script src="lib/connectors-flowchart.js"></script>
		<!-- SVG renderer -->
		<script src="lib/renderers-svg.js"></script>
		<!-- canvas renderer -->
		<script src="lib/renderers-canvas.js"></script>
		<!-- vml renderer -->
		<script src="lib/renderers-vml.js"></script>
        
        <!-- jquery jsPlumb adapter -->
		<script src="lib/jquery.jsPlumb.js"></script>
		<!-- /JS -->

		<!--  program code -->
        <script type="text/javascript">
        ;(function() {

	// helper method to generate a color from a cycle of colors.
	/*var curColourIndex = 1, maxColourIndex = 24, nextColour = function() {
		var R,G,B;
		R = parseInt(128+Math.sin((curColourIndex*3+0)*1.3)*128);
		G = parseInt(128+Math.sin((curColourIndex*3+1)*1.3)*128);
		B = parseInt(128+Math.sin((curColourIndex*3+2)*1.3)*128);
		curColourIndex = curColourIndex + 1;
		if (curColourIndex > maxColourIndex) curColourIndex = 1;
		return "rgb(" + R + "," + G + "," + B + ")";
	 };	*/
		
	window.jsPlumbDemo = { 
	
		init :function() {
						
			// setup some defaults for jsPlumb.	
			jsPlumb.importDefaults({
				Endpoint : ["Dot", {radius:2}],
				HoverPaintStyle : {strokeStyle:"#F77", lineWidth:2 },
				ConnectionOverlays : [
					[ "Arrow", { 
						location:1,
						id:"arrow",
	                    length:14,
	                    foldback:0.8
					} ]
				]
			});
			
			var windows = $(".w");
'
/*
            // initialise draggable elements.  
			jsPlumb.draggable(windows);

            // bind a click listener to each connection; the connection is deleted. you could of course
			// just do this: jsPlumb.bind("click", jsPlumb.detach), but I wanted to make it clear what was
			// happening.
			

			jsPlumb.bind("contextmenu", function(c) {
				jsPlumb.detach(c); 
			});	

			jsPlumb.bind("click", function(c) {
				$( "#dialog-confirm" ).dialog({
			      resizable: false,
			      width:400,
			      height:250,
			      modal: true,
			      buttons: {
			        "Remove Connection": function() {
			          jsPlumb.detach(c); 
			          $( this ).dialog( "close" );
			        },
			        Cancel: function() {
			          $( this ).dialog( "close" );
			        }
			      }
			    });
			});
*/
.'			
			// make each ".ep" div a source and give it some parameters to work with.  here we tell it
			// to use a Continuous anchor and the StateMachine connectors, and also we give it the
			// connector paint style.  note that in this demo the strokeStyle is dynamically generated,
			// which prevents us from just setting a jsPlumb.Defaults.PaintStyle.  but that is what i
			// would recommend you do. Note also here that we use the "filter" option to tell jsPlumb
			// which parts of the element should actually respond to a drag start.
			jsPlumb.makeSource(windows, {
				filter:".ep",				// only supported by jquery
				anchor:"Continuous",
				//connector:[ "StateMachine", { curviness:20 } ],
				connector:[ "Flowchart", { stub:[10, 20], gap:5, cornerRadius:5, alwaysRespectStubs:true } ],
				connectorStyle:{ strokeStyle:"#5c96bc", lineWidth:2, outlineColor:"transparent", outlineWidth:4 },
				maxConnections:5,
				onMaxConnections:function(info, e) {
					alert("Maximum connections (" + info.maxConnections + ") reached");
				}
			});			

			// initialise all ".w" elements as connection targets.
            jsPlumb.makeTarget(windows, {
				dropOptions:{ hoverClass:"dragHover" },
				anchor:"Continuous"				
			});
			';

for($j = 0 ; $j < sizeof($connection); ++$j){	
	$data = $data.'jsPlumb.connect({ source:"'.$connection[$j]->source.'", target:"'.$connection[$j]->target.'"';
	if(isset($connection[$j]->label)){
		$data = $data.' , overlays: [[ "Label", { label:"'.$connection[$j]->label.'", cssClass:"'.$connection[$j]->color.'" }]]';
	}
	$data = $data.'});
			';
}

$data = $data.$tooltip_text
		.'}
	};
})();

/*
 *  This file contains the JS that handles the first init of each jQuery demonstration, and also switching
 *  between render modes.
 */
jsPlumb.bind("ready", function() {
	jsPlumbDemo.init(); 
});

 if (document.addEventListener) {
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
            return;
        }, false);
    } else {
        document.attachEvent("oncontextmenu", function() {            
            window.event.returnValue = false;
            return;
        });
    }


        </script>
		
	</body>
</html>
';

echo $data;

?>
