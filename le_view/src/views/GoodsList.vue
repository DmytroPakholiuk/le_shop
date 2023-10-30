<template>
  <v-container>
    <div class="text-center">
      <h1>Goods List</h1>
    </div>
    <v-divider />
    <goods-card v-for="goodsItem in goodsItems"
      :key="goodsItem.id"
      :goods="goodsItem"
    />
  </v-container>
</template>

<script>
import {useAuthStore} from "@/store/auth";
import GoodsCard from "@/components/GoodsCard.vue";

export default {
  components: {GoodsCard},
  data: () => ({
    authStore: useAuthStore(),
    page: "",
    goodsItems: []
  }),
  name: "GoodsList",
  mounted() {
    this.authStore.axios.get(this.authStore.apiUrl + "/api/goods", {
      headers: {
        "Authorization": "Bearer " + this.authStore.accessToken
      }
    }).then(resp => {
      this.goodsItems = resp.data.data
    })
  }
}
</script>

<style scoped>

</style>
