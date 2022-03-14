<template>
  <dash-layout :loading="loading" :pageTitle="'<span class=\'mdi mdi-calendar\'></span> Jadwal'">
    <div>
      <v-toolbar>
        <v-btn icon @click="sidebar = !sidebar"><v-icon>mdi-menu</v-icon></v-btn>
        <v-spacer></v-spacer>
          <v-btn class="btnPrimary mr-3" dark rounded @click="cetak"> <v-icon color="white">mdi-printer</v-icon> Cetak </v-btn>
      </v-toolbar>
      <v-container>
        <v-col>
          <v-card id="jadwal">
            <v-card-title secondary-title>
                <v-icon>mdi-calendar-check</v-icon> Jadwal Mengajar Pendidikan Agama Islam {{ start }}
            </v-card-title>
            <v-card-text>
              <!-- <table border="1" width="100%" id="tableJadwal">
                <thead>
                  <tr>
                    <th>Jam Ke</th>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jumat</th>
                    <th>Sabtu</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(jadwal,i) in schedules" :key="i">
                    <td>{{jadwal.jamke}}</td>
                    <td :class="(jadwal.senin && jadwal.senin != 'Istirahat')? 'primary accent-'+jadwal.senin.kode_rombel.substr(-1): ((jadwal.senin && jadwal.senin == 'Istirahat') ? 'istirahat' : '')" @click="edit({hari: 'Senin', rombel_id: jadwal.senin ? jadwal.senin.kode_rombel:null, id: jadwal.senin ? jadwal.senin.id:null}, $event)">{{jadwal.senin ? jadwal.senin.nama_rombel: null}}</td>
                    <td :class="(jadwal.selasa && jadwal.selasa != 'Istirahat')? 'primary lighten-'+jadwal.selasa.kode_rombel.substr(-1): ((jadwal.selasa && jadwal.selasa == 'Istirahat') ? 'istirahat' : '')" @click="edit({hari:'Selasa', rombel_id:jadwal.selasa?jadwal.selasa.kode_rombel:null, id: jadwal.selasa ? jadwal.selasa.id:null},$event)">{{jadwal.selasa?jadwal.selasa.nama_rombel:null}}</td>
                    <td :class="(jadwal.rabu && jadwal.rabu != 'Istirahat')? 'primary lighten-'+jadwal.rabu.kode_rombel.substr(-1): ((jadwal.rabu && jadwal.rabu == 'Istirahat') ? 'istirahat' : '')" @click="edit({hari:'Rabu', rombel_id:jadwal.rabu?jadwal.rabu.kode_rombel:null, id: jadwal.rabu ? jadwal.rabu.id:null}, $event)">{{jadwal.rabu?jadwal.rabu.nama_rombel:null}}</td>
                    <td :class="(jadwal.kamis && jadwal.kamis != 'Istirahat')? 'primary lighten-'+jadwal.kamis.kode_rombel.substr(-1): ((jadwal.kamis && jadwal.kamis == 'Istirahat') ? 'istirahat' : '')" @click="edit({hari:'Kamis', rombel_id:jadwal.kamis?jadwal.kamis.kode_rombel:null, id: jadwal.kamis ? jadwal.kamis.id:null}, $event)">{{jadwal.kamis?jadwal.kamis.nama_rombel:null}}</td>
                    <td :class="(jadwal.jumat && jadwal.jumat != 'Istirahat')? 'primary lighten-'+jadwal.jumat.kode_rombel.substr(-1): ((jadwal.jumat && jadwal.jumat == 'Istirahat') ? 'istirahat' : '')" @click="edit({hari:'Jumat', rombel_id:jadwal.jumat?jadwal.jumat.kode_rombel:null, id: jadwal.jumat ? jadwal.jumat.id:null}, $event)">{{jadwal.jumat ? jadwal.jumat.nama_rombel:null}}</td>
                    <td :class="(jadwal.sabtu && jadwal.sabtu != 'Istirahat')? 'primary lighten-'+jadwal.sabtu.kode_rombel.substr(-1): ((jadwal.sabtu && jadwal.sabtu == 'Istirahat') ? 'istirahat' : '')" @click="edit({hari:'Sabtu', rombel_id:jadwal.sabtu?jadwal.sabtu.kode_rombel:null, id: jadwal.sabtu ? jadwal.sabtu.id:null}, $event)">{{jadwal.sabtu?jadwal.sabtu.nama_rombel:null}}</td>
                  </tr>
                </tbody>
              </table> -->

              <v-calendar 
                type="week"
                :start="start"
                :end="end"
                interval-count="10" 
                interval-minutes="35"
                first-interval="0" 
                first-time="07:00"
                locale="id"
                @click:time="tes"
                :weekdays="[1,2,3,4,5,6]"
                :events="parsedEvents"
              >
                <template v-slot:day-label-header="{}" >-</template>
                <template v-slot:event="{event}">
                  <span class="text-center">
                    <h2>{{ event.mapel }}</h2>
                    <h3>{{ event.rombel }}</h3>
                  </span>
                </template>
              </v-calendar>
              <v-row class="my-5">
                <v-col class="d-flex justify-center" cols="12" sm="4">
                  <span>
                    <p class="text-center my-0">Mengetahui</p>
                    <p class="text-center">Kepala Sekolah</p>
                    <br>
                    <br>
                    <br>
                    <p class="text-center my-0"><b><u>{{ $page.props.user.userable.sekolah.nama_ks.toUpperCase() }}</u></b></p>
                    <p class="text-center my-0" >NIP. {{ $page.props.user.userable.sekolah.nip_ks }}</p>
                  </span>
                </v-col>
                <v-col class="d-flex justify-center" cols="12" sm="4"></v-col>
                <v-col class="d-flex justify-center" cols="12" sm="4">
                  <span>
                    <p class="text-center my-0">Wagir, .......................... 2022</p>
                    <p class="text-center">Guru Pendidikan Agama Islam</p>
                    <br>
                    <br>
                    <br>
                    <p class="text-center my-0"><b><u>{{ $page.props.user.userable.nama }}</u></b></p>
                    <p class="text-center my-0" >NIP. {{ $page.props.user.userable.nip }}</p>
                  </span>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-container>
      <v-dialog max-width="600" v-model="form">
        <v-card>
          <v-card-title>Pilih Kelas</v-card-title>
          <v-card-text>
            <v-form ref="formJadwal" @submit.prevent="simpan">
              <v-row>
                <v-select label="Rombel" v-model="jadwal.rombel_id  " :items="rombels" item-text="nama_rombel" item-value="kode_rombel" solo dense :rules="[v => !!v||'Pilih Kelas Dulu']"></v-select>
              </v-row>
              <v-row>
                <v-col>
                  <v-btn block color="primary" dark type="submit">Simpan</v-btn>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-dialog>
      <v-dialog v-model="selectedJadwal.show" v-if="selectedJadwal.show" max-width="600">
        <v-card>
          <v-card-title>
            Jadwal
            <v-spacer></v-spacer>
            <v-btn small fab color="error" @click="selectedJadwal={show: false, detail: {}}"><v-icon>mdi-close</v-icon></v-btn>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="6">
                <v-select :items="rombels" v-model="selectedJadwal.jadwal.rombel" item-text="nama_rombel" item-value="nama_rombel" label="Kelas"></v-select>
              </v-col>
              <v-col cols="6">
                <v-select :items="mapels" v-model="selectedJadwal.jadwal.mapel" label="Mapel"></v-select>
              </v-col>
              <v-col cols="4">
                <v-menu
                  ref="menuStart"
                  v-model="menu1"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="selectedJadwal.jadwal.start"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="selectedJadwal.jadwal.start"
                      label="Mulai"
                      readonly
                      append-icon="mdi-clock-time-four-outline"
                      v-bind="attrs"
                      v-on="on"
                      
                    ></v-text-field>
                  </template>
                  <v-time-picker v-if="menu1" v-model="selectedJadwal.jadwal.start" min="07:00" end="12:15" format="24hr" label="Mulai" @click:minute="$refs.menuStart.save(selectedJadwal.jadwal.start)"></v-time-picker>
                </v-menu>
              </v-col>
              <v-col cols="4">
                <v-menu
                  ref="menuEnd"
                  v-model="menu2"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="selectedJadwal.jadwal.end"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="selectedJadwal.jadwal.end"
                      label="Selesai"
                      readonly
                      append-icon="mdi-clock-time-four-outline"
                      v-bind="attrs"
                      v-on="on"
                      
                    ></v-text-field>
                  </template>
                  <v-time-picker v-if="menu2" v-model="selectedJadwal.jadwal.end" min="07:00" end="12:15" format="24hr" label="Mulai" @click:minute="$refs.menuEnd.save(selectedJadwal.jadwal.end)"></v-time-picker>
                </v-menu>
              </v-col>
              <v-col cols="4">
                <v-color-picker v-if="selectedJadwal.jadwal" v-model="selectedJadwal.jadwal.color" hide-inputs></v-color-picker>
              </v-col>
              <v-col cols="12">
                <v-btn @click="simpanJadwal" color="primary">Simpan</v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
import 'vue-daily-scheduler/dist/vue-schedule.min.css'
import VueSchedule from 'vue-daily-scheduler'
import moment from 'moment'
export default {
  name: 'GuruRombel',
  components: { DashLayout,VueSchedule },
  data: () => ({
    time: null,
    menu1: false,
    menu2: false,
    loading: false,
    form: false,
    jadwals: [],
    jadwal: '',
    rombels: [],
    jams: [],
    mulai: new Date().setHours(7,0),
    durasi: 35,
    interval: 10,
    rombels: [],
    mapels: ['Tematik', 'PAI', 'PJOK','IPA','IPS','MTK', 'B.IND', 'B.DAE','B.ING'],
    selectedJadwal: { show: false, detail: null},
    events: [
      {
        start: '10:20',
        end: '12:15',
        mapel: 'PAI',
        rombel: 'Kelas 1',
        hari: 1,
        color: '#789878'
      },
      {
        start: '07:00',
        end: '09:20',
        mapel: 'PAI',
        rombel: 'Kelas 2',
        hari: 2,
        color: '#98feff'
      },
    ],
    startWeek: null,
    endWEek: null
  }),
  methods: {
    simpanJadwal(){
      let jadwal = this.selectedJadwal.jadwal
      let events = this.events
      console.log(jadwal)
      events.push(jadwal)
      this.events = events
    },
    tes(e) {
      let detail = e
      let jadwal  = {
        start: e.time,
        end: '',
        mapel: '',
        rombel: '',
        color: '#897867'
      }
      this.selectedJadwal = { show: true, jadwal: jadwal}
    },
    cetak(){
      const sheet = document.querySelector('#jadwal').innerHTML
      let stylesHtml = '';
      for (const node of [...document.querySelectorAll('link[rel="stylesheet"], style')]) {
        stylesHtml += node.outerHTML;
      }
      let win = window.open('', '','left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0')
      win.document.write(`
        <!doctype html>
        <html>
          <head>
            ${stylesHtml}
            <style>
              table.kop {
                border-bottom: 5px double black;
              }
              p {
                font-size: 1em;
              }
              .isi table {
                margin-bottom: 50px;
              }
              h3,h4 {
                color: black!important;
              }
              @media print {
                @page {
                  size: 8in 13in;
                }
                .row {
                  display:block!important;
                  text-align: center;
                }
                .row div:nth-child(1){
                  width: 42%;
                  float: left;
                }
                .row div:nth-child(2){
                  float: left;
                  width: 16%;
                }
                .row div:nth-child(3){
                  width: 42%;
                  float: left;
                }

              }
            </style>
            
          </head>
          <body>
            <table width="100%" class="kop">
              <tr>
                <td>
                  <img src="/img/malangkab.png" width="100" />
                </td>
                <td style="text-align:center;">
                  <h3>PEMERINTAH KABUPATEN MALANG</h3>
                  <h3>DINAS PENDIDIKAN</h3>
                  <h4>KOORDINATOR WILAYAH DINAS PENDIDIKAN KECAMATAN WAGIR</h4>
                  <h2>${this.$page.props.user.userable.sekolah.nama_sekolah}</h2>
                  <p>${ this.$page.props.user.userable.sekolah.alamat }, Telp.: ${this.$page.props.user.userable.sekolah.telp}</p>
                  <p>, Email: ${this.$page.props.user.userable.sekolah.email}, Website: ${this.$page.props.user.userable.sekolah.website}</p>
                </td>
              </tr>
            </table>
            <div class="isi">
              ${sheet}
            </div>
          </body>
        </html>
      `)
      // win.document.close()
      setTimeout(() => {
        win.print()
      },500)
      // win.document.addEventListener("loaded", function(){
      //   win.print()
      // })
      // win.print()
      
      // win.close()
    },
    simpan(){
      if(this.$refs.formJadwal.validate()) {
        this.loading = true
        axios({
          method: 'post',
          url: '/guru/jadwal/store',
          data: this.jadwal
        }).then( res => {
          this.$refs.formJadwal.reset()
          this.form = false
          this.loading = false
          this.getJadwals()
        })
      }
    },
    edit(item, $event){
      // alert(item.hari)
      this.form = true
      this.jadwal = {
        id: item.id,
        rombel_id: item.rombel_id, 
        hari: item.hari, 
        jamke: $event.target.parentElement.firstChild.innerText,
        periode_id: this.$page.props.periode.kode_periode,
        sekolah_id: this.$page.props.user.userable.sekolah_id,
        guru_id: this.$page.props.user.userable_id
        }
      // alert($event.target.parentElement.firstChild.innerText)
      // console.log(e)
    },
    getJams(){
      const date = new Date()
      let durasi = this.durasi*1000*60
      let start = this.mulai
      let end = date.setTime(this.interval*durasi)
      let jams = []
      for(var i = 0; i < this.interval; i++) {
        jams[i] = start + (durasi*i)
      }

      this.jams = jams
    },
    getMyRombels() {
      this.loading = true
      axios({
        method: 'post',
        url: '/guru/rombel/'+this.$page.props.user.userable_id
      }).then( res => {
        let rombels = [{kode_rombel: 'hapus', nama_rombel: 'Hapus?'}]
        res.data.rombels.forEach((item,index) => {
          item.no = index+1
          rombels.push(item)
        })

        this.rombels = rombels
        this.loading = false
      })
    },
    getJadwals() {
      this.loading = true
      axios({
        method: 'post',
        url: '/guru/jadwal/'+this.$page.props.user.userable_id+'?periode='+this.$page.props.periode.kode_periode
      }).then( res=> {
        this.jadwals = res.data.jadwals
        this.loading = false
      })
    }
    
  },
  computed: {
    schedules() {
      let jadwals = []
      this.jams.forEach((item,index) => {
        var jamke = new Date(item).getHours()+':'+new Date(item).getMinutes()
        let obj = { jamke: jamke, senin:'', selasa:''}
        this.jadwals.forEach(j => {
          switch(j.hari) {
            case 'Senin':
              if (j.jamke == jamke) obj.senin = j.rombel ?  {nama_rombel:j.rombel.nama_rombel, kode_rombel:j.rombel.kode_rombel, id: j.id}:null
              break
            
            case 'Selasa':
              if (j.jamke == jamke) obj.selasa = j.rombel? {nama_rombel:j.rombel.nama_rombel, kode_rombel:j.rombel.kode_rombel, id: j.id}:null
              break
            
            case 'Rabu':
              if (j.jamke == jamke) obj.rabu = j.rombel? {nama_rombel:j.rombel.nama_rombel, kode_rombel:j.rombel.kode_rombel, id: j.id}:null
              break
            
            case 'Kamis':
              if (j.jamke == jamke) obj.kamis = j.rombel? {nama_rombel:j.rombel.nama_rombel, kode_rombel:j.rombel.kode_rombel, id: j.id}:null
              break
            
            case 'Jumat':
              if (j.jamke == jamke) obj.jumat = j.rombel? {nama_rombel:j.rombel.nama_rombel, kode_rombel:j.rombel.kode_rombel, id: j.id}:null
              break
            
            case 'Sabtu':
              if (j.jamke == jamke) obj.sabtu = j.rombel? {nama_rombel:j.rombel.nama_rombel, kode_rombel:j.rombel.kode_rombel, id: j.id}:null
              break
            
          }
        })

        jadwals.push(obj)
        
      })

      return jadwals
    },
    start(){
      return moment().weekday(1).format('YYYY-MM-DD')
    },
    end(){
      return moment().weekday(6).format('YYYY-MM-DD')
    },
    parsedEvents() {
      let jadwals = []
      this.events.forEach(item => {
        let date = moment().weekday(item.hari).format('YYYY-MM-DD')
        item.start = date+' '+item.start
        item.end = date+' '+item.end
        jadwals.push(item)
      })

      return jadwals
    }
  },
  mounted() {
    // this.getEvents()
    this.getMyRombels()
    this.getJadwals()
    this.getJams()
  }
}
</script>

<style scoped>
  table {
    border-collapse: collapse;
  }
  #tableJadwal td{
    text-align: center;
    padding: 10px 0;
    width: 14.3%;
  }
  #tableJadwal td.aktif {
    background: rgb(216, 243, 216);
    color: #212121;
    text-transform: uppercase;
    font-weight: bolder;
  }
  #tableJadwal td.istirahat {
    background: rgb(245, 145, 145);
    color: #212121;
    text-transform: uppercase;
    font-weight: bolder;
  }
</style>