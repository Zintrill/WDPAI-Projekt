// Dane dla pierwszego wykresu donut

Chart.defaults.color = '#FFF';

const data1 = {
    labels: ['Online', 'Offline', 'Waiting'],
    datasets: [{
        data: [200, 100, 150],
        backgroundColor: [
            '#7FC008', // Zielony
            '#DB303F', // Czerwony
            '#F68D2B' // Pomarańczowy
        ],
        borderWidth: 0, // Usunięcie białego obramowania
        hoverOffset: 4
    }]
};

// Dane dla drugiego wykresu donut
const data2 = {
    labels: ['Online', 'Offline', 'Waiting'],
    datasets: [{
        data: [80, 120, 90],
        backgroundColor: [
            '#7FC008', // Zielony
            '#DB303F', // Czerwony
            '#F68D2B' // Pomarańczowy
        ],
        borderWidth: 0, // Usunięcie białego obramowania
        hoverOffset: 4
    }]
};

// Opcje dla obu wykresów
const options = {
    responsive: true,
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                font: {
                    size: 15, // Zwiększenie czcionki legendy
                },
                usePointStyle: true, // Użycie kółek zamiast prostokątów w legendzie
                padding: 20
            }
        },
        title: {
            display: true,
            text: 'Switches',
            font: {
                size: 20,
                weight: 'bold'
            },
            padding: 20
        }
    }
};

// Opcje dla drugiego wykresu
const options2 = {
    responsive: true,
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                font: {
                    size: 15, // Zwiększenie czcionki legendy
                },
                usePointStyle: true, // Użycie kółek zamiast prostokątów w legendzie
                padding: 20
            }
        },
        title: {
            display: true,
            text: 'All',
            font: {
                size: 20,
                weight: 'bold'
            },
            padding: 20
        },
    },
};

// Utwórz pierwszy wykres donut
const donutChart1 = new Chart(document.getElementById('donutChart1'), {
    type: 'doughnut',
    data: data1,
    options: options
});

// Utwórz drugi wykres donut
const donutChart2 = new Chart(document.getElementById('donutChart2'), {
    type: 'doughnut',
    data: data2,
    options: options2
});
