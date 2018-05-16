<template>
  <v-toolbar
      color="blue darken-3"
      dark
      app
      :clipped-left="$vuetify.breakpoint.mdAndUp"
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="toggleDrawer"></v-toolbar-side-icon>
        <router-link :to="{ name: 'welcome' }" class="white-text">
          {{ appName }}
        </router-link>
      </v-toolbar-title>
      <v-spacer></v-spacer>

      <!-- Authenticated -->
      <template v-if="authenticated">
        <v-btn flat :to="{ name: 'settings.profile' }">{{ user.name }}</v-btn>
        <v-btn flat @click.prevent="logout">登出</v-btn>
      </template>

      <!-- Guest -->
      <template v-else>
        <v-btn flat :to="{ name: 'login' }">{{ $t('login') }}</v-btn>
        <v-btn flat :to="{ name: 'register' }">{{ $t('register') }}</v-btn>
      </template>
    </v-toolbar>
</template>

<script>
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
      authenticated: false,
    };
  },
  methods: {
    toggleDrawer() {
      this.$emit('toggleDrawer')  
    }
  }
}
</script>

<style scoped>
  .white-text {
    color: #ffffff;
    text-decoration: none;
  }
  .btn--icon {
    padding-top: 0px;
  }
</style>
