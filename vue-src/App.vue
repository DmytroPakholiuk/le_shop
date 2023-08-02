<template>
    <div>
        <h1>{{ text }}</h1>
      <image-fitter :image="image"></image-fitter>
    </div>
</template>

<script>
import ImageFitter from "./ImageFitter.vue";

export default {
  name: "App",
  components: {ImageFitter},
  data: function () {
    return {
      text: 'This part of application is rendered in Vue.',

      image: null,
    }
  },

  created() {
    let vue;
    vue = this;
    fetch('/goods/get-main-goods-thumbnail?' + new URLSearchParams({
      id: 28
    })).then(response => response.json()).then(function (img){
      vue.image = img;
    })
  }
}
</script>

<style scoped>

</style>