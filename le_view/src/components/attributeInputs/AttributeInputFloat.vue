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
  name: "AttributeInputFloat",

  props: {
    attribute: Object
  },

  data: () => ({
    attributeStore: useAttributeStore(),
    inputRules: [
      value => {
        if (/^\s*[0-9]+\.?[0-9]+\s*$/.test(value)){
          return true
        }

        return "This attribute should be a decimal number"
      }
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
