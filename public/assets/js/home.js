jQuery(function($){	
	$('.prntli a').on('click',function(e){
		e.preventDefault();
		$(this).parent().toggleClass('open');
	});	

	

	$('input[name="risk"]').change(function() {
	  if ($(this).val() == 'Typhoon') {
		  $('#typhoon_name').prop('disabled', false);
	  } else {
		  $('#typhoon_name').prop('disabled', true);
	  }
	});
	  
	$(document).ready(function() {
		let isToggle = false;
		$("#calTggle").click(function() {	
		  $("#calendarDiv").fadeToggle();
		  if (!isToggle) {
			isToggle = true;
			$(this).text('Remove on Map');
			document.getElementById("calTggle").style.color = "red";
		  } else {
			isToggle = false;
			$(this).text('Date Picker');
			document.getElementById("calTggle").style.color = "adadad";
		  }
		  
		});
	  });
		dragElement(document.getElementById("calendarDiv"));
	
		function dragElement(elmnt) {
		var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
		if (document.getElementById(elmnt.id + "calendarDivHeader")) {
		  document.getElementById(elmnt.id + "calendarDivHeader").onmousedown = dragMouseDown;
		} else {
		  elmnt.onmousedown = dragMouseDown;
		}
		function dragMouseDown(e) {
		  e = e || window.event;
		  e.preventDefault();
		  pos3 = e.clientX;
		  pos4 = e.clientY;
		  document.onmouseup = closeDragElement;
		  document.onmousemove = elementDrag;
		}
		
		function elementDrag(e) {
		  e = e || window.event;
		  e.preventDefault();
		  pos1 = pos3 - e.clientX;
		  pos2 = pos4 - e.clientY;
		  pos3 = e.clientX;
		  pos4 = e.clientY;
		  elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
		  elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
		}
		
		function closeDragElement() {
		  document.onmouseup = null;
		  document.onmousemove = null;
		}
		}
	
});