<template>
  <v-toolbar
      color="blue darken-3"
      dark
      app
      :clipped-left="$vuetify.breakpoint.mdAndUp"
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon v-if="authenticated" @click.stop="toggleDrawer"></v-toolbar-side-icon>
        <router-link :to="{ name: 'home' }" class="white-text">
          {{ appName }}
        </router-link>
      </v-toolbar-title>
      <v-spacer></v-spacer>

      <!-- Authenticated -->
      <template v-if="authenticated">
        <v-btn flat :to="{ name: 'users' }">{{ user.name }}</v-btn>
        <v-btn flat @click.prevent="logout" class="btn__icon">{{ $t('logout') }}</v-btn>
      </template>

      <!-- Guest -->
      <template v-else>
        <v-btn flat :to="{ name: 'login' }">{{ $t('login') }}</v-btn>
        <v-btn flat :to="{ name: 'register' }">{{ $t('register') }}</v-btn>
      </template>
    </v-toolbar>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props: {
    drawer: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      appName: window.config.appName,  
      busy: false,
    };
  },
  computed: mapGetters({
    user: 'authUser',
    authenticated: 'authCheck'
  }),
  methods: {
    toggleDrawer() {
      this.$emit('toggleDrawer')  
    },
    async logout() {
      this.busy = true
      if (this.drawer) {
        this.toggleDrawer()
      }
      // 登出使用者
      await this.$store.dispatch('logout');
      this.busy = false
      // 導入到登入頁面
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
  .white-text {
    color: #ffffff;
    text-decoration: none;
  }
  .btn__icon {
    padding-top: 0px;
  }
</style>
