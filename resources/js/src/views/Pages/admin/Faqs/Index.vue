<template>
<div class="app-content content">
    <div class="content-wrapper">
        <section id="inquiry_manage" class="inquiry-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12">
                        <h2>Inquiry Logs</h2>
                    </div>
                </div>
            </div>
            <div class="content-body bg-white rounded-10 shadow-none p-4 p-lg-5">
                <div class="dataTables_wrapper">
                    <div class="user-listing-top">
                        <div class="row align-items-end d-flex mb-3">
                            <div class="col-12 col-xl-7 col-xxl-8 mt-md-0 sort-datepicker d-block d-lg-flex align-items-end mb-3 mb-xl-0">
                                <label class="me-2 mb-0 pb-1 mb-lg-2 d-block flex-shrink-0">Sort By</label>
                                <div class="d-sm-flex d-block flex-grow-1">
                                    <div class="input-wrap me-0 me-sm-2 mb-2 mb-sm-0">
                                        <label for="" class="fw-regular">From</label>
                                        <input v-model="fromDate" type="date" placeholder="From" class="form-control">
                                    </div>
                                    <div class="input-wrap">
                                        <label for="" class="fw-regular">To</label>
                                        <input v-model="toDate" type="date" placeholder="To" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-5 col-xxl-4 align-items-center">
                                <div class="dataTables_filter d-flex justify-content-start flex-shrink-1">
                                    <label for="" class="d-none d-md-inline-block me-2 me-lg-3 my-0 align-self-center flex-shrink-0 fw-light">Search</label>
                                    <div class="search-wrap flex-grow-1">
                                        <input v-model="search" type="search" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mt-2 mt-md-0 align-self-xl-end">
                                <div class="dataTables_length order_select d-block d-md-flex align-items-center">
                                    <label class="d-inline-md-block d-block me-4">Show</label>
                                    <div class="d-block d-md-flex">
                                        <div class="select-wrapper  d-block d-inline-md-block w-auto">
                                            <select v-model="entries" class="form-control d-inline-block">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-tabble table-responsive mx-n2">
                        <table class="table table-borderless dataTable px-2">
                            <thead>
                                <tr>
                                    <th class="sorting">Sr. No.</th>
                                    <th class="sorting">Date</th>
                                    <th class="sorting">Customer Email</th>
                                    <th class="sorting">First Name</th>
                                    <th class="sorting">Last Name</th>
                                    <th class="sorting">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(faq,index) in faqs.data" :key="index">
                                    <td>{{++index}}</td>
                                    <td>{{faq.created_at | newFormatDate}}</td>
                                    <td>{{faq.email}}</td>
                                    <td>{{faq.firstname}}</td>
                                    <td>{{faq.lastname}}</td>
                                    <td>
                                        <div class="btn-group ml-1">
                                            <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <router-link class="dropdown-item" :to="{name : 'admin.faqs.details',params : {id : faq.id} }"><i class="fa fa-eye"></i>View</router-link>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                               
                                <no-record tag="tr" :colspan="6" :data="faqs.data" class="col-md-3"></no-record>

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-xxl-5 align-self-center text-center text-xxl-start">
                            <div class="dataTables_info pl-2">Showing {{faqs.to}} out of {{faqs.total}} entries</div>
                        </div>
                        <div class="col-sm-12 col-xxl-7 d-flex justify-content-center justify-content-xxl-end">
                            <div class="dataTables_paginate">
                                <ul class="pagination">
                                <pagination :data="faqs" @pagination-change-page="fetch"></pagination>                   

                                </ul>
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
import { mapActions } from 'vuex';
export default {
    data : ()=> ({
        faqs : {},
        entries:'10',
        search:'',
        toDate:'',
        fromDate:''
    }),
       watch: {
        search: function(val, oldVal) {
            this.fetch();
        },
        entries: function(val, oldVal) {
            this.fetch();
        },
        status: function(val, oldVal) {
            this.fetch();
        },
        fromDate: function(val, oldVal) {
            this.fetch();
        },
        toDate: function(val, oldVal) {
            this.fetch();
        },

    },
     created() {
        let { page } = this.$route.query;
        this.fetch(page);
    },
    methods : {
        ...mapActions('admin',['getAll']),
        async fetch(page = 1){
            try{
                let {data} = await this.getAll({
                route : route('admin.faqs.index'),
                method : 'get',
                 data: {
                    page,
                    search : this.search,
                    entries : this.entries,
                    fromDate:this.fromDate,
                    toDate:this.toDate
                }
                
            });
            this.faqs = data.faqs;
            }catch(e){
                console.log(e);
            }
        },
    },

}
</script>