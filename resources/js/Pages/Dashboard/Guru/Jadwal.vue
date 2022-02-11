<template>
  <dash-layout>
    <div>
      <v-toolbar>
        <v-btn icon @click="sidebar = !sidebar"><v-icon>mdi-menu</v-icon></v-btn>
      </v-toolbar>
      <v-container>
        <v-col>
          <v-card>
            <v-card-text>
              <v-card-title>
                <v-icon>mdi-calendar-check</v-icon>  Agenda Mengajar 
                <v-spacer></v-spacer>
                <v-btn  outlined icon @click="$refs.calendar.prev()"><v-icon>mdi-chevron-left</v-icon></v-btn>
            
                <v-btn  outlined icon @click="$refs.calendar.next()"><v-icon>mdi-chevron-right</v-icon></v-btn>
              </v-card-title>
              <v-calendar locale="id" :first-interval="10" :interval-minutes="35" :interval-count="10" @click:date="tes" :weekdays="[1,2,3,4,5,6]" :max-days="6" :type="type" v-model="selectedDate" @click:time="timeClicked" ref="calendar">
                <template v-slot:event="{ event }">
                    {{ event.moreInformation }}
                </template>
              </v-calendar>
            </v-card-text>
          </v-card>
        </v-col>
      </v-container>
    </div>
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
import 'vue-daily-scheduler/dist/vue-schedule.min.css'
import VueSchedule from 'vue-daily-scheduler'
export default {
  name: 'GuruRombel',
  components: { DashLayout,VueSchedule },
  data: () => ({
    jadwals: '',
    headers: [
      { text: 'Jam ke'}
    ],
    jadwal: '',
    type: 'month',
    selectedDate: '',
    agenda: {
      tanggal: '',
      waktu: '',
      hari: ''
    },
    rombels: [
      { text: 'Kelas 1', value: 'i' },
      { text: 'Kelas 2', value: 'ii'},
      { text: 'Kelas 3', value: 'iii'},
      { text: 'Kelas 4', value: 'iv'},
      { text: 'Kelas 5', value: 'v'},
      { text: 'Kelas 6', value: 'vi'},
    ]
  }),
  methods: {
    tes(e) {
      this.selectedDate = e.date
      this.agenda.tanggal = e.date
      this.type="day"
    },
    timeClicked(e){
      alert(e.time)
      this.agenda.waktu = e.time
    }
  }
}
</script>

<style scoped>
  table {
    border-collapse: collapse;
  }
</style>