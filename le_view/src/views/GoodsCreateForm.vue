<template>
  <v-form>
    <v-text-field
      name="name"
      label="Name"
      :rules="inputRules.nameRules"
      v-model="inputData.name"
    />

    <v-textarea
      name="description"
      label="Description"
      v-model="inputData.description"
    />

    <v-text-field
      name="price"
      label="Price"
      v-model="inputData.price"
      :rules="inputRules.priceRules"
    />

    <v-select
      name="available"
      label="Is available?"
      :items="inputData.availableVariants"
      v-model="inputData.available"
      item-title="valueText"
      item-value="valueBool"

    />

    <v-text-field
      v-model="inputData.category_id"
      name="category_id"
      label="Category Id"

    />

    <v-btn @click="sendData" text="Submit"/>
  </v-form>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    inputData: {
      id: 0,
      name: "",
      description: "",
      price: "",
      available: {valueText: "Yes", valueBool: 1},
      availableVariants: [
        {valueText: "No", valueBool: 0},
        {valueText: "Yes", valueBool: 1}
      ],
      // todo: think how to get such bool values more reusable
      category_id: "",
      author_id: "",
    },

    inputRules: {
      nameRules: [
        value => {
          if (value) return true

          return 'Name is required.'
        }
      ],
      priceRules: [
        value => {
          if (value) return true

          return 'Price is required.'
        },
        value => {
          if (/^\s*[0-9]+\.?[0-9]{0,2}\s*$/.test(value)){
            return true
          }

          return "Price should be a decimal number, with 2 digits after point delimiter"
        }
      ],
      availableRules: [
        value => {
          if (value) return true

          return 'Availability info is required.'
        }
      ],
    }
  }),
  methods: {
    sendData(){
      let data = {
        // id: this.inputData.id,
        name: this.inputData.name,
        description: this.inputData.description,
        price: this.inputData.price,
        available: this.inputData.available.valueBool,
        category_id: this.inputData.category_id
      }
      axios.post("http://api.le.shop:20080/api/goods", data,
        {
          // we should include the auth token here. But also better todo send the auth header all the time
        }).then(resp => {
          console.log(resp)
      })
    }
  },
  name: "GoodsCreateForm"
}
</script>

<style scoped>

</style>
