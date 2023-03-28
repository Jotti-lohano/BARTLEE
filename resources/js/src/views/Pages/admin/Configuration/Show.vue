<template>
<div>

 <component :is="`${componentName}-detail`"/>

</div>
</template>
<script>
import StickersDetail from './Components/Detail/StickersDetail.vue';
import PushAnnouncementsDetail from './Components/Detail/PushAnnouncementsDetail.vue';

export default {
    components : {
        StickersDetail,
        PushAnnouncementsDetail
    },
    data : ()=> ({
        componentName : 'stickers-detail',
    }),
	created() {

		this.componentName = this.$route.params.type;
     
	},
}
</script>