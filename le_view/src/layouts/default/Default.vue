<template>
  <v-app>
    <default-bar />
    <slide-bar />
    <left-bar />
    <right-bar />
    <sub-app-bar />

    <default-view />

    <default-footer />
  </v-app>
</template>

<script lang="ts" setup>
  import DefaultBar from './AppBar.vue'
  import DefaultView from './View.vue'
  import SlideBar from "@/layouts/default/SlideBar.vue";
  import LeftBar from "@/layouts/default/LeftBar.vue";
  import DefaultFooter from "@/layouts/default/DefaultFooter.vue";
  import RightBar from "@/layouts/default/RightBar.vue";
  import SubAppBar from "@/layouts/default/SubAppBar.vue";
</script>
