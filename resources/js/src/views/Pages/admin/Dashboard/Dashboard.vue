    <template>
  <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="configuration" class="dashboard">

                
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-transparent shadow-none mb-0">
                            <div class="card-body p-md-2 p-lg-2">
                                <div class="page-title mb-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 mb-3">
                                            <h2>Dashboard</h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-dashboard mt-2 mt-md-3 mb-0 mb-md-3">
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-2 d-flex">
                                            <div class="card">
                                                <div class="card-title pt-4">Total Users</div>
                                                <div class="card-body py-1">
                                                    <div class="media align-items-center d-flex w-100">
                                                        <div class="media-body text-left flex-grow-1">
                                                            <h3>{{detail.total_users}}</h3>
                                                        </div>
                                                        <div class="align-self-center flex-shrink-1">
                                                            <img src="images/icon-user.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-transparent border-0 pt-0 pb-4">
                                                    <h4>100% <i class="fas fa-arrow-up"></i> Since Last Week</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-2 d-flex align-items-stretch">
                                            <div class="card">
                                                <div class="card-title pt-4">Total Medicine <span class="d-inline d-xl-block">Reminder Set</span></div>
                                                <div class="card-body py-1">
                                                    <div class="media align-items-center d-flex w-100">
                                                        <div class="media-body text-left flex-grow-1">
                                                            <h3>{{detail.total_medicine_reminder}}</h3>
                                                        </div>
                                                        <div class="align-self-center flex-shrink-1">
                                                            <img src="images/icon-medication.png" alt="">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="card-footer bg-transparent border-0 pt-2 pb-4 px-0">
                                                        <h4>10% <i class="fas fa-arrow-up"></i> Since Last Week</h4>
                                                    </div> -->
                                                </div>
                                                <div class="card-footer bg-transparent border-0 pt-0 pb-4">
                                                    <h4>10% <i class="fas fa-arrow-up"></i> Since Last Week</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-2 d-flex align-items-stretch">
                                            <div class="card">
                                                <div class="card-title pt-4">Total Appointment <span class="d-inline d-xl-block">Reminder Set</span></div>
                                                <div class="card-body py-1">
                                                    <div class="media align-items-center d-flex w-100">
                                                        <div class="media-body text-left flex-grow-1">
                                                            <h3>{{detail.total_appointment_reminder}}</h3>
                                                        </div>
                                                        <div class="align-self-center flex-shrink-1">
                                                            <img src="images/icon-document.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-transparent border-0 pt-0 pb-4">
                                                    <h4>20% <i class="fas fa-arrow-up"></i> Since Last Week</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-block card-chart border-none bg-white rounded-10 p-3 p-lg-5 align-items-center">
                                    <div class="card-header d-block d-sm-flex justify-content-between bg-transparent border-0 p-0 ">
                                        <h3 class="fw-bold mb-0 align-self-center">Earning Stats</h3>
                                        <div class="">
                                            <div class="select-wrapper d-block d-sm-inline-block mt-1 mt-sm-0 me-0 me-sm-2">
                                                <select v-model="selectedYear" name="" id="" class="form-control">
                                                    <option value="">Choose a Year</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body px-0 pt-5 pb-0">
                                        <div class="chartbox position-relative text-center">
                                          <BarChart :label="`Total Earnings`" v-if="dashboardGraph.length" :data="dashboardGraph"/>

                                            <!-- <img src="images/chart.png" alt="" class="img-fluid"> -->
                                            <!-- <h4 class="fw-bold rotate">Amount (in AED)</h4> -->
                                            <h4 class="fw-bold mt-2">Duration</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="card d-block card-chart border-none bg-white rounded-10 p-3 p-lg-5 align-items-center mt-5 mb-0">
                                    <div class="card-header d-block d-sm-flex justify-content-between bg-transparent border-0 p-0 ">
                                        <h3 class="fw-bold mb-0 align-self-center flex-shrink-0">Subscription Stats</h3>
                                        <div class="">
                                            <div class="select-wrapper d-block d-sm-inline-block mt-1 mt-sm-0 me-0 me-sm-2">
                                                <select v-model="selectedYearEarn" name="" id="" class="form-control">
                                                    <option value="">Choose a Year</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                </select>
                                            </div>
                                            <!-- <div class="select-wrapper d-block d-sm-inline-block mt-1 mt-sm-0">
                                                <select name="" id="" class="form-control">
                                                    <option value="">Select Duration </option>
                                                    <option value="">1</option>
                                                    <option value="">2</option>
                                                    <option value="">3</option>
                                                    <option value="">4</option>
                                                    <option value="">5</option>
                                                </select>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="card-body px-0 pt-5 pb-0">
                                        <div class="chartbox position-relative text-center">
                                             <StatChart :label="`Total Subscriptions`" v-if="dashboardStat.length" :data="dashboardStat" class="img-fluid w-100"/>

                                            <!-- <h4 class="fw-bold rotate2">Quantity</h4> -->
                                            <h4 class="fw-bold mt-2">Duration</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</template>

<script src="admins/app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script>
 <script src="admins/app-assets/vendors/js/charts/echarts/echarts.js" type="text/javascript"></script>
 <script src="admins/app-assets/js/scripts/charts/echarts/bar-column/basic-column.js" type="text/javascript"></script>
 <script src="admins/app-assets/js/scripts/charts/echarts/pie-doughnut/basic-pie.js" type="text/javascript"></script>
<script>
import { mapActions, mapState } from 'vuex';
const DashboardCards = ()=> import('./components/DashboardCards.vue');
const BarChart = () => import('@views/Pages/admin/Dashboard/BarChart.vue');
const StatChart = () => import('@views/Pages/admin/Dashboard/StatChart.vue');

// import BarChart from './BarChart.js'



import allMonths from '@core/months.js';

export default {
    components: {
        BarChart,
        DashboardCards,
        StatChart
    },
    data() {
        return {
            dashboardStat:'',
              dashboardGraph: [],
              selectedYearEarn: '2022',
            business_type : '',
            business_types : [],
            trending_category : '',
            trending_duration : 'all',
            total_facts_duration : 'all',
            facts_duration : 'all',
            badges_collect_duration : 'all',
            total_businesses_duration : 'all',
            total_users_duration : 'all',
            categories : [],
            detail : {},
            selectedYear: '2022',
            selectedYearEarn:'2022',
             months: [],
            loaded: false,
            chartData: {
                labels: allMonths,
                datasets: [{
                    label: 'Payments',
                    data: [],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 0.5,
                    minBarLength: 2,
                }]
            },
            options : {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            },
            chartOptionsBar: {
                xAxis: {
                    data: [...allMonths],
                },
                yAxis: {
                    type: 'value',
                },
                series: [{
                    type: 'bar',
                    data: [],
                }]
            }
        };
    },
    computed: {
        ...mapState('admin', ['home']),
        tableFields(){
                return [
                    {
                        label : 'User Name',
                        key : 'username',

                    },
                    {
                        label : 'Email Address',
                        key : 'email',
                        
                    },
                    {
                        label : 'Date Registered',
                        key : 'created_at',
                        format : this.formatDate,
                        
                    },
                    {
                        label : 'status',
                        key : 'status_detail',                       
                    },
                ]
        },
        years: () => {
            let today = new Date();
            let currentYear = today.getFullYear();
            let last10Years = new Date(today.setFullYear(today.getFullYear() - 10)).getFullYear();
            let years = [];
            for (var i = currentYear; i >= last10Years; i--) {
                years.push(i);
            }
            return years;
        },
    },
    async created() {
        let self = this;
        await this.getGraphData();
        await this.getGraphStat();
        this.fetch().then((res) => {
            self.loaded = true; 
        });
    },
    beforeMount() {
    },
    watch: {
        selectedYear(val, oldVal) {
            this.getGraphData();
        },
        selectedYearEarn(val, oldVal) {
            this.getGraphStat();
        },
        chartData(val){
            alert();
        },
        getGraphStat(){
            this.fetch();
        },
        total_facts_duration(){
            this.fetch();
        },
        facts_duration(){
            this.fetch();
        },
        business_type(){            
            this.fetch();
        },

        total_users_duration(){            
            this.fetch();
        },
    },
    methods: {
        ...mapActions('admin', ['getAll']),

            async getGraphData() {
            let params = {
                route: route('admin.charts.users'),
                data: {
                    year : this.selectedYear,
                }
            };
            let { data } = await this.getAll(params);
            this.dashboardGraph = data.graphdata
        },  


            async getGraphStat() {
            let params = {
                route: route('admin.charts.subs'),
                data: {
                    year : this.selectedYearEarn,
                }
            };
            let { data } = await this.getAll(params);
            this.dashboardStat = data.graphdata
        },        
        async fetch() {
            this.loaded = false;
            let params = {
                route: route('admin.home'),
                data: {
                    trending_category : this.trending_category,
                    trending_duration : this.trending_duration,
                    total_facts_duration : this.total_facts_duration,
                    facts_duration : this.facts_duration,
                    business_type : this.business_type,
                    total_businesses_duration : this.total_businesses_duration,
                    total_users_duration : this.total_users_duration,
                }
            };
            let { data } = await this.getAll(params);
            this.detail = data;
        },
    }
}

</script>
