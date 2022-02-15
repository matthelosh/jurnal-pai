<template>
  <dash-layout :pageTitle="'Perangkat'">
    <v-toolbar>
      <v-toolbar-title>Perangkat</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn rounded class="mx-2" color="btnPrimary" dark @click="show = 'kaldik'">Kaldik</v-btn>
      <v-btn rounded class="mx-2" color="btnPrimary" dark @click="show = 'pembelajaran'">Pembelajaran</v-btn>
      <v-btn rounded class="mx-2" color="btnPrimary" dark @click="show = 'kikd'">KI/KD</v-btn>
      <v-btn rounded class="mx-2" color="btnPrimary" dark @click="show = 'silabus'"> Silabus</v-btn>
    </v-toolbar>
    <v-expand-transition>
      <silabus v-if="show=='silabus'"></silabus>
    </v-expand-transition>
    
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
import Silabus from './Components/Silabus'
export default {
  components: {DashLayout, Silabus},
  data: () => ({
    show: ''
  })
}
</script>