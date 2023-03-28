<template>
    <div class="">
        <slot></slot>
        <table class="table table-borderless dataTable px-2">
            <thead>
                <tr>
                    <th class="sorting">Sr No.</th>
                    <th class="sorting" :key="fieldIndex" v-for="(field,fieldIndex) in fields">{{field.label}}</th>
                    <slot name="extra-heads"/>
                </tr>
            </thead>
            <tbody>
                <template v-if="!hasPagination">
                    <tr :key="itemIndex" v-for="(item,itemIndex) in data">
                        <td>{{itemIndex + 1}}</td>
                        <td :key="fieldIndex" v-for="(field,fieldIndex) in fields">{{field.format?field.format(data[itemIndex][field.key]):data[itemIndex][field.key]}}</td>
                        <slot name="extra-cells" v-bind="item"></slot>
                    </tr>
                    <no-record tag="tr" :data="data" :colspan="colspanFields" />
                </template>
                <template v-if="hasPagination">
                    <tr :key="itemIndex" v-for="(item,itemIndex) in data.data">
                        <td>{{serialNumber('data',itemIndex)}}</td>
                        <td :key="fieldIndex" v-for="(field,fieldIndex) in fields">{{field.format?field.format(data.data[itemIndex][field.key]):data.data[itemIndex][field.key]}}</td>
                        <slot name="extra-cells" v-bind="item"></slot>
                    </tr>
                    <no-record tag="tr" :data="data.data" :colspan="colspanFields" />
                </template>
            </tbody>
        </table>
        <div v-if="hasPagination" class="d-flex justify-content-between flex-wrap align-items-center">
            <p class="mb-0"> Showing {{ data.from || 0 }} to {{ data.to || 0}} of {{ data.total || 0 }} entries</p>
            <div class="viewAll d-flex justify-content-end flex-wrap py-3">
                <pagination :data="data" @pagination-change-page="changePage"></pagination>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props : {
        fields : {
            type : Array,
            default : ()=> ([]),
        },
        data : {
            type : [Array,Object],
            default : ()=> ({}),
        },
        hasPagination : {
            type : Boolean,
            default : true,
        },
    },
    computed : {
        colspanFields(){
            return Object.keys(this.fields).length + 1;
        },
    },
    methods : {
        changePage(page = 1){
            this.$emit('page-changed',page);
        },
    },
}
</script>