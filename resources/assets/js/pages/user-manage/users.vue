
<template>
  <v-layout align-center justify-center>
    <v-flex xs12 sm10 md9>
      <v-card>
        <v-card-title>
          使用者資料
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="headers"
          :items="users"
          :search="search"
          disable-initial-sort
        >
          <template slot="items" slot-scope="props">
            <td>{{ props.item.status }}</td>
            <td class="text-xs-right">{{ props.item.email }}</td>
            <td class="text-xs-right">{{ props.item.username }}</td>
            <td class="text-xs-right">{{ props.item.role_name }}</td>
            <td class="text-xs-right">{{ props.item.phone }}</td>
            <td class="text-xs-right">{{ props.item.updated_at }}</td>
          </template>
          <v-alert slot="no-results" :value="true" color="error" icon="warning">
            "{{ search }}"該搜尋條件無結果
          </v-alert>
        </v-data-table>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data () {
    return {
      search: '',
      headers: [
        {
          text: '狀態',
          align: 'left',
          sortable: false,
          value: 'status'
        },
        { text: '信箱', value: 'email' },
        { text: '帳號', value: 'username' },
        { text: '角色名稱', value: 'role_name' },
        { text: '手機', value: 'phone' },
        { text: '最後更新時間', value: 'updated_at' }
      ],
      users: [],
    };
  },
  methods: {
    async fetchUsers() {
      // 拿全部使用者的資料
      const { data } = await this.axios.get('/api/user-manage/users')
      this.users = data.retVal
    }
  },
  mounted() {
    this.fetchUsers();
  }
}
</script>

<style>

</style>
