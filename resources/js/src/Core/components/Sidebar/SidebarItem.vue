<template>
	<a v-if="typeof item.children != 'undefined' && item.children.length > 0" class="l" href="javascript:void(0)">
		<template>
			<i v-if="typeof item.imageIcon == 'undefined'" :class="item.iconClasses"></i>
			<img v-else draggable="false" :src="item.imageIcon">
		</template>
		{{item.name}}
	</a>

	<router-link v-else :to="{name : item.componentName,params : item.defaultParams }" exact>
		<template>
			<i v-if="typeof item.imageIcon == 'undefined'" :class="item.iconClasses"></i>
			<img v-else draggable="false" :src="item.imageIcon">
		</template>
		<span class="menu-title">{{item.name}}</span>
	</router-link>
</template>
<script>
export default {
	props: {
		item: {
			type: Object, // String, Number, Boolean, Function, Object, Array
			required: true,
			default: () => {
				return {};
			}
		}
	},
}

</script>
