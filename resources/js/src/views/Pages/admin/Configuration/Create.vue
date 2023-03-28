<template>
<div>

 <component :is="`create-${componentName}`"/>

</div>
</template>
<script>
import CreateCategory from './Components/Create/CreateCategory.vue';
import CreateBusinessType from './Components/Create/CreateBusinessType.vue';
import CreateStickers from './Components/Create/CreateStickers.vue';
import CreatePushAnnouncements from './Components/Create/CreatePushAnnouncements.vue';
export default {
    components : {
        CreateCategory,
        CreateBusinessType,
        CreateStickers,
        CreatePushAnnouncements
    },
    data : ()=> ({
        componentName : 'category',
    }),
	created() {

		this.componentName = this.$route.params.type;
     
	},
}
</script>