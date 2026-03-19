"use strict";


/*
var draw = Chart.controllers.line.prototype.draw;
Chart.controllers.lineShadow = Chart.controllers.line.extend({
	draw: function () {
		draw.apply(this, arguments);
		var ctx = this.chart.chart.ctx;
		var _stroke = ctx.stroke;
		ctx.stroke = function () {
			ctx.save();
			ctx.shadowColor = '#00000075';
			ctx.shadowBlur = 10;
			ctx.shadowOffsetX = 8;
			ctx.shadowOffsetY = 8;
			_stroke.apply(this, arguments)
			ctx.restore();
		}
	}
});

*/


var ctx = document.getElementById("budget_Chart").getContext('2d');
var myChart = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: ["Sunday", "Monday", "Tuesday"],
		datasets: [{
			label: 'Statistics',
			
			data: [260, 258, 330],
			borderWidth: 2,
		//	backgroundColor: '#6777ef',
		//	borderColor: '#6777ef',
		
			 backgroundColor: [
          "#3e95cd",
          "#8e5ea2",
          "#3cba9f",
          "#e8c3b9",
          "#c45850",
        ],
		 borderColor: [
          "#3e95cd",
          "#8e5ea2",
          "#3cba9f",
          "#e8c3b9",
          "#c45850",
        ],
		
			borderWidth: 2.5,
			pointBackgroundColor: '#ffffff',
			pointRadius: 4
		}]
	},
	options: {
		legend: {
			display: false
		},
	/*	title: {
		display: true,
		text: "Predicted Profit in millions",
		},
	*/

		scales: {
			yAxes: [{
				gridLines: {
					drawBorder: false,
					color: '#f2f2f2',
				},
				ticks: {
					beginAtZero: true,
					stepSize: 150,
					fontColor: "#9aa0ac", // Font Color
				}
			}],
			xAxes: [{
				ticks: {
					display: false
				},
				gridLines: {
					display: false
				}
			}]
		},
	}
});



	