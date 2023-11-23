const createChartDoughnut = (canvasChartId, chartLabels, chartData, title = false, subtitle = false) => {
    const chartStatus = Chart.getChart(canvasChartId);
    if(chartStatus) {
        chartStatus.destroy();
    }

    const chartConfig = {
        type: 'doughnut',
        data: { labels: chartLabels, datasets: [{ data: chartData, }], },
        options: { plugins: { legend: { labels: { font: { size: 16, } } } } }
    };

    if(title) {
        chartConfig.options.plugins.title = {
            display: true,
            text: title,
            font: {size: 16, color: '#000'}
        }
    }

    if(subtitle) {
        chartConfig.options.plugins.subtitle = { display: true, text: subtitle, }
    }

    new Chart($(`#${canvasChartId}`), chartConfig);
}

const createChartBar = (canvasChartId, chartLabels, chartData, title = false) => {
    const chartStatus = Chart.getChart(canvasChartId);
    if(chartStatus) {
        chartStatus.destroy();
    }

    if (chartData.length < 10) {
        const chartDataQtd = chartData.length;
        const responsiveHeight = chartDataQtd >= 3 ? chartDataQtd : 3;
        $('.productivity-report .chart-bar-finished .charts-requests-finished').css('height', `${responsiveHeight}0vh`);
    }

    const data = {
        labels: chartLabels,
        datasets: [{
            label: title || 'Representação de quantidade',
            data: chartData,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: title || `Quantidade total: ${chartData.length ? chartData.reduce((previous, sum) => previous + sum) : ''}`,
                },
            },
            maintainAspectRatio: false,
            indexAxis: 'y',
            layout: {
                padding: {
                    right: 25,
                    bottom: 25,
                    left: 10
                }
            },
            scales: {
                y: {
                    ticks: {
                        autoSkip: false,
                    }
                },
                x: {
                    position: 'top',
                    ticks: {
                        autoSkip: false,
                    },
                }
            },
        }
    };

    new Chart($(`#${canvasChartId}`), config);
}

export {createChartDoughnut, createChartBar};
