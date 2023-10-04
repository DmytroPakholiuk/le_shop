<template>
  <v-container>
    <v-row>
      <v-col
        align-self="center"
      >
        <h1><i>Oh, it appears that you either have not logged in or simply are not allowed to do this action</i></h1>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-img
          src="https://httpcats.com/401.jpg"
        />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Unauthorized"
}
</script>

<style scoped>

</style>
