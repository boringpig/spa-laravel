<template>
  <v-layout align-center justify-center>
    <v-flex xs12 sm10 md6>
      <v-card class="elevation-12">
        <form @submit.prevent="register">
          <v-toolbar dark color="primary">
            <v-toolbar-title>{{ $t('admin-register') }}</v-toolbar-title>
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
            <!-- 信箱 -->
            <v-text-field prepend-icon="email" name="email" 
              :label="$t('email')" 
              type="text" 
              v-model="form.email"
              required
              v-validate="'required|email'"
              :error-messages="errors.collect('email')"
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
            <!-- 確認密碼 -->
            <v-text-field prepend-icon="lock" name="password_confirm" 
              :label="$t('password-confirm')" 
              type="password" 
              v-model="form.password_confirmation"
              v-validate="'confirmed:password'"
              :error-messages="errors.collect('password_confirm')"
            >
            </v-text-field>
            <!-- 註冊 -->
            <v-btn block class="submit__button" color="primary" type="submit">
              {{ $t('register') }}
            </v-btn>
          </v-card-text>
        </form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      form: {
        username: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      busy: false
    };
  },
  methods: {
    async register() {
      if(await this.$validator.validate()) {
        this.busy = true
        // 會員註冊
        const { data } = await this.axios.post('/api/register', this.form)

        // 存入token
        this.$store.dispatch('saveToken', {
          token: data.token,
          remember: true,
        })

        // 存入user
        this.$store.dispatch('updateUser', {
          user: data.user
        })

        this.busy = false
        // 導入後台首頁
        this.$router.push({ name: 'home'});
      }
    }
  }
}
</script>

<style>

</style>
