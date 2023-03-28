<template>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="configuration" class="search view-cause">
                <div class="row">
                    <div class="col-12">
                        <div class="card pad-20">
                            <div class="card-content collapse show">
                                <div class="card-body table-responsive card-dashboard">
                                        <router-link :to="{name : 'admin.users.index',params : {type : 'employee'}}">
                                            <h2>< USER MANAGEMENT</h2> 
                                        </router-link> 
                                            <section class="assign-task-box">
                                                <div class="">
                                                    <h2>Employee Assigned Tasks</h2>
                                                    <h6>Emp_Id: E-{{routeParams.user}}</h6>
                                                    <!--Accordion wrapper-->
                                                    <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                                                        <!-- Accordion card -->
                                                        <div class="card">
                                                            <!-- Card header -->
                                                            <div class="card-header" role="tab" id="headingOne1">
                                                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                                                    <h5 class="mb-0">
                                                                        <i class="fas fa-chevron-circle-down"></i> Recently
                                                                        Assigned
                                                                    </h5>
                                                                </a>
                                                            </div>
                                                            <!-- Card body -->
                                                            <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                                                                <div class="card-body">
                                                                    <div v-for="tasks in task.recentTasks" class="row">
                                                                        <div class="col-md-6">
                                                                            <i class="fas" :class="{'fa-check-circle' : tasks.status == 1,'fa-times-circle' : tasks.status == 0}"></i>
                                                                            <span class="gray-text">{{tasks.name}}</span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <form>
                                                                                <div class="form-group">
                                                                                    <p>{{tasks.property.name}}</p>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <span class="days-green">{{tasks.task_date}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <no-record tag="div" :data="task.recentTasks">
                                                                    	<div class="col-m-12">No Data Available</div>
                                                                    </no-record>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Accordion card -->
                                                        <!-- Accordion card -->
                                                        <div class="card">
                                                            <!-- Card header -->
                                                            <div class="card-header" role="tab" id="headingTwo2">
                                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                                                                    <h5 class="mb-0">
                                                                        <i class="fas fa-chevron-circle-down"></i> Today
                                                                    </h5>
                                                                </a>
                                                            </div>
                                                            <!-- Card body -->
                                                            <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                                                                <div class="card-body">
                                                                    <div v-for="tasks in task.todaystasks" class="row">
                                                                        <div class="col-md-6">
                                                                            <i class="fas" :class="{'fa-check-circle' : tasks.status == 1,'fa-times-circle' : tasks.status == 0}"></i>
                                                                            <span class="gray-text">{{tasks.name}}</span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <form>
                                                                                <div class="form-group">
                                                                                    <p>{{tasks.property.name}}</p>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <span class="days-green">{{tasks.task_date}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <no-record tag="div" :data="task.todaystasks">
                                                                    	<div class="col-m-12">No Data Available</div>
                                                                    </no-record>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Accordion card -->
                                                        <!-- Accordion card -->
                                                        <div class="card">
                                                            <!-- Card header -->
                                                            <div class="card-header" role="tab" id="headingThree3">
                                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                                                                    <h5 class="mb-0">
                                                                        <i class="fas fa-chevron-circle-down"></i> Upcoming
                                                                    </h5>
                                                                </a>
                                                            </div>
                                                            <!-- Card body -->
                                                            <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3" data-parent="#accordionEx">
                                                                <div class="card-body">
                                                                    <div v-for="tasks in task.upcomingTasks" class="row">
                                                                        <div class="col-md-6">
                                                                            <i class="fas" :class="{'fa-check-circle' : tasks.status == 1,'fa-times-circle' : tasks.status == 0}"></i>
                                                                            <span class="gray-text">{{tasks.name}}</span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <form>
                                                                                <div class="form-group">
                                                                                    <p>{{tasks.property.name}}</p>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <span class="days-green">{{tasks.task_date}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <no-record tag="div" :data="task.upcomingTasks">
                                                                    	<div class="col-m-12">No Data Available</div>
                                                                    </no-record>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Accordion card -->
                                                    </div>
                                                    <!-- Accordion wrapper -->
                                                </div>
            </section>
        </div>
    </div>
    </div>
    </div>
    </div>
    </section>
    </div>
    </div>
</template>
<script>
import { mapActions, mapState, mapMutations } from 'vuex';
export default {
    async created() {
        await this.fetch();
        // await this.getAll();
    },
    data() {
        return {
            assignPoperty: 0,
            task: {},
        };
    },
    computed: {
        // ...mapState('employee', ['task']),
    },
    methods: {
        ...mapActions('employee', ['get', 'store']),
        async fetch() {
            let { user } = this.$route.params;
            let params = {
                route: route('admin.employee.tasks', { employee: user }),
                data: {},
            };
            let { data } = await this.get(params);
            this.task = data.task;
        },
    }
}

</script>
