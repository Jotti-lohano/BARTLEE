<template>
    <router-view></router-view>
</template>
<script>
export default {
    watch: {
        '$route': (val, oldVal) => {
        	window.scrollTo(0,0);
        },
        immediate : true,
    }
}

</script>
