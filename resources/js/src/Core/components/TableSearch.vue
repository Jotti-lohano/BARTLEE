<template>
     <div class="user-listing-top">
                        <div class="row align-items-end d-flex mb-3">
                            <div class="col-12 col-lg-12 col-xxl-8 mb-2 mb-md-0">
                                <label class="fw-regular text-gray">Filters</label>
                                <div class="filter-wrap user-filter d-md-flex d-block">
                                    <div class="select-wrapper d-block w-auto">
                                        <select v-model="userSubscription" name="" class="form-control" id="">
                                            <option value="">Select User Type</option>
                                            <option value="0">Free User</option>
                                            <option value="1">Subscriber</option>
                                        </select>
                                    </div>
                                    <div class="select-wrapper d-block w-auto my-3 my-md-0 mx-md-3">
                                        <select v-model="status" name="" class="form-control" id="">
                                            <option value="">Select Status</option>
                                            <option :key="statusIndex" v-for="(status,statusIndex) in statuses" :value="status.value">{{status.label}}</option>
                                        </select>
                                    </div>
                                    <div class="select-wrapper d-block w-auto">
                                        <select v-model="userType" name="" class="form-control" id="">
                                            <option value="">Signed Up Type</option>
                                            <option value="patient">Patient</option>
                                            <option value="attendee">Attendee</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xxl-12 mt-3 d-xl-flex d-block justify-content-start justify-content-lg-end align-items-center order-md-2">
                                <div class="user-record-lenght">
                                    <div class="select-wrapper d-block d-inline-md-block">
                                        <select v-model="entries" class="form-control d-inline-block">
                                            <option value="10">Records Per Page</option>
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xxl-4 text-start mt-3 mt-xxl-0 order-md-1">
                                <div class="dataTables_filter d-flex justify-content-start flex-shrink-1">
                                    <label for="" class="d-none d-md-inline-block me-2 me-lg-3 my-0 align-self-center flex-shrink-0 fw-light">Search</label>
                                    <div class="search-wrap flex-grow-1">
                                        <input v-model="searchValue" type="search" class="form-control" placeholder="Search">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                        </div>
                    </div>
</template>
<script>
import { mapState, mapActions, mapMutations } from "vuex";
export default {
    props: {
        showUserSubscription: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: false,
        },
        showUserType: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: false,
        },
        placeholder: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: false,
            default: "Search...",
        },
        showEntries: {
            type: Boolean, // String, Number, Boolean, Function, Object, Array
            required: false,
            default: true,
        },
        showStatus: {
            type: Boolean, // String, Number, Boolean, Function, Object, Array
            required: false,
            default: false,
        },
        showDateRanges: {
            type: Boolean, // String, Number, Boolean, Function, Object, Array
            required: false,
            default: false,
        },
        statuses: {
            type: Array,
            default: () => [
                {
                    label: "Active",
                    value: 1,
                },
                {
                    label: "Inactive",
                    value: 0,
                },
            ],
        },
    },
    data() {
        return {
            searchValue: "",
            entries: 10,
            fromDateCheck: false,
            tillDateCheck: false,
            dateFrom: "",
            dateTill: "",
            status: "",
            userType:"",
            userSubscription:""
        };
    },
    watch: {
        searchValue: function (val, oldVal) {
            this.handleSearch();
        },
        entries(val) {
            this.$emit("on-change-entries", val);
            // this.SET_ENTRIES(val);
        },
        status(val) {
            this.$emit("on-change-status", val);
        },
        userType(val) {
            this.$emit("on-change-userType", val);
        },
        userSubscription(val) {
            this.$emit("on-change-userSubscription", val);
        },
        /* dateTill(val, oldVal){
            if(val.length > 0){
                this.tillDateCheck = true;
                if(this.fromDateCheck){
                    this.$emit('on-change-date-to',val);
                    this.$emit('on-change-date-from',this.dateFrom);
                }
            }else{
                this.tillDateCheck = false;
            }
        },
        
        dateFrom(val, oldVal){
            
            if(val.length > 0){
                this.fromDateCheck = true;
                if(this.tillDateCheck){
                    // this.fetch();                   
                    this.$emit('on-change-date-to',this.dateTill);
                    this.$emit('on-change-date-from',val);
                }
            }else{
                this.fromDateCheck = false;
            }
        } */
    },
    created() {
        this.handleSearch = _.debounce(this.handleSearch, 500);
    },
    computed: {
        // ...mapState('admin',['search']),
    },
    methods: {
        ...mapMutations("admin", ["SET_SEARCH", "SET_ENTRIES"]),
        handleSearch() {
            this.$emit("on-search", this.searchValue);
        },
        updateDates() {
            if (this.dateTill && this.dateFrom) {
                this.$emit("on-change-date-from", this.dateFrom);
                this.$emit("on-change-date-to", this.dateTill);
            }
        },
    },
};
</script>
