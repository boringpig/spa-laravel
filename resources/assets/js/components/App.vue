<template>
  <v-app light>
    <!-- 左側選單 -->
    <v-navigation-drawer
      fixed
      :clipped="$vuetify.breakpoint.mdAndUp"
      app
      v-model="drawer"
    >
      <nav-menu></nav-menu>
    </v-navigation-drawer>
    <!-- 頁首 -->
    <tool-bar @toggleDrawer="drawer = !drawer" :drawer="drawer"></tool-bar>
    <!-- 主內容 -->
    <v-content>
      <v-container grid-list-xl fluid>
        <router-view></router-view>
      </v-container>
    </v-content>
    <!-- 頁尾 -->
    <page-footer></page-footer>
  </v-app>
</template>

<script>
import NavMenu from './NavMenu'
import ToolBar from './ToolBar'
import PageFooter from './PageFooter'

export default {
  components: {
    'nav-menu': NavMenu,
    'tool-bar': ToolBar,
    'page-footer': PageFooter
  },

  // computed: mapGetters({
  //   authenticated: 'authCheck'
  // }),

  data () {
    return {
      drawer: true
    }
  }
}
</script>
