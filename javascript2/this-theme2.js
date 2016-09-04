jQuery(document).ready( function ($) {
	
	$(".easySlider").easySlider({
		prevId: 'slider-prevBtn',
		prevText: '&lt;',
		
		nextId: 'slider-nextBtn',
		nextText: '&gt;',
		
		controlsShow: true,
		controlsBefore: '<p id="slider-controls">',
		controlsAfter: '</p>',	
		controlsFade: false,
		
		firstId: 'slider-firstBtn',
		firstText: 'First',
		firstShow: false,
		
		lastId: 'slider-lastBtn',
		lastText: 'Last',
		lastShow: false,
		
		auto: true, 
		continuous: true,
		
		numeric: true,
		numericId: 'slider-numbers',
		
		speed: 1600,
		pause: 3000,
	});
	
	$(".PikaChoose").PikaChoose({
		carousel:true,
		showCaption: false,
		showTooltips: false,
	});
	
	$('.last_projects LI A').hover(
		function() {
			$(".last_projects_caption", this).stop().animate({top: '150px'},{queue:false,duration:160});  
		},
		function() {  
			$(".last_projects_caption", this).stop().animate({top: '150px'},{queue:false,duration:160});  
		}
	);
	
	$('#prj-list LI').clone().appendTo('#prj-list-all');
	
	$('#prj-cats A').live( 'click', function() {
		
		prj_cat = $(this).attr('data-id');
		
		var data = $('#prj-list-all');
		var filteredData = data.find('li[data-type|=' + prj_cat + ']');
		
		$('#prj-list-tmp').html('');
		
		filteredData.clone().appendTo('#prj-list-tmp');
		
		$('#prj-list').quicksand( $('#prj-list-tmp LI'), {
			duration: 800,
		});
		
		$('#prj-cats A').removeClass('selected');
		$(this).addClass('selected');
		
		return false;
	});
});