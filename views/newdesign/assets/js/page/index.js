"use strict";


$(function () {
	
//     chart1();
//     chart2();
//     chart3();
//     chart4();

// chart5();

// chart6();
// chart7();
// chart8();
// chart9();
// chart10();
    // select all on checkbox click
    $("[data-checkboxes]").each(function () {
        var me = $(this),
            group = me.data('checkboxes'),
            role = me.data('checkbox-role');

        me.change(function () {
            var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
                checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
                dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
                total = all.length,
                checked_length = checked.length;

            if (role == 'dad') {
                if (me.is(':checked')) {
                    all.prop('checked', true);
                } else {
                    all.prop('checked', false);
                }
            } else {
                if (checked_length >= total) {
                    dad.prop('checked', true);
                } else {
                    dad.prop('checked', false);
                }
            }
        });
    });



});



function chart1() {
    var options = {
        chart: {
            height: 400,
            type: "line",
            shadow: {
                enabled: true,
                color: "#000",
                top: 18,
                left: 7,
                blur: 10,
                opacity: 1
            },
            toolbar: {
                show: false
            }
        },
        colors: ["#786BED", "#999b9c"],
        dataLabels: {
            enabled: true
        },
        stroke: {
            curve: "smooth"
        },
        series: [{
            name: "NOS - "+yearof,
            data: num
        },
        {
            name: "AMT - "+yearof,
            data: point
        }
        ],
        grid: {
            borderColor: "#e7e7e7",
            row: {
                colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                opacity: 0.0
            }
        },
        markers: {
            size: 6
        },
        xaxis: {
            categories: ["Apr", "May", "Jun","Jul.","Aug.","Sep.","Auc.",'Nov.',"Dec.",'Jan.',"Fab.","Mar."],

            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            }
        },
        yaxis: {
            title: {
                text: "Nos - Points"
            },
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            },
            min: 0,
            max: max
        },
        legend: {
            position: "top",
            horizontalAlign: "right",
            floating: true,
            offsetY: -25,
            offsetX: -5
        }
    };

    var chart1 = new ApexCharts(document.querySelector("#chart1"), options);

    chart1.render();
}

function chart2() {
    var options = {
        chart: {
            height: 400,
            type: 'bar',
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: true
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '200px',
            },
        },
        series: [{
            name: 'PRODUCT A',
            data: [44, 55, 41, 67, 22, 43]
        }, {
            name: 'PRODUCT B',
            data: [13, 23, 20, 8, 13, 27]
        }, {
            name: 'PRODUCT C',
            data: [11, 17, 15, 15, 21, 14]
        }],
        xaxis: {
            type: 'datetime',
            categories: ['01/01/2019 GMT', '01/02/2019 GMT', '01/03/2019 GMT', '01/04/2019 GMT', '01/05/2019 GMT', '01/06/2019 GMT'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
        legend: {
            position: 'top',
            offsetY: 40,
            show: false,
        },
        fill: {
            opacity: 1
        },
    }

    var chart2 = new ApexCharts(
        document.querySelector("#chart2"),
        options
    );

    chart2.render();

}

function chart3() {
    var options = {
        chart: {
            height: 400,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            },

        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [5, 7, 5],
            curve: 'straight',
            dashArray: [0, 8, 5]
        },
        series: [{
            name: "Option 1",
            data: [45, 52, 38, 24, 33, 26, 21, 20]
        },
        {
            name: "Option 2",
            data: [35, 41, 62, 42, 13, 18, 29, 37]
        },
        {
            name: 'Option 3',
            data: [87, 57, 74, 99, 75, 38, 62, 47]
        }
        ],
        legend: {
            show: false,
        },
        markers: {
            size: 0,

            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug'
            ],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
        tooltip: {

        },
        grid: {
            borderColor: '#f1f1f1',
        }
    }

    var chart3 = new ApexCharts(
        document.querySelector("#chart3"),
        options
    );

    chart3.render();
}
function chart4() {
    var options = {
        chart: {
            height: 400,
            type: 'area',
            toolbar: {
                show: false
            },

        },
        colors: ['#999b9c', '#4CC2B0'], // line color
        fill: {
            colors: ['#999b9c', '#4CC2B0'] // fill color
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            colors: ['#999b9c', '#4CC2B0'] // marker color
        },
        series: [{
            name: 'No. of coupon',
            data: couponcount
        }, {
            name: 'No. of user',
            data: usercount
        }],
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Wk1', 'Wk2', 'Wk3', 'Wk4', 'Wk5'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
    }

    var chart4 = new ApexCharts(
        document.querySelector("#chart4"),
        options
    );

    chart4.render();

}
function chart5() {
    var options = {
        chart: {
            height: 400,
            type: 'area',
            toolbar: {
                show: false
            },

        },
        colors: ['#999b9c', '#4CC2B0'], // line color
        fill: {
            colors: ['#999b9c', '#4CC2B0'] // fill color
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            colors: ['#999b9c', '#4CC2B0'] // marker color
        },
        series: [{
            name: 'No. of coupon',
            data: couponcount5
        }, {
            name: 'No. of user',
            data: usercount5
        }],
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Wk1', 'Wk2', 'Wk3', 'Wk4', 'Wk5'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
    }

    var chart5 = new ApexCharts(
        document.querySelector("#chart5"),
        options
    );

    chart5.render();

}
function chart10() {
    var options = {
        chart: {
            height: 400,
            type: 'area',
            toolbar: {
                show: false
            },

        },
        colors: ['#999b9c', '#4CC2B0','#4CA2C0'], // line color
        fill: {
            colors: ['#999b9c', '#4CC2B0','#4CA2C0'] // fill color
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            colors: ['#999b9c', '#4CC2B0','#4CA2C0'] // marker color
        },
        series: [{
            name: 'Point transferred by usertype',
            data: couponcount6
        }, {
            name:'Total point transferred by  all usertypes',
            data: usercount6
        }, {
            name:'No of users',
            data: totaluser6
        }],
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Wk1', 'Wk2', 'Wk3', 'Wk4', 'Wk5'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
    }

    var chart10 = new ApexCharts(
        document.querySelector("#chart10"),
        options
    );

    chart10.render();

}

function chart7() {
    var options = {
        chart: {
            height: 400,
            type: 'area',
            toolbar: {
                show: false
            },

        },
        colors: ['#999b9c', '#4CC2B0'], // line color
        fill: {
            colors: ['#999b9c', '#4CC2B0'] // fill color
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            colors: ['#999b9c', '#4CC2B0'] // marker color
        },
        series: [{
            name: 'No. of coupon',
            data: couponcount7
        }, {
            name: 'No. of user',
            data: usercount7
        }],
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','July','Aug','Sep','Oct','Nov','Dec'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
    }

    var chart7 = new ApexCharts(
        document.querySelector("#chart7"),
        options
    );

    chart7.render();

}
function chart8() {
    var options = {
        chart: {
            height: 400,
            type: 'area',
            toolbar: {
                show: false
            },

        },
        colors: ['#999b9c', '#4CC2B0'], // line color
        fill: {
            colors: ['#999b9c', '#4CC2B0'] // fill color
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            colors: ['#999b9c', '#4CC2B0'] // marker color
        },
        series: [{
            name: 'No. of coupon',
            data: couponcount8
        }, {
            name: 'No. of user',
            data: usercount8
        }],
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','July','Aug','Sep','Oct','Nov','Dec'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
    }

    var chart8 = new ApexCharts(
        document.querySelector("#chart8"),
        options
    );

    chart8.render();

}
function chart6() {
    var options = {
        chart: {
            height: 400,
            type: 'area',
            toolbar: {
                show: false
            },

        },
        colors: ['#999b9c', '#4CC2B0'], // line color
        fill: {
            colors: ['#999b9c', '#4CC2B0'] // fill color
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            colors: ['#999b9c', '#4CC2B0'] // marker color
        },
        series: [{
            name: 'No. of points to user',
            data: couponcount6
        }, {
            name: 'total No. of points transfer ',
            data: usercount6
        }],
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Wk1', 'Wk2', 'Wk3', 'Wk4', 'Wk5'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
    }

    var chart = new ApexCharts(
        document.querySelector("#chart"),
        options
    );

    chart.render();

}
function chart9() {
    var options = {
        chart: {
            height: 400,
            type: 'area',
            toolbar: {
                show: false
            },

        },
        colors: ['#999b9c', '#4CC2B0','#4CA2C0'], // line color
        fill: {
            colors: ['#999b9c', '#4CC2B0','#4CA2C0'] // fill color
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            colors: ['#999b9c', '#4CC2B0','#4CA2C0'] // marker color
        },
        series: [{
            name: 'Point transferred by usertype',
            data: couponcount9
        }, {
            name: 'Total point transferred by  all usertypes',
            data: usercount9
        },{
            name: 'No of users',
            data: totaluser9

        }],
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','July','Aug','Sep','Oct','Nov','Dec'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
    }

    var chart9 = new ApexCharts(
        document.querySelector("#chart9"),
        options
    );

    chart9.render();

}