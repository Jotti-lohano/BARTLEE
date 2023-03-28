<template>
<div>
<create-request v-if="$route.params.type == 'request'"></create-request>

</div>
</template>
<script>
import CreateRequest from './Components/Create/Request.vue';
export default {
    components : {
        CreateRequest,
    },
}
</script>