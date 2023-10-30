<template>
  <v-text-field
    :label="attribute.name"
    :rules="inputRules"
    v-model="attributeStore.attributes[attribute.id].value"
  />
</template>

<script>
import {useAttributeStore} from "@/store/attribute";

export default {
  name: "AttributeInputText",
  props: {
    attribute: Object
  },

  data: () => ({
    attributeStore: useAttributeStore(),
    inputRules: [

    ],
    value: ""
  }),

  mounted() {
    // this.value = this.attribute.value
  }
}
</script>

<style scoped>

</style>
