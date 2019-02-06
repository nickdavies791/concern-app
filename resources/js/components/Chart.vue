<template>
    <div id="chart" class="chart-light">
        <canvas ref="chart"></canvas>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        name: 'chart',

        mounted() {
            var chart = this.$refs.chart;
            var ctx = chart.getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Green', 'Blue'],
                    datasets: [{
                        label: '# of Votes',
                        data: [1, 65, 34],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    }
</script>