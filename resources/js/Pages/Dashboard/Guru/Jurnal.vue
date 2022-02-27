<template>
  <dash-layout :pageTitle="'<span class=\'mdi mdi-clipboard-list\'></span> Jurnal'">
    <div>
      <v-toolbar>
        <v-btn icon><v-icon>mdi-menu</v-icon></v-btn>
        Data Jurnal
        <v-spacer></v-spacer>
        <v-btn rounded dark color="primary" @click="jurnal.form = !jurnal.form">BUAT</v-btn>
      </v-toolbar>
      <v-expand-transition>
        <v-container v-if="jurnal.form" style="background: #ffffff;">
          <v-form ref="formJurnal" @submit.prevent="simpan" >
            <v-row>
              <v-col>
                <v-select :items="rombels" item-text="text" item-value="value" label="Rombel" v-model="jurnal.data.rombel_id" @change="getPembelajaran" ></v-select>
              </v-col>
              <v-col>
                <v-select :items="pembelajarans" item-value="id" label="Pembelajaran" v-model="jurnal.data.tema" return-object>
                  <template v-slot:item="{item}">
                    <span>{{ item.ke }}. {{item.judul}}</span>
                  </template>
                  <template v-slot:selection="{item}">
                    <span>{{ item.ke }}. {{item.judul}}</span>
                  </template>
                  <template v-slot:hint="{item}">
                    <span>{{ item.kd_id }}</span>
                  </template>
                </v-select>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
      </v-expand-transition>
      <v-container>
        <v-col>
          <v-card>
            <v-card-text>

            </v-card-text>
          </v-card>
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
    jurnal: {
      form: false,
      loading: false,
      items: [],
      headers: [],
      data: {}
    },
    haris: ['Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
    jadwals: [],
    rawrombels: [],
    pembelajarans: [],
  }),
  methods: {
    getJadwals(){
      let date = new Date(), today = date.getDay(), hari = this.haris[today]
      axios({
        method: 'post',
        url: '/guru/jadwal/show?id_guru='+this.$page.props.user.userable_id+'&hari='+hari
      }).then( res => {
        this.jadwals = _.groupBy(res.data.jadwals, 'rombel_id')
        this.rawrombels = _.uniqBy(res.data.jadwals, 'rombel_id')
      })
    },
    getPembelajaran() {
      let rombel = this.jurnal.data.rombel_id.split('-')
      let tingkat = rombel[1].substr(0,1)
      axios({
        method: 'post',
        url: '/guru/pembelajaran?tingkat='+tingkat
      }).then( res => {
        let pbl = []
        this.pembelajarans = res.data.pembelajarans
      })
    }
  },
  computed: {
    rombels() {
      const raws = this.rawrombels
      let rombels = []
      raws.forEach(item => {
        rombels.push({text: item.rombel.nama_rombel, value: item.rombel.kode_rombel})
      })
      return rombels
    }
  },
  created(){
    this.getJadwals()
  }
}
</script>