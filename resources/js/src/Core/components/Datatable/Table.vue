<template>
	<table :id="id" :class="classes">
		
	</table>
</template>
<script>
	export default{

		props: {
		  selector : {
		    type: String,
		    required: false,
		    default: 'table'
		  },
		  id : {
		    type: String,
		    required: false,
		    default: 'table'
		  },
		  classes : {
		    type: String,
		    required: false,
		    default: 'table'
		  }
		},
	}
</script>