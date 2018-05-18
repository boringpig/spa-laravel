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
            <!-- 帳號 -->
            <v-text-field prepend-icon="person" name="username" 
              :label="$t('username')" 
              type="text" 
              v-model="form.username"
              required
              v-validate="'required'"
              :error-messages="errors.collect('username')"
            >
            </v-text-field>
            <!-- 密碼 -->
            <v-text-field prepend-icon="lock" name="password" 
              :label="$t('password')" 
              type="password" 
              v-model="form.password"
              required
              v-validate="'required|min:6'"
              :error-messages="errors.collect('password')"
            >
            </v-text-field>
            <!-- 記住我 -->
            <v-checkbox
              :label="$t('remember-me')"
              color="primary"
              type="checkbox"
              v-model="remember"
              value="true"
            ></v-checkbox>
            <!-- 登入 -->
            <v-btn block class="submit__button" color="primary" type="submit">
              {{ $t('login') }}
            </v-btn>
          </v-card-text>
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
        remember: false,
        busy: false,
      };
    },
    methods: {
      async login() {
        if(await this.$validator.validate()) {
          this.busy = true;

          // 登入取得token
          const { data } = await axios.post('/api/login', this.form);

          // 存token到vuex
          this.$store.dispatch('saveToken', {
            token: data.token,
            remember: this.remember
          });

          // 取得該使用者
          await this.$store.dispatch('fetchUser');
          this.busy = false;
          // 導入後台首頁
          // this.$router.push({ name: 'home'});
        }
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