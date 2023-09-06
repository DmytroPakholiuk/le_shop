<template>
  <v-navigation-drawer
        v-model="drawer"
        location="left"
        temporary
  >
    <v-list
      :items="items"
    ></v-list>
  </v-navigation-drawer>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useAppStore} from "@/store/app";

export default {
  name: "SlideBar",
  data: () => ({
    // ... mapState(useAppStore),
    appStore: useAppStore(),
    group: null,
    items: [
      {
        title: 'Foo',
        value: 'foo',
      },
      {
        title: 'Bar',
        value: 'bar',
      },
      {
        title: 'Fizz',
        value: 'fizz',
      },
      {
        title: 'Buzz',
        value: 'buzz',
      },
    ],
  }),
  computed: {
    drawer(){
      return this.appStore.slideBarVisible
    }
  },
  methods: {
    // ...mapActions(useAppStore)
  },

  watch: {
    group () {
      this.drawer = false
    },
  },
}

</script>

<style scoped>

</style>
