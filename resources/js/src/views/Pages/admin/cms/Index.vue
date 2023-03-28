<template>
<div class="userSection">
    <div class="titleBox border-bottom py-4">
        <h3 class="mb-0 achivpFont mb-0 font-weight-bold">CMS</h3>
    </div>
    <div class="notification-section shadow p-5 rounded-15 my-4">
        <div class="row">
            <div class="col-md-12">
                <div class="addPackages text-md-right">
                    <router-link :to="{name : 'admin.faqs.index'}" class="btn">FAQs</router-link>
                    <router-link :to="{name : 'admin.cms.create'}" class="btn">Add Page</router-link>
                </div>
            </div>
            <div class="col-md-12 pt-5 table-responsive">
                <Table @page-changed="fetch" :fields="tableFields" :data="pages">
                    <table-search 
                        show-status
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
                                    <router-link :to="{ name : 'admin.pages.show',params : {id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
                                    <router-link :to="{ name : 'admin.cms.edit',params : {id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-pencil table-pencil pr-2 "></i>Edit</router-link>
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
        pages : {},
    }),
    async created(){
        await this.fetch();
    },
    computed : {
        tableFields (){
            return [{
                key : 'name',
                label : 'Name',
            },{
                key : 'created_at',
                label : 'Added On',
                format : this.formatDate,
            },{
                key : 'status',
                label : 'Status',
            }];
        },
    },
    methods : {
        ...mapActions('admin',['getAll']),
        async fetch(page = 1){
            let {data} = await this.getAll({
                route : route('admin.pages.index'),
                type : 'GET',
                data : {
                    page,
                    search : this.search,
                    entries : this.entries,
                    dateFrom: this.dateFrom,
                    dateTill: this.dateTill,
                },
            });
            this.pages = data.pages;
        }
    },
}
</script>