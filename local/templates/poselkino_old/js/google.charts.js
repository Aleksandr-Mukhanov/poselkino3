google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
		['Element', 'Density', { role: 'style' }, { role: 'annotation' } ],
		['Copper', 8.94, '#b87333', 'Cu' ],
		['Silver', 10.49, 'silver', 'Ag' ],
		['Gold', 19.30, 'gold', 'Au' ],
		['Platinum', 21.45, 'color: #e5e4e2', 'Pt' ],
	]);

	var view = new google.visualization.DataView(data);
	view.setColumns([0, 1,{
			calc: "stringify",
			sourceColumn: 1,
			type: "string",
			role: "annotation" 
			},2]
		);

	var options = {
		vAxis: {
			title: 'Кол-во проданных участков'
		},
		bar: {groupWidth: "70%"},
		legend: { position: "none" },
		// vAxis: { textPosition: 'none' },
		tooltip: { isHtml: true },
	};
	
	var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
		chart.draw(view, options);
}