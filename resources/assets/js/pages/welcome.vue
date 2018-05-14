<template>
  <div>
    <v-layout row wrap>
      <v-flex xs10 offset-xs1>
        <v-card dark color="purple">
          <v-card-text>xs10 offset-xs1</v-card-text>
        </v-card>
      </v-flex>

      <v-flex xs5 offset-xs3>
        <v-card>
          <v-card-title primary-title class="grey lighten-4">
            <h3 class="headline mb-0">Hello</h3>
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            World
          </v-card-text>
        </v-card>    
      </v-flex>  

    </v-layout>
  </div>
</template>

<script>
export default {

}
</script>
