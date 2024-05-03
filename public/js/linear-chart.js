FusionCharts.ready(function() {
    var stockQuantityChart = new FusionCharts({
        id: "stockRealTimeChart",
        type: 'realtimeLine',
        renderAt: 'line-chart-container',
        width: '100%',
        dataFormat: 'json',
        "dataSource": {
            "chart": {
                "theme": "fusion",
                "bgColor": "#a5a1a1",
                "refreshinterval": "5",
                "yaxisminvalue": "0",
                "yaxismaxvalue": "100",
                "numdisplaysets": "10",
                "labeldisplay": "rotate",
                "rotateLabels": "1",
                "slantLabels": "1",
                "showRealTimeValue": "0",
                "xAxisNameFontBold": "1",
                "yAxisNameFontBold": "1",
                "legendItemFontBold": "1",
                "legendItemFontSize": "15", // Rozmiar tekstu w legendzie
                "legendItemFontColor": "#000000", // Kolor tekstu w legendzie (czarny)
                "baseFontColor": "#000000", // Kolor tekstu (czarny)
                "baseFontBold": "10", // Pogrubienie tekstu
                "baseFontSize": "20", // Rozmiar tekstu
                "plotFillAlpha": "100"
            },
            "categories": [{
                "category": []
            }],
            "dataset": [{
                "seriesname": "Online",
                "color": "#6EBE01",
                "anchorRadius": "0",
                "data": []
            }, {
                "seriesname": "Offline",
                "color": "#DB303F",
                "anchorRadius": "0",
                "data": []
            }, {
                "seriesname": "Waiting",
                "color": "#F68D2B",
                "anchorRadius": "0",
                "data": []
            }]
        },
        
        "events": {
            "initialized": function(e) {
                var chartRef = FusionCharts("stockRealTimeChart");

                function addLeadingZero(num) {
                    return (num <= 9) ? ("0" + num) : num;
                }

                function updateData() {
                    var currDate = new Date();
                    var label = addLeadingZero(currDate.getHours()) + ":" +
                        addLeadingZero(currDate.getMinutes()) + ":" +
                        addLeadingZero(currDate.getSeconds());

                    var onlineValue = Math.floor(Math.random() * 100);
                    var offlineValue = Math.floor(Math.random() * 100);
                    var waitingValue = Math.floor(Math.random() * 100);

                    var strData = "&label=" + label +
                        "&value=" + onlineValue + "|" + offlineValue + "|" + waitingValue;
                    chartRef.feedData(strData);
                }

                var myVar = setInterval(function() {
                    updateData();
                }, 5000);
            }
        }
    }).render();
});
