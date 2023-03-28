<template>
    <div>
        <div class="tab-pane fade show active" id="business" role="tabpanel" aria-labelledby="business-tab">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Smiles:</h3>
            </div>
            <div class="notification-section shadow p-5 rounded-15 my-4">
                <div class="row">
                    <div class="col-md-12 pt-5 table-responsive">
                          <Table @page-changed="fetch" :fields="tableFields" :data="smiles">
                    <table-search 
                        show-date-ranges
                        @on-search="setCallback('search',$event,fetch)"
                        @on-change-entries="setCallback('entries',$event,fetch)"
                        @on-change-status="setCallback('currentStatus',$event,fetch)"
                        @on-change-date-from="setCallback('dateFrom',$event,fetch)"
                        @on-change-date-to="setCallback('dateTill',$event,fetch)"
                    /></Table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { mapActions, mapState } from 'vuex';
export default {
    computed: {
        // ...mapState('admin', ['search','entries']),
        tableFields(){
                return [
                    {
                        label : 'Name',
                        key : 'name',
                        
                    },
                    {
                        label : 'Purchased On',
                        key : 'created_at',
                        format : this.formatDate,
                        
                    },
                     {
                        label : 'Amount',
                        key : 'amount',
                        format : (amount)=>{  return `$${amount || 0 }` },
                    }
                ]
        },
    },
    components: {
    },
    data() {
        return {
            smiles : {},
            currentStatus: '',
            dateFrom: '',
            dateTill: '',
            fromDateCheck: false,
            tillDateCheck: false,
            type : '',
            entries : 10,
            search : null,
        };
    },
    created() {
       
        this.fetch();
    },
    watch: {
        search: function(val, oldVal) {
            this.fetch();
        },
        entries: function(val, oldVal) {
            this.fetch();
        },
        dateTill(val, oldVal){
            if(val.length > 0){
                this.tillDateCheck = true;
                if(this.fromDateCheck){
                    this.fetch();
                }
            }else{
                this.tillDateCheck = false;
            }
        },
        dateFrom(val, oldVal){
            if(val.length > 0){
                this.fromDateCheck = true;
                if(this.tillDateCheck){
                    this.fetch();
                }
            }else{
                this.fromDateCheck = false;
            }
        }
    },
    methods: {
        ...mapActions('admin', ['getAll']),
        async fetch(page = 1) {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.finance.smile.index'),
                data: {
                    page,
                    type,
                    status: this.currentStatus,
                    search : this.search,
                    entries : this.entries,
                    dateFrom: this.dateFrom,
                    dateTill: this.dateTill,
                    type : this.type,
                }
            };
            let { data } = await this.getAll(params);
            this.smiles = data.smiles;
        },


        fetchFilteredData(e){
            this.currentStatus = e.target.value;
            this.fetch();
        },

        clearCalandar(){
            this.dateFrom = '';
            this.dateTill = '';
            this.fetch();
        }
    }
}

</script>