<template>
  <v-form>
    <v-container>
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            hide-details
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="password"
            type="password"
            :rules="passwordRules"
            label="Password"
            hide-details
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4">
          <v-btn @click="sendLogin">
<!--            :href="this.authStore.apiUrl + '/login'">-->
            Login
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
import {useAuthStore} from "@/store/auth";
import axios from "axios";

export default {
  data: () => ({
    authStore: useAuthStore(),
    password: '',
    passwordRules: [
      value => {
        if (value) {
          return true
        }

        return "Password is required"
      },
    ],

    email: '',
    emailRules: [
      value => {
        if (value) return true

        return 'E-mail is required.'
      },
      value => {
        if (/.+@.+\..+/.test(value)) return true

        return 'E-mail must be valid.'
      },
    ],
  }),
  computed: {
    authUrl() {
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
  methods: {
    sendLogin(){
      axios.post(
        this.authStore.apiUrl + "/login",
        {
          email: this.email,
          password: this.password,
          redirect: this.authUrl
        },
        {
          "headers": {
            // "Content-Type": "multipart/form-data"
            // "Access-Control-Allow-Origin": "*"
          }
        }
      )
    }
  },
  name: "Login"
}
</script>

<style scoped>

</style>
