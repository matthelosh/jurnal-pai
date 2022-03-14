<template>
    <dash-layout :pageTitle="'Kalender Pendidikan'">
      <v-toolbar>
        <v-icon>mdi-calendar</v-icon>
        Kalender Pendidikan {{ $page.props.periode.tapel }}
      </v-toolbar>
      <v-container>
        <v-row>
          <v-col v-for="bulan in bulans" :key="bulan" cols="12" sm="4">
            <v-card>
              <v-card-text>
                <h3><v-icon>mdi-calendar</v-icon>{{ months[bulan-1] }} {{( parseInt(bulan) > 6) ? $page.props.periode.tapel.split('-')[0] : $page.props.periode.tapel.split('-')[1]}}</h3>
                <v-divider class="my-3"></v-divider>
                <v-sheet>
                  <v-calendar type="month" locale="id" :start="( parseInt(bulan) > 6 ? $page.props.periode.tapel.split('-')[0] : $page.props.periode.tapel.split('-')[1])+'-'+bulan+'-'+'01'" @click:date="addEvent" :now="sekarang" :events="events" @click:event="showEvent" color="primary" show-week >
                  </v-calendar>
                </v-sheet>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
      <v-navigation-drawer right v-model="selectedOpen" app temporary width="350">
        <v-toolbar dense :color="selectedEvent.color" dark> Agenda</v-toolbar>
        <v-container>
          <v-list>
            <v-list-item>
              <v-list-item-icon><v-icon>mdi-text</v-icon></v-list-item-icon>
              <v-list-item-title class="text-wrap"> 
                <span v-if="!editEvent">
                  {{selectedEvent.name}}
                </span>
                <v-text-field v-else label="Nama Kegiatan" v-model="selectedEvent.name" auto-grow outlined dense hide-details></v-text-field>
              </v-list-item-title>
                
            </v-list-item>
            <v-list-item>
              <v-list-item-icon><v-icon>mdi-clock-outline</v-icon></v-list-item-icon>
              <v-list-item-title class="text-wrap">
                
                  {{selectedEvent.start}} s/d <v-text-field type="date" v-model="selectedEvent.end" outlined dense label="Selesai"></v-text-field>
                
              </v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-icon><v-icon>mdi-map-marker</v-icon></v-list-item-icon>
              <v-list-item-title class="text-wrap"> 
                <span v-if="!editEvent">
                  {{selectedEvent.location}}
                </span>
                <v-textarea v-else label="Lokasi" v-model="selectedEvent.location" auto-grow rows="1" outlined dense hide-details></v-textarea>
              </v-list-item-title>
                
            </v-list-item>
            <v-list-item>
              <v-list-item-icon><v-icon>mdi-calendar-text-outline</v-icon></v-list-item-icon>
              <v-list-item-title class="text-wrap">
                
                <span v-html="selectedEvent.detail" v-if="!editEvent"></span>
                <v-textarea v-else label="Detail" v-model="selectedEvent.detail" auto-grow rows="1" outlined dense hide-details></v-textarea>
                </v-list-item-title>
            </v-list-item>
          </v-list>
          <v-expand-transition>
            <v-row v-if="editEvent">
              <v-col>
                <v-color-picker v-model="selectedEvent.color" hide-mode-switch  hide-inputs  ></v-color-picker>
              </v-col>
            </v-row>
          </v-expand-transition>
          <v-divider class="my-2"></v-divider>
          <v-row>
            <v-col class="d-flex justify-center">
              <v-btn rounded color="warning" dark small @click="editEvent = !editEvent" class="mx-1"><v-icon>mdi-pencil</v-icon> Edit</v-btn>
              <v-btn rounded color="error" dark small @click="hapusEvent" class="mx-1"><v-icon>mdi-delete</v-icon> Hapus</v-btn>
              <v-btn rounded small color="primary" class="mx-1" @click="simpanEvent"><v-icon>mdi-content-save</v-icon> Simpan</v-btn>
            </v-col>
          </v-row>
        </v-container>
      </v-navigation-drawer>
    </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
export default {
    name: 'GuruKaldik',
    props: { errors: Object },
    components: { DashLayout },
    data: () => ({
      editEvent: false,
      kaldik: null,
      bulans: [7,8,9,10,11,12,1,2,3,4,5,6],
      months: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
      events: {
        
      },
      selectedOpen: false,
      selectedEvent: {
        color: '#567898'
      },
      selectedElement: null
    }),
    methods: {
      simpanEvent(){
        axios({
          method: 'post',
          url: '/guru/kaldik/store?guruId='+this.$page.props.user.userable_id+'&tapel='+this.$page.props.periode.kode_periode.substr(0,4),
          data: this.selectedEvent
        }).then(res => {
          let month = this.selectedEvent.start.substr(5,2)
          this.events[month] = []
          this.events[month].push(this.selectedEvent)
          this.selectedEvent = {}
          this.selectedOpen = false
          this.getKaldiks()
        })
      },
      hapusEvent() {
        alert(this.selectedEvent.id)
      },
      addEvent(e){
        // console.log(e)
        this.selectedEvent = { start: e.date, end: e.date}
        this.selectedOpen = true
        this.editEvent = true
      },
      showEvent({nativeEvent, event}) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          requestAnimationFrame(() => requestAnimationFrame(() => open()))
        } else {
          open()
        }

        // nativeEvent.stopPropagation()
      },
      getKaldiks() {
        axios({
          method: 'post',
          url: '/guru/kaldik/'+this.$page.props.periode.kode_periode.substr(0,4)
        }).then(res => {
          let kaldik = {}
          // res.data.kaldiks.forEach(item => {
          //   let tanggal = new Date(item.start)
          //   kaldik[tanggal.getMonth() + 1] = []
          //   if(parseInt(item.start.substr(5,2)) == (tanggal.getMonth()+1)) {
          //     kaldik[tanggal.getMonth() + 1].push(item)
          //   }

          // })
          // let tes = res.data.kaldiks.reduce((prev,current) => )
          // console.log(kaldik)
          this.events = res.data.kaldiks
        })
      }
    },
    computed: {
        route() {
            return window.route
        },
        sekarang(){
          const date = new Date()
          return date.toISOString().substr(0,10)
        },

        
        // months() {
        //   const months = []
        //   Object.keys(this.kaldik).forEach(bulan => {
        //     months.push(bulan)
        //   })
        //   return months
        // }
    },
    created() {
      this.getKaldiks()
    }
}
</script>

<style scoped>
  .bg-red {
    background: red;
    color: white;
  }
</style>