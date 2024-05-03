document.addEventListener('DOMContentLoaded', function () {
    // Funkcja do generowania wykresu kołowego
    function generatePieChart(chartId, chartData, chartName) {
        const config = {
            type: 'pie',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'left', labels: { usePointStyle: true, padding: 20, color: 'white', font: { size: 20, weight: 'bold' } } },
                    title: { display: true, text: chartName, position: 'top', font: { size: 20, weight: 'bold', color: 'white' } },
                    datalabels: {
                        formatter: (value, ctx) => {
                            const sum = ctx.chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0);
                            const percentage = Math.round((value / sum) * 100);
                            return `${percentage}% (${ctx.dataset.data[ctx.dataIndex]})`;
                        },
                        color: 'white',
                        font: { weight: 'bold' },
                        anchor: 'end',
                        align: 'start',
                        offset: -10
                    }
                },
                layout: { padding: 0 },
                hover: { mode: 'nearest', intersect: false },
                tooltips: { enabled: false },
                cutout: '40%'
            },
        };

        const statusChart = new Chart(document.getElementById(chartId), config);

        function addTotalText() {
            const totalText = document.createElement('div');
            const total = chartData.datasets[0].data.reduce((acc, val) => acc + val, 0);
            totalText.innerHTML = `<div>Total</div><div>${total}</div>`;
            totalText.classList.add('total-text');
            document.getElementById(chartId).parentElement.appendChild(totalText);
        }

        /*addTotalText();*/
    }

    // Dane dla pierwszego wykresu
    const firstChartData = {
        labels: ['Online', 'Offline', 'Waiting'],
        datasets: [{
            data: [80, 30, 20],
            backgroundColor: ['#7FC008', '#DB303F', '#F68D2B'],
            borderWidth: 0
        }]
    };

    // Generowanie pierwszego wykresu
    generatePieChart('firstChart', firstChartData, 'Switches - Chart 1');

    // Dane dla drugiego wykresu
    const secondChartData = {
        labels: ['Online', 'Offline', 'Waiting'],
        datasets: [{
            data: [80, 50, 40],
            backgroundColor: ['#7FC008', '#DB303F', '#F68D2B'],
            borderWidth: 0
        }]
    };

    // Generowanie drugiego wykresu
    generatePieChart('secondChart', secondChartData, 'Switches - Chart 2');
});
