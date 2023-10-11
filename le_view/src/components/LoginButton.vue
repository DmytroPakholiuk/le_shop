<template>
  <div class="container">
    <button @click="login">Login</button>
  </div>
</template>

<script>
import crypto from 'crypto-js';
import {useAuthStore} from "@/store/auth";
import {useAppStore} from "@/store/app";

export default {
  data() {
    return {
      appStore: useAppStore(),
      authStore: useAuthStore(),
      email: '',
      password: '',
      state: '',
      challenge: '',
    }
  },
  computed: {
    loginUrl() {
      return this.authStore.apiUrl +
        '/oauth/authorize?client_id=' + this.authStore.clientId +
        '&redirect_uri=' + this.authStore.clientUrl + '/auth' +
        '&response_type=code' +
        '&scope=*' +
        '&state=' + this.state +
        '&code_challenge=' + this.challenge +
        '&code_challenge_method=S256'
    }
  },

  mounted() {
    window.addEventListener('message', (e) => {
      console.log(e.data.data)
      if (e.origin !== this.authStore.clientUrl || ! Object.keys(e.data.data).includes('access_token')) {
        return;
      }

      const {token_type, expires_in, access_token, refresh_token} = e.data.data;
      console.log(e.data.data)
      // axios.setToken(access_token, token_type);

      this.authStore.axios.defaults.headers.common['Authorization'] = "Bearer " + access_token;
      this.authStore.accessToken = access_token;
      this.authStore.tokenType = token_type;
      this.authStore.tokenExpiresIn = expires_in;
      this.authStore.refreshToken = refresh_token;
      this.authStore.isAuthenticated = true;

      this.authStore.axios.get( this.authStore.apiUrl + '/api/user', {
        headers: {
          // "Authorization": "Bearer " + access_token
        }
      }).then(resp => {
          console.log(resp);
      })
    });

    // if (! window.localStorage.getItem('state') || ! window.localStorage.getItem('verifier')){
    //
    //   this.state = this.createRandomString(40);
    //   const verifier = this.createRandomString(128);
    //
    //   console.log(this.state)
    //
    //   this.challenge = this.base64Url(crypto.SHA256(verifier));
    //   window.localStorage.setItem('state', this.state);
    //   window.localStorage.setItem('verifier', verifier);
    // }

  },

  methods: {
    login() {
      this.state = this.createRandomString(40);
      const verifier = this.createRandomString(128);


      this.challenge = this.base64Url(crypto.SHA256(verifier));
      // window.localStorage.setItem('state', this.state);
      // window.localStorage.setItem('verifier', verifier);
      //
      // console.log(this.state)
      // console.log(window.localStorage.getItem('state'))

      window.state = this.state
      window.verifier = verifier

      this.openLoginWindow();
    },

    openLoginWindow() {
      window.open(this.loginUrl, 'popup', 'width=700,height=700');
    },

    createRandomString(num) {
      return [...Array(num)].map(() => Math.random().toString(36)[2]).join('')
    },

    base64Url(string) {
      return string.toString(crypto.enc.Base64)
        .replace(/\+/g, '-')
        .replace(/\//g, '_')
        .replace(/=/g, '');
    }
  },

  name: "LoginButton"
}
</script>

<style scoped>
  button {
    margin: 15px
  }
</style>
