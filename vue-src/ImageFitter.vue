<template>
  <img
      :src="image.uri"
      :alt="'image #' + image.id"
      :height="newHeight"
      :width="newWidth"
      :class="{
        'image-border': true
      }"
  >
</template>

<script>
export default {
  name: "ImageFitter",

  data: function () {
    return {
      imgHeight: '',
      imgWidth: ''
    }
  },

  computed: {
    newHeight()
    {
      if (this.imgHeight / this.fitHeight > this.imgWidth / this.imgWidth){
        return this.fitHeight;
      }
      return this.fitHeight * ((this.imgHeight / this.fitHeight) / (this.imgWidth / this.fitWidth));
    },
    newWidth()
    {
      if (this.imgHeight / this.fitHeight < this.imgWidth / this.imgWidth){
        return this.fitWidth;
      }
      return this.fitWidth * ((this.imgWidth / this.fitWidth) / (this.imgHeight / this.fitHeight));
    }
  },

  props: {
    fitHeight: {
      type: Number,
      default: 200
    },
    fitWidth: {
      type: Number,
      default: 200
    },
    image: Object
  },

  created() {
    this.imgHeight = this.image.height;
    this.imgWidth = this.image.width;
  }
}
</script>

<style scoped>
  .image-border {
    margin: 3px;
    background-color: red;
  }
</style>