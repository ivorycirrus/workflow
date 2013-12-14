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
				HoverPaintStyle : {strokeStyle:"#1e8151", lineWidth:2 },
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

            // initialise draggable elements.  
			jsPlumb.draggable(windows);

            // bind a click listener to each connection; the connection is deleted. you could of course
			// just do this: jsPlumb.bind("click", jsPlumb.detach), but I wanted to make it clear what was
			// happening.
			jsPlumb.bind("click", function(c) { 
				jsPlumb.detach(c); 
			});			
				
			// make each ".ep" div a source and give it some parameters to work with.  here we tell it
			// to use a Continuous anchor and the StateMachine connectors, and also we give it the
			// connector's paint style.  note that in this demo the strokeStyle is dynamically generated,
			// which prevents us from just setting a jsPlumb.Defaults.PaintStyle.  but that is what i
			// would recommend you do. Note also here that we use the 'filter' option to tell jsPlumb
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

			// initialise all '.w' elements as connection targets.
            jsPlumb.makeTarget(windows, {
				dropOptions:{ hoverClass:"dragHover" },
				anchor:"Continuous"				
			});
			
			// and finally, make a couple of connections
			jsPlumb.connect({ source:"server1", target:"switch1" , overlays: [[ "Label", { label:"서버커넥트", id:"label", cssClass:"aLabel" }]]});
			jsPlumb.connect({ source:"server2", target:"switch1" , overlays: [[ "Label", { label:"서버커넥트", id:"label", cssClass:"aLabel" }]]});              
			jsPlumb.connect({ source:"server3", target:"switch1" , overlays: [[ "Label", { label:"서버커넥트", id:"label", cssClass:"aLabel" }]]});
			jsPlumb.connect({ source:"server2", target:"db1" , overlays: [[ "Label", { label:"정산DB조회", id:"label", cssClass:"bLabel" }]]});              
			jsPlumb.connect({ source:"server3", target:"db1" , overlays: [[ "Label", { label:"정산DB조회", id:"label", cssClass:"bLabel" }]]});
			jsPlumb.connect({ source:"server3", target:"db2" , overlays: [[ "Label", { label:"결재DB조회", id:"label", cssClass:"bLabel" }]]});
			jsPlumb.connect({ source:"switch1", target:"gate1" });
			jsPlumb.connect({ source:"gate1", target:"switch2" });
			jsPlumb.connect({ source:"switch2", target:"server4" , overlays: [[ "Label", { label:"버스", id:"label", cssClass:"cLabel" }]]});
			jsPlumb.connect({ source:"switch2", target:"server5" , overlays: [[ "Label", { label:"택시", id:"label", cssClass:"cLabel" }]]});
		}
	};
})();

/*
 *  This file contains the JS that handles the first init of each jQuery demonstration, and also switching
 *  between render modes.
 */
jsPlumb.bind("ready", function() {

	jsPlumb.DemoList.init();			

    // render mode
	var resetRenderMode = function(desiredMode) {
		var newMode = jsPlumb.setRenderMode(desiredMode);
		$(".rmode").removeClass("selected");
		$(".rmode[mode='" + newMode + "']").addClass("selected");		

		$(".rmode[mode='canvas']").attr("disabled", !jsPlumb.isCanvasAvailable());
		$(".rmode[mode='svg']").attr("disabled", !jsPlumb.isSVGAvailable());
		$(".rmode[mode='vml']").attr("disabled", !jsPlumb.isVMLAvailable());
					
		jsPlumbDemo.init();
	};
     
	$(".rmode").bind("click", function() {
		var desiredMode = $(this).attr("mode");
		if (jsPlumbDemo.reset) jsPlumbDemo.reset();
		jsPlumb.reset();
		resetRenderMode(desiredMode);					
	});	

	resetRenderMode(jsPlumb.SVG);
       
});


//
// this script is used to dynamically insert links from each demo to its previous and next,
// as well as write the drop down.  
//
;(function() {

	jsPlumb.DemoList = {
		init : function() {
			var bod = document.body,
				demoId = bod.getAttribute("data-demo-id"),
				library = bod.getAttribute("data-library");
		}
	};
})();