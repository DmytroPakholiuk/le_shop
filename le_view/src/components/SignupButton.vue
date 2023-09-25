<template>
  <div class="container">
    <button @click.prevent="openSignupWindow">Signup</button>
  </div>
</template>

<script>
import crypto from 'crypto-js';
import axios from "axios";

export default {
  data() {
    return {
      email: '',
      password: '',
      state: '',
      challenge: '',
    }
  },
  computed: {
    loginUrl() {
      return 'http://api.le.shop:20080/oauth/authorize?client_id=4' +
        '&redirect_uri=http://view.le.shop:23000/auth' +
        '&response_type=code' +
        '&scope=*' +
        '&state=' + this.state +
        '&code_challenge=' + this.challenge +
        '&code_challenge_method=S256'
    }
  },

  mounted() {
    window.addEventListener('message', (e) => {
      if (e.origin !== 'http://view.le.shop:23000' || ! Object.keys(e.data).includes('access_token')) {
        return;
      }

      const {token_type, expires_in, access_token, refresh_token} = e.data;
      axios.setToken(access_token, token_type);

      axios.get('http://api.le.shop/api/user')
        .then(resp => {
          console.log(resp);
        })
    });

    this.state = this.createRandomString(40);
    const verifier = this.createRandomString(128);

    this.challenge = this.base64Url(crypto.SHA256(verifier));
    window.localStorage.setItem('state', this.state);
    window.localStorage.setItem('verifier', verifier);
  },

  methods: {
    openSignupWindow() {
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

  name: "SignupButton"
}
</script>

<style scoped>
  button {
    margin: 15px
  }
</style>
