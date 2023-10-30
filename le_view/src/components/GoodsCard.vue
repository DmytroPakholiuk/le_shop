<template>
  <v-card class="card-margin">
    <div class="v-row">
      <div class="v-col">
        <v-card-title>
          {{goods.name}}
        </v-card-title>

        <v-card-item>
          {{goods.description}}
        </v-card-item>
      </div>

      <div class="v-col">
        <v-card-item>
          <div v-if="goods.available" class="text-right">
            In stock
          </div>
          <div v-else class="text-right">
            Out of stock
          </div>
        </v-card-item>

        <v-card-item class="text-right">
          <b>${{goods.price}}</b>
        </v-card-item>
      </div>
    </div>

    <v-card-item>
      <v-img
        class="mx-auto"
        src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png"
      />
    </v-card-item>

    <v-card-actions>
      <div class="d-flex mb-6">
        <router-link class="justify-content-start" :to="'goods/' + goods.id">
          <v-btn>
            view
          </v-btn>
        </router-link>
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
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props: {
    goods: Object
  },
  data: () => ({

  }),
  name: "GoodsCard"
}
</script>

<style scoped>
  .card-margin {
    margin: 30px
  }
</style>
