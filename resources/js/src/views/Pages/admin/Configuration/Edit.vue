<template>
<div>
        <component :is="`edit-${componentName}`"/>
</div>
</template>
<script>
import EditAccountCategory from './Components/Edit/EditAccountCategory.vue';
import EditBusinessType from './Components/Edit/EditBusinessType.vue';
import EditStickers from './Components/Edit/EditStickers.vue';
import EditPushAnnouncements from './Components/Edit/EditPushAnnouncements.vue';
export default {
    components : {
        EditAccountCategory,
        EditBusinessType,
        EditStickers,
        EditPushAnnouncements

    },
    data : ()=> ({
        componentName : 'account-category',
    }),
	created() {

		this.componentName = this.$route.params.type;
       
     
	},
}
</script>