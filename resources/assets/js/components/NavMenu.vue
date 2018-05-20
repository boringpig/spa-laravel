<template>
  <div>
    <!-- 選單內容 -->
    <v-list>
        <template v-for="item in items">
          <v-list-group
            v-if="item.children"
            v-model="item.model"
            :key="item.title"
          >
            <v-list-tile slot="activator">
              <v-list-tile-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>{{ $t(`${item.title}`) }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <!-- 二級選單 -->
            <v-list-tile
              v-for="(child, i) in item.children"
              value="true"
              :key="i"
              :to="child.route"
            >
              <v-list-tile-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title v-text="$t(`${child.title}`)"></v-list-tile-title>
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
              <v-list-tile-title v-text="$t(`${item.title}`)"></v-list-tile-title>
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
        { title: 'dashboard', icon: 'dashboard', route: { name: 'home' } },
        { title: 'user-manage', icon: 'people', icon_alt: 'keyboard_arrow_down',
          model: false,
          children: [
            { icon: 'arrow_right', title: 'user-data', route: { name: 'users' } },
            // { icon: 'arrow_right', title: 'role-data' , route: { name: 'roles' } },
          ]
        },
        // { title: 'advertisement-manage', icon: 'image', icon_alt: 'keyboard_arrow_down',
        //   model: false,
        //   children: [
        //     { icon: 'arrow_right', title: 'advertisement-data', route: { name: 'advertisements' } },
        //   ]
        // },
        // { title: 'kiosk-manage', icon: 'personal_video', icon_alt: 'keyboard_arrow_down',
        //   model: false,
        //   children: [
        //     { icon: 'arrow_right', title: 'kiosk-data', route: { name: 'kiosks' } },
        //     { icon: 'arrow_right', title: 'kiosk-areagroup', route: { name: 'kiosks-areagroup' } },
        //   ]
        // },
        // { title: 'article-manage', icon: 'insert_drive_file', icon_alt: 'keyboard_arrow_down',
        //   model: false,
        //   children: [
        //     { icon: 'arrow_right', title: 'article-data', route: { name: 'articles' } },
        //     { icon: 'arrow_right', title: 'category-areagroup', route: { name: 'categories' } },
        //   ]
        // },
        // { title: 'system-manage', icon: 'settings', icon_alt: 'keyboard_arrow_down',
        //   model: false,
        //   children: [
        //     { icon: 'arrow_right', title: 'system-actionlog', route: { name: 'actionlog' } },
        //     { icon: 'arrow_right', title: 'system-schedule', route: { name: 'schedule' } },
        //     { icon: 'arrow_right', title: 'system-setting', route: { name: 'setting' } },
        //   ]
        // },
      ]
    }
  }
}
</script>