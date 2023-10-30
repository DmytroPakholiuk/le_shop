<template>
  <div>
    Logging in...
  </div>
</template>

<script>
import axios from "axios"
import {useAuthStore} from "@/store/auth";

export default {
  data: () => ({
    authStore: useAuthStore()
  }),
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    const code = urlParams.get('code');
    const state = urlParams.get('state');

    if (code && state) {
      console.log(state)
      // console.log(window.opener.state)
      if (state === window.opener.state) {
        let params = {
          grant_type: 'authorization_code',
          client_id: 4,
          redirect_uri: this.authStore.clientUrl + '/auth',
          code_verifier: window.opener.verifier,
          code
        }

        axios.post('http://api.le.shop:20080/oauth/token', params)
          .then(resp => {
            resp = JSON.parse(JSON.stringify(resp))
            window.opener.postMessage(resp);
            // localStorage.removeItem('state');
            // localStorage.removeItem('verifier');
            window.close();
          })
          .catch(e => {
            console.dir(e);
          });
      }
    }
  },
  name: "Auth"
}
</script>

<style scoped>

</style>
