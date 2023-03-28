<template>
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox border-bottom py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.packages.index'}" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>{{$route.params.type == 'plans'?'Business Plan':'Smile'}} Details</router-link></h3>
            </div>
        </div>
    </div>
    <component :is="`${componentName}-detail`"/>
</div>    
</template>
</template>
<script>
import PackageDetail from './Components/Detail/Package.vue';
import SmileDetail from './Components/Detail/Smile.vue';
export default {
    components : {
        PackageDetail,
        SmileDetail
    },
    created (){
        this.componentName = this.$route.params.type == 'plans'?'package':'smile';        
    },
    data : ()=> ({
        componentName : 'package'
    }),
    methods : {

    },
}
</script>