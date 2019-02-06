<template>
    <div id="chart">
        <canvas ref="chart" height="400px"></canvas>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        name: 'chart',

        props: {
            type: {
                default: 'line'
            },
            data: {
                required: true,
                default: [],
            }
        },

        mounted() {
            var chart = this.$refs.chart;
            var ctx = chart.getContext("2d");
            var myChart = new Chart(ctx, {
                type: this.type,
                data: {
                    labels: this.data.labels,
                    datasets: [{
                        label: '# of Votes',
                        data: this.data.dataset,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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