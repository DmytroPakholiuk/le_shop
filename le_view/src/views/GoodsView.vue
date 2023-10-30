<template>
  <v-container>
    <div class="v-row">
      <div class="v-col">
        <div>
          <h1>{{goods.name}}</h1>
        </div>
        <div class="price-style">
          <b>${{goods.price}}</b>
        </div>
        <div>
          {{goods.description}}
        </div>
        <div>
          <v-btn class="justify-content-end">
            buy
          </v-btn>
          <v-btn class="justify-contend-end">
            <v-icon
              color="success"
              icon="mdi-star"
            />
          </v-btn>
        </div>
        <div v-for="attribute in attributes" :key="attribute.id">
          {{attribute.name}} : {{attribute.presentableValue}}
        </div>
      </div>
      <div class="v-col">
        <v-img class="mx-auto"
               src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png"
        />
      </div>
    </div>
  </v-container>
</template>

<script>
import {useAuthStore} from "@/store/auth";

export default {
  data: () => ({
    authStore: useAuthStore(),
    goods: {},
    attributes: {},
  }),

  methods: {
    fetchGoods(id)
    {
      this.authStore.axios.get(this.authStore.apiUrl + "/api/goods/" + id, {
        headers: {
          Authorization: "Bearer " + this.authStore.accessToken
        }
      }).then(resp => {
        this.goods = resp.data.data
        this.fetchGoodsAttributes(id)
      })
    },

    fetchGoodsAttributes(goodsId)
    {
      this.authStore.axios.get(this.authStore.apiUrl + "/api/goods/" + goodsId + "/attributes", {
        headers: {
          Authorization: "Bearer " + this.authStore.accessToken
        }
      }).then(resp => {
        this.attributes = this.deleteEmptyAttributes(resp.data.data);
      })
    },

    deleteEmptyAttributes(attributeArray)
    {
      for (const attributeIndex in attributeArray) {
        if (attributeArray[attributeIndex] === null){
          delete attributeArray[attributeIndex];
        }
      }

      return attributeArray;
    }
  },

  mounted() {
    this.$watch(
      () => this.$route.params,
      (toParams, previousParams) => {
        // react to route changes...
        this.fetchGoods(toParams.id)
      }
    )

    this.fetchGoods(this.$route.params.id)
    // this.inputData.id = this.$route.params.id

    // this.authStore.axios.post(this.authStore.apiUrl + "/api/goods/31/attributes", {
    //   attribute_id: 5,
    //   goods_id: 31,
    //   value: 3
    // }, {
    //   headers: {
    //     Authorization: "Bearer " + this.authStore.accessToken
    //   }
    // }).then(resp => {
    //   console.log(resp)
    // })
  },
  name: "GoodsView"
}
</script>

<style scoped>
  .price-style {
    color: green;
  }

  button {
    margin: 10px
  }
</style>
