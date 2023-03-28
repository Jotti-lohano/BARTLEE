<template>
	<ul v-if="typeof item.children != 'undefined' && item.children.length > 0" class="menu-content">
		<li :key="childIndex" v-for="(child,childIndex) in item.children">
			<!-- <a class="menu-item" href="a-inventory-management.html">Inventory Management</a>  -->
			<router-link :to="{name : child.componentName,params : child.defaultParams }" class="menu-item" exact>
				<template>
					<!-- <i v-if="typeof item.imageIcon == 'undefined'" :class="item.iconClasses" aria-hidden="true"></i>
					<img v-else draggable="false" :src="item.imageIcon"> -->
				</template>
				<span class="menu-title" data-i18n="">{{child.name}}</span>
			</router-link>
		</li>
	</ul>
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
