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
    <v-container>
      <v-row>
        <v-expand-transition>
          <v-col cols="12" v-if="show == 'kaldik'">
            <v-card>
              <v-card-text>
                Kaldik
              </v-card-text>
            </v-card>
          </v-col>
        </v-expand-transition>
        <v-expand-transition>
          <v-col cols="12" v-if="show == 'pembelajaran'">
            <v-card>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col>
                      <v-data-table
                        :items="pembelajaran.items"
                        :headers="pembelajaran.headers"
                        :search="pembelajaran.search"
                      >
                        <template v-slot:top>
                          <v-container>
                            <v-row>
                              <v-col>
                                <h2><v-icon>mdi-bookshelf</v-icon>Pembelajaran</h2>
                                <v-divider class="mb-2"></v-divider>
                                <v-btn small rounded color="primary" @click="pembelajaran.form = true">Buat</v-btn>
                                <v-btn small rounded color="primary">Impor</v-btn>
                                <v-btn small rounded color="primary">Unduh</v-btn>
                                <v-btn small rounded color="primary">Cetak</v-btn>
                              </v-col>
                              <v-col></v-col>
                              <v-col>
                                <v-text-field label="Cari" v-model="pembelajaran.search" rounded hide-details dense append-icon="mdi-magnify" solo></v-text-field>
                              </v-col>
                            </v-row>
                          </v-container>
                        </template>
                        <template v-slot:[`item.tingkat`]="{item}">
                          <span>{{ 'Kelas '+item.tingkat}}</span>
                        </template>
                        <template v-slot:[`item.judul`]="{item}">
                          <a href="#" @click="edit('pbl',item)">{{ item.judul}}</a>
                        </template>
                      </v-data-table>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
            </v-card>
          </v-col>
        </v-expand-transition>
        <v-expand-transition>
          <v-col cols="12" v-if="show == 'kikd'">
            <v-card>
              <v-card-text>
                KI/KD
              </v-card-text>
            </v-card>
          </v-col>
        </v-expand-transition>
        <v-expand-transition>
          <v-col cols="12" v-if="show == 'silabus'">
            <silabus></silabus>
          </v-col>
        </v-expand-transition>
      </v-row>
    </v-container>
    <v-dialog ref="dlgPembelajaran" v-if="pembelajaran.form" v-model="pembelajaran.form" max-width="600">
      <v-card>
        <v-card-title>Form Pembelajaran</v-card-title>
        <v-card-text>
          <v-form ref="formPembelajaran" @submit.prevent="savePembelajaran">
            <v-row>
              <v-col>
                <v-select label="Kelas" :items="['1','2','3','4','5','6']" v-model="pembelajaran.data.tingkat" @change="getKds"></v-select>
              </v-col>
              <v-col>
                <v-select label="Semester" :items="['1','2']" v-model="pembelajaran.data.semester" ></v-select>
              </v-col>`
              <v-col>
                <v-select label="Pembelajaran Ke" :items="['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16']" v-model="pembelajaran.data.ke"></v-select>
              </v-col>
              <v-col cols="12">
                <v-select label="KD" :items="kds" v-model="pembelajaran.data.kd_id" multiple item-value="kode_kd">
                  <template v-slot:item="{item}" max-width="600">
                    <span>{{ item.kode_kd }} </span><span> - {{ item.teks }}</span>
                  </template>
                  <template v-slot:selection="{item}">
                    <v-chip>
                      <span>{{item.kode_kd}}</span>
                    </v-chip>
                  </template>
                </v-select>
              </v-col>
              <v-col cols="12">
                <v-textarea label="Judul" rows="1" auto-grow v-model="pembelajaran.data.judul"></v-textarea>
              </v-col>
              <v-col cols="12">
                <v-textarea label="Sub Pembelajaran" rows="2" auto-grow v-model="pembelajaran.data.sub" hint="Pisahkan dengan koma setiap Sub Pembelajaran"></v-textarea>
              </v-col>
              <v-col>
                <v-btn block color="primary" type="submit" :loading="loading">simpan</v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </dash-layout>
</template>

<script>
import axios from 'axios'
import DashLayout from '../../../Layout/DashLayout'
import Silabus from './Components/Silabus'
export default {
  name: 'Perangkat',
  components: {DashLayout, Silabus},
  data: () => ({
    show: '',
    pembelajaran: {
      items: [],
      headers: [
        { text: 'No.', value: 'no' , filterable: false},
        { text: 'Tapel', value: 'tapel', filterable: false },
        { text: 'Semester', value: 'semester', filterable: false },
        { text: 'Tingkat', value: 'tingkat' },
        { text: 'KD', value: 'kd_id', filterable: false },
        { text: 'Ke', value: 'ke', filterable: false },
        { text: 'Judul', value: 'judul' },
        { text: 'Sub Pembelajaran', value: 'sub' },
      ],
      data: {},
      form: false,
      search: '',
    },
    tingkat: '',
    semester: '',
    kds: [],
    loading: false,
  }),
  methods: {
    edit(item, data){
      switch(item){
        case "pbl":
          this.pembelajaran.form = true,
          
          this.pembelajaran.data = data
          this.pembelajaran.data.kd_id = data.kd_id.split(',')
          this.getKds(data.tingkat)
        break
      }
    },
    savePembelajaran(){
      let pbl = this.pembelajaran.data
      axios({
        method: 'post',
        url: '/admin/perangkat/pembelajaran/store',
        data: pbl
      }).then( res => {
        this.getPbl()
        this.$refs.formPembelajaran.reset()
      })
    },
    getPbl() {
      axios({
        method: 'post',
        url: '/admin/perangkat/get?tipe=pembelajaran'
      }).then(res => {
        if (res.data.pembelajarans.length > 0) {
          let pembelajarans = []
          res.data.pembelajarans.forEach((item,index) => {
            item.no = index+1
            pembelajarans.push(item)
          })
          this.pembelajaran.items = pembelajarans
        }
      })
    },
    getKds(e){
      axios({
        method: 'post',
        url: '/admin/perangkat/get?tipe=kd&tingkat='+e+'&semester='+this.semester
      }).then( res => {
        this.kds = _.orderBy(res.data.kds, kd => kd.kode_kd.substr(2,1))
      })
    }
  },
  watch: {
    pembelajaran: {
      handler(val){
        this.tingkat = val.data.tingkat
        this.semester = val.data.semester
      },
      deep: true
    }
  },
  created() {
    this.getPbl()
    // if(this.pembelajaran.data.tingkat){
    //   this.getKds(this.pembelajaran.data.tingkat)
    // }
  }
}
</script>