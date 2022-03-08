<template>
  <dash-layout :pageTitle="'Program Semester'">
    <v-container>
      <v-expand-transition>
        <v-row v-if="detail">
          <v-col>
            <v-card>
              <v-toolbar color="grad-prim" dense >
                Prosem Kelas {{ rombel.nama_rombel }}
                <v-spacer></v-spacer>
                <v-btn rounded small color="primary" @click="newProsem">Baru</v-btn>
                <v-btn @click="detail = false, rombel={}" icon color="error"><v-icon>mdi-close</v-icon></v-btn>
              </v-toolbar>
              <v-card-text>
                <v-container>
                  <v-expand-transition>
                    <v-row v-if="formProsem">
                      <v-col>
                        <v-form ref="formProsem" @submit.prevent="simpan">
                          <v-row>
                            <v-col>

                            </v-col>
                          </v-row>
                        </v-form>
                      </v-col>
                    </v-row>
                  </v-expand-transition>
                  <v-expand-transition>
                    <v-row v-if="!formProsem">
                      <v-col cols="12">
                        <h3>Data Program Semester</h3>
                      </v-col>
                      <v-col>
                        <table width="100%" border="1" style="border-collapse:collapse">
                          <thead>
                            <tr>
                              <th>Pelajaran</th>
                              <th>Materi</th>
                              <th>KD</th>
                              <th v-for="bulan in bulans" :key="bulan">{{ bulan }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(prota,i) in protas" :key="i">
                              <td>{{prota.pelajaran}}</td>
                              <td>{{prota.materi}}</td>
                              <td>
                                <tr v-for="(kd,k) in prota.kd.split(',')" :key="k" width="100%">
                                  <td width="100%">{{kd}}</td>
                                </tr>
                              </td>
                              
                            </tr>
                          </tbody>
                        </table>

                      </v-col>
                    </v-row>
                  </v-expand-transition>
                </v-container>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-expand-transition>
      <v-expand-transition>
        <v-row v-if="detail == false"> 
          <v-col v-for="rombel in rombels" :key="rombel.id" cols="12" sm="4">
            <v-card hover @click="showDetail(rombel)">
              <v-card-text>
                <h4>{{rombel.nama_rombel}}</h4>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-expand-transition>
      
    </v-container>
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
export default {
  name: 'GuruProsem',
  components: { DashLayout },
  data: () => ({
    formProsem: false,
    rombels: [],
    detail: false,
    rombel: {},
    jadwals: [],
    protas: [],
    rows: [],
    month: [
      ['Juli', 'Agustus','September','Oktober','November', 'Desember'],
      ['Januari', 'Februari','Maret','April','Mei', 'Juni'],
    ]
  }),
  methods: {
    newProsem(){

    },
    showDetail(rombel) {
      this.detail = true
      this.rombel=rombel
      this.getProtas()
    },
    getRombels() {
      axios({
        method: 'post',
        url: '/guru/rombel/'+this.$page.props.user.userable_id+'?periode='+this.$page.props.periode.kode_periode
      }).then( res => {
        this.rombels = res.data.rombels
      })
    },
    getJadwals(rombel) {
      axios({
        method: 'post',
        url: '/guru/jadwal/'+this.$page.props.user.userable_id+'?periode='+this.$page.props.periode.kode_periode
      }).then( res => {
        this.jadwals = res.data.jadwals
      })
    },
    getProtas() {
      axios({
        method: 'post',
        url: '/guru/prota/'+this.$page.props.periode.semester+'/'+this.rombel.tingkat
      }).then( res => {
        let protas = res.data.protas
        this.protas = protas
        let rows = ''
        protas.forEach(item => {
          rows += item.kd
        })
        this.rows = rows.split(',')
      })
    }
  },
  computed: {
    bulans() {
      return this.$page.props.periode.semester == '1' ? this.month[0] : this.month[1]
    }
  },
  created(){
    this.getRombels()
    this.getJadwals()
  }

}
</script>