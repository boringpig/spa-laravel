<template>
  <div>
    <!-- 選單內容 -->
    <v-list>
        <template v-for="item in items">
          <v-list-group
            v-if="item.children"
            v-model="item.model"
            :key="item.title"
            :prepend-icon="item.model ? item.icon : item.icon_alt"
            append-icon=""
          >
            <v-list-tile slot="activator">
              <v-list-tile-content>
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <!-- 二級選單 -->
            <v-list-tile
              v-for="(child, i) in item.children"
              :key="i"
            >
              <v-list-tile-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>{{ child.title }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list-group>
          <!-- 沒有子選單  -->
          <v-list-tile v-else 
            value="true" 
            :key="item.title"
            :to="item.route"
          >
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title v-text="item.title"></v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
  </div>
</template>

<script>
export default {
  data () {
    return {
      name: 'nav_menu_title',
      items: [
        { title: 'Dashboard', icon: 'dashboard', route: { name: 'home' } },
        { title: 'Account', icon: 'account_box', route: { name: 'settings.profile' } },
        { title: 'More', icon: 'keyboard_arrow_up', icon_alt: 'keyboard_arrow_down',
          model: false,
          children: [
            { icon: 'contacts', title: 'Contacts' },
            { icon: 'history', title: 'Frequently contacted' },
            { icon: 'content_copy', title: 'Duplicates' },
          ]
        },
      ]
    }
  }
}
</script>