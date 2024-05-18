// Tworzymy początkowe dane
let LineData = {
    labels: [],
    datasets: [
        {
            label: 'Online',
            borderColor: '#7FC008',
            backgroundColor: '#7FC008',
            data: [],
        },
        {
            label: 'Offline',
            borderColor: '#DB303F',
            backgroundColor: '#DB303F',
            data: [],
        },
        {
            label: 'Waiting',
            backgroundColor: '#F68D2B',
            borderColor: '#F68D2B',
            data: [],
        }
    ]
};

// Określamy szerokość i wysokość elementu canvas
const canvasWidth = '100%'; // Nowa szerokość
const canvasHeight = '300'; // Nowa wysokość

// Tworzymy element canvas i nadajemy mu właściwości szerokości i wysokości
let canvas = document.getElementById('myChart');
canvas.width = canvasWidth;
canvas.height = canvasHeight;

// Tworzymy wykres na podstawie danych
let ctx = canvas.getContext('2d');
// Tworzymy wykres na podstawie danych
let myChart = new Chart(ctx, {
    type: 'line',
    data: LineData,
    options: {
        animation: {
            duration: 0, // Wyłączamy animację
        },
        scales: {
            x: {
                ticks: {
                    color: 'black', // Kolor tekstu etykiet osi czasu
                    font: {
                        size: "15px",
                        weight: 'bold' // Pogrubiamy tekst etykiet osi czasu
                    } 
                }
            },
            y: {
                ticks: {
                    color: 'black',// Kolor tekstu etykiet osi Y
                    font: {
                        size: "15px",
                        weight: 'bold' // Pogrubiamy tekst etykiet osi czasu
                    } 
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom', // Umieszczamy legendę pod wykresem
                labels: {
                    font: {
                        size: 15, // Zwiększenie czcionki legendy
                    },
                    usePointStyle: true, // Użycie kółek zamiast prostokątów w legendzie
                }
            }
        }
    }
});
// Funkcja generująca losową liczbę całkowitą z zakresu min do max
function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

// Funkcja dodająca nowe dane do wykresu
function addData(label, time) {
    let randomOnline = randomInt(10, 100);
    let randomOffline = randomInt(5, 50);
    let randomWaiting = randomInt(1, 20);
    
    // Dodajemy nowe dane
    myChart.data.labels.push(time);
    myChart.data.datasets[0].data.push(randomOnline);
    myChart.data.datasets[1].data.push(randomOffline);
    myChart.data.datasets[2].data.push(randomWaiting);

    // Usuwamy starsze dane
    if (myChart.data.labels.length > 10) {
        myChart.data.labels.shift();
        myChart.data.datasets.forEach((dataset) => {
            dataset.data.shift();
        });
    }

    // Aktualizujemy wykres
    myChart.update();
}

// Funkcja symulująca generowanie danych co 5 sekund
function generateData() {
    let currentTime = new Date().toLocaleTimeString();
    addData('Online', currentTime);
    setTimeout(generateData, 5000);
}

// Uruchamiamy generowanie danych
generateData();
