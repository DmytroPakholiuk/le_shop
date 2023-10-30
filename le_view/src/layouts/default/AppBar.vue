<template>
  <v-app-bar flat color="primary">
    <v-app-bar-title>
      <v-app-bar-nav-icon variant="text" @click.stop="moveSlideBar" />

      <router-link to="/" style="text-decoration: none; color: inherit;">
        <v-icon icon="mdi-circle-slice-6" />

        Le Shop
      </router-link>

    </v-app-bar-title>

    <v-spacer/>

    <login-button></login-button>
    <signup-button></signup-button>
  </v-app-bar>
</template>

<script lang="ts" setup>
  import LoginButton from "@/components/LoginButton.vue";
  import SignupButton from "@/components/SignupButton.vue";
  import {useAppStore} from "@/store/app";

  const emit = defineEmits(['moveSlideBar'])
  const appStore = useAppStore()

  // import SlideBar from "@/layouts/default/SlideBar.vue";
  function moveSlideBar(){
    appStore.slideBarVisible = !appStore.slideBarVisible
    emit('moveSlideBar')
  }
</script>
