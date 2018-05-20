<template>
  <v-layout row justify-center>
    <v-dialog v-if="responseMessage.modal" :value.sync="responseMessage.show" persistent max-width="350">
      <v-card>
        <v-card-title class="headline white--text" :class="responseMessage.type">{{ responseMessage.title }}</v-card-title>
        <v-card-text>{{ responseMessage.text }}</v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn :color="responseMessage.type" flat @click.native="close">{{ $t('ok') }}</v-btn>
          </v-card-actions>
      </v-card>
    </v-dialog>
    <v-snackbar v-else top v-model="responseMessage.show" :color="responseMessage.type">
      {{ responseMessage.text }}
      <v-btn dark flat @click.native="close">{{ $t('close') }}</v-btn>
    </v-snackbar>
  </v-layout>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: mapGetters([
    'responseMessage'
  ]),
  methods: {
    close () {
      this.$store.dispatch('clearMessage')
    }
  }
}
</script>