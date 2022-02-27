<template>
  <dash-layout>
    <v-container>
      <v-row>
        <v-col>
          <v-card>
            <v-card-title>
              <v-icon>mdi-calendar</v-icon>
              Periode
              <v-spacer></v-spacer>
              <v-btn small rounded color="primary" @click="periode.form = !periode.form">{{ periode.form ? 'Selesai' :'Tambah'}}</v-btn>
            </v-card-title>
            <v-card-text>
              <v-expand-transition>
                <v-form ref="formPeriode" @submit.prevent="simpanPeriode" v-if="periode.form">
                  <v-container>
                    <v-row>
                      <v-col>
                        <v-select label="Tahun Pelajaran" v-model="periode.data.tapel" :items="tapels" dense></v-select>
                      </v-col>
                      <v-col>
                        <v-select label="Semester" v-model="periode.data.semester" :items="[1,2]" dense></v-select>
                      </v-col>
                      <v-col>
                        <v-text-field label="Kode" v-model="periode.data.kode_periode" dense disabled></v-text-field>
                      </v-col>
                      <v-col>
                        <v-text-field label="Label" v-model="periode.data.label" dense disabled></v-text-field>
                      </v-col>
                      <v-col>
                        <v-btn type="submit" small color="info" rounded>Simpan</v-btn>
                      </v-col>
                    </v-row>
                    <v-expand-transition>
                      <v-row v-if="error">
                        <v-container>
                          <v-row>
                            <v-col>
                              <v-alert color="error" dark><v-icon>mdi-alert</v-icon> {{error}}</v-alert>
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-row>
                    </v-expand-transition>
                  </v-container>
                </v-form>
              </v-expand-transition>
              <v-data-table
                :items="periode.items" :headers="periode.headers" no-data-text="Kosong" :loading="periode.loading"
              >
                <template v-slot:[`item.status`]="{item}">
                  <span><v-icon :color="item.active ? 'success':'error'" @click="changeStatus(item)">mdi-check-circle</v-icon></span>
                </template>
                <template v-slot:[`item.label`]="{item}">
                    {{ item.label }}
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
export default {
  components: {DashLayout},
  name: 'AdminSetting',
  data: () => ({
    error: null,
    periode: {
      data: {},
      form: false,
      loading: false,
      items: [],
      headers: [
        { text: 'Kode', value: 'kode_periode'}, {text: 'Label', value: 'label'},{text: 'Tahun Pelajaran', value:'tapel'}, {text: 'Semester', value:'semester'},{ text: 'Status', value:'status'},{ text: 'Opsi', value: 'opsi'}
      ]
    },
    tes: '',
    tapels: ['2021-2022', '2022-2023','2023-2024','2024-2025'],
  }),
  methods: {
    simpanPeriode(){
      axios({
        method: 'post',
        url: '/admin/settings/periode/store',
        data: this.periode.data
      }).then(res => {
        this.getPeriodes()
      }).catch( err => {
        if(err.response.data.msg.includes('Duplicate'))
          this.error ='Periode sudah ada.'
      })
    },
    changeStatus(item){
      axios({
        method: 'put',
        url: '/admin/settings/periode/status?id='+item.id+'&status='+item.active
      }).then(res => {
        this.getPeriodes()
      })
    },
    getPeriodes(){
      this.periode.loading = true
      axios({
        method: 'post',
        url: '/admin/settings/periode'
      }).then(res => {
        this.periode.items = res.data.periodes
        this.periode.loading = false
      })
    }
  },
  watch: {
    periode: {
      handler(val){
        let tapel = val.data.tapel
        const semester = val.data.semester
        if (tapel && semester) {
          tapel = tapel.split('-')
          let kode = tapel[0].substr(2,2)+tapel[1].substr(2,2)+semester
          this.periode.data.kode_periode = kode
          this.periode.data.label = tapel[0]+' / '+tapel[1]+' '+(semester == 1 ? 'Ganjil': 'Genap')
        }
      },
      deep: true
    },
    
  },
  created() {
    this.getPeriodes()
  }

}
</script>