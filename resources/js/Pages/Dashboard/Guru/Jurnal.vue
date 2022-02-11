<template>
  <dash-layout :toolbarItems="toolbarItems">
    <div>
      <v-toolbar>
        <v-btn icon @click="sidebar = !sidebar"><v-icon>mdi-menu</v-icon></v-btn>
      </v-toolbar>
      <v-container>
        <v-col>
          Jurnal guru
        </v-col>
      </v-container>
    </div>
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
export default {
  name: 'GuruJurnal',
  components: { DashLayout },
  data: () => ({
    toolbarItems: [
      {}
    ]
  })
}
</script>