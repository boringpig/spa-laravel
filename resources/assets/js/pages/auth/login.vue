<template>

<v-layout align-center justify-center>
  <v-flex xs12 sm10 md6>
    <v-card class="elevation-12">
      <form @submit.prevent="login">
        <v-toolbar dark color="primary">
          <v-toolbar-title>{{ $t('admin-login') }}</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-text-field prepend-icon="person" name="username" 
            :label="$t('username')" 
            type="text" 
            v-model="form.username"
            required
            v-validate="'required'"
            :error-messages="errors.collect('username')"
          >
          </v-text-field>
          <v-text-field prepend-icon="lock" name="password" 
            :label="$t('password')" 
            type="password" 
            v-model="form.password"
            required
            v-validate="'required|min:6'"
            :error-messages="errors.collect('password')"
          >
          </v-text-field>
          <v-btn block class="submit__button" color="primary" type="submit">
            {{ $t('login') }}
          </v-btn>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <!-- <v-btn color="primary" 
            class="submit__button"
          >
            {{ $t('login') }}
          </v-btn> -->
        </v-card-actions>
      </form>
    </v-card>
  </v-flex>
</v-layout>

</template>

<script>
import axios from 'axios';
  export default {
    data() {
      return {
        valid: false,
        form: {
          username: '',
          password: ''
        },
      };
    },
    methods: {
      login() {
        this.$validator.validate().then(result => {
          if(result) {
            axios.post('/api/login', this.form).then(response => {
              console.log(response);
            });
          }
        });
      }
    }
  }
</script>

<style scoped>
  .submit__button {
    padding-top: 0px;
    font-size: 16px;
  }
</style>