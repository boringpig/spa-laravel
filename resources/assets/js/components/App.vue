<template>
  <v-app light>
    <!-- 左側選單 -->
    <v-navigation-drawer
      v-if="authenticated"
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
    <!-- 訊息框 -->
    <feed-back-message></feed-back-message>
  </v-app>
</template>

<script>
import NavMenu from './NavMenu'
import ToolBar from './ToolBar'
import PageFooter from './PageFooter'
import FeedBackMessage from './FeedBackMessage'
import { mapGetters } from 'vuex'

export default {
  components: {
    'nav-menu': NavMenu,
    'tool-bar': ToolBar,
    'page-footer': PageFooter,
    'feed-back-message': FeedBackMessage
  },

  computed: mapGetters({
    authenticated: 'authCheck'
  }),

  data () {
    return {
      drawer: true
    }
  }
}
</script>
