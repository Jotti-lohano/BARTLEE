<template>
<div class="userSection">
    <div class="titleBox border-bottom py-4">
        <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Reports</h3>
    </div>
    <div class="notification-section shadow p-5 rounded-15 my-4">
        <div class="row">
            <div class="col-md-12 pt-5 table-responsive">
                <Table @page-changed="fetch" :fields="tableFields" :data="reports">
                    <table-search 
                        show-date-ranges
                        @on-search="setCallback('search',$event,fetch)"
                        @on-change-entries="setCallback('entries',$event,fetch)"
                        @on-change-status="setCallback('currentStatus',$event,fetch)"
                        @on-change-date-from="setCallback('dateFrom',$event)"
                        @on-change-date-to="setCallback('dateTill',$event,fetch)"
                    />
                    <template slot="extra-cells" slot-scope="item">
                        <td>
                            <div class="btn-group ml-1">
                                <button type="button" class="btn border-color outline-0" data-toggle="dropdown" aria-expanded="false"> <i class="bi bi-three-dots-vertical"></i> </button>
                                <div class="dropdown-menu">
                                    <router-link :to="{ name : 'admin.reports.show',params : {id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
                                </div>
                            </div>
                        </td>
                    </template>
                </Table>
            </div>
        </div>
    </div>
</div>   
</template>
<script>
import { mapActions } from 'vuex';
export default {
    data : ()=> ({
        search : null,
        dateFrom : null,
        dateTill : null,
        entries : 10,
        reports : {},
    }),
    async created(){
        await this.fetch();
    },
    computed : {
        tableFields (){
            return [{
                key : 'business_user',
                label : 'Business Name',
                format : (detail)=> {
                    return detail.business_name || 'No Name';
                }
            },{
                key : 'items',
                label : 'Report Month',
                format : (items)=> {
                    return items[0].name;
                },
            },{
                key : 'created_at',
                label : 'Purchased On',
                format : this.formatDate,
            }];
        },
    },
    methods : {
        ...mapActions('admin',['getAll']),
        async fetch(page = 1){
            let {data} = await this.getAll({
                route : route('admin.reports.index'),
                type : 'GET',
                data : {
                    page,
                    search : this.search,
                    entries : this.entries,
                    dateFrom: this.dateFrom,
                    dateTill: this.dateTill,
                },
            });
            this.reports = data.reports;
        }
    },
}
</script>