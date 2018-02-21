$(document).ready(function(){
	var color = [
			"#E95E4F",
            "#36CAAB"
		];
	var hoverColor = [
			"#E74C3C",
			"#26B99A"
		];
    var options = {
        	legend: false,
        	responsive: false
    	};
    $('.set_canvas').each(function(){
    	var bind = $(this).find('p.st_bind').data('val');
    	var unbind = $(this).find('p.st_unbind').data('val');
    	new Chart($(this).find('canvas'), {
	        type: 'doughnut',
	        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
	        data: {
	            labels: [
	                "已綁定",
	                "未綁定"
	            ],
	            datasets: [{
	                data: [bind,unbind],
	                backgroundColor: [
	                    color[0],
	                    color[1]
	                ],
	                hoverBackgroundColor: [
	                    hoverColor[0],
	                    hoverColor[1]
	                ]
	            }]
	        },
	        options: options
	    });
    });
});