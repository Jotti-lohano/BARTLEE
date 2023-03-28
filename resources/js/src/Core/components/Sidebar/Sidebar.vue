<template>
  <div class="main-menu menu-fixed menu-light menu-accordion" data-scroll-to-active="true">
        <div class="main-menu-content">
          <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item" @click="showChildren(index)" :key="index" v-for="(item,index) in sidebarItems" 
                :class="{
                    'has-sub' : (typeof item.children != 'undefined' && item.children.length > 0),
                    'open' : clickedIndex == index
                }">
                <template>
                    <sidebar-item :item="item"></sidebar-item>
                    <sidebar-group :item="item"></sidebar-group>
                </template>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import sidebarItems from './sideBarItems.js';
const sidebarItem = ()=> import('./SidebarItem.vue');
const SidebarGroup = ()=> import('./SidebarGroup.vue');
export default {
    data() {
        return {
            clickedIndex : -1,
            sidebarItems: sidebarItems
        };
    },
    components : {
        sidebarItem,
        SidebarGroup,
    },
    methods: {
      showChildren(index) {
        if(this.clickedIndex == index){
            this.clickedIndex = -1;
        }else{
            this.clickedIndex = index;

        }
      }
    }
}

</script>
