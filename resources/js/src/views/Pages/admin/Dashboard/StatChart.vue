<script>
    import { Bar } from "vue-chartjs";
    export default {
        extends: Bar,
        props: [
            'data',
            'label'
        ],
        mounted() {
            this.renderBarChart();
        },
        computed: {
            chartData: function() {
                return this.data;
            }
        },
        methods: {
            renderBarChart(){
                this.renderChart(
                    {
                        labels: [
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December"
                        ],
                        datasets: [
                            {
                                label: this.label,
                                backgroundColor: "#17d4b4",
                                data: this.chartData,
                                barThickness: 100,
                                maxBarThickness: 100,
                                minBarLength: 2,
                            }
                        ]
                    },
                    { responsive: true, maintainAspectRatio: false }
                );
            }
        },
        watch: {
            data: function() {
                console.log(this.data);
                console.log(this.label);
                this.renderBarChart();
            }
        }
    };

</script>
