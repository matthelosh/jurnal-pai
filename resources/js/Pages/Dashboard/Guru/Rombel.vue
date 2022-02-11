<template>
  <dash-layout>
    <div>
      <v-toolbar>
        <v-btn icon @click="sidebar = !sidebar"><v-icon>mdi-menu</v-icon></v-btn>
        <v-text-field solo-inverted  label="Cari" append-icon="mdi-magnify" v-model="search" dense hide-details single-line></v-text-field>
        <v-spacer></v-spacer>
        <v-btn class="btnPrimary" rounded @click="form = ! form">Tambah</v-btn>
      </v-toolbar>
      <v-expand-transition mode="in-out">
        <v-row v-if="form">
          <v-col>
            <v-card color="grey lighten-2" tile>
              <v-card-text>
                <v-form ref="formRombel" @submit.prevent="simpan">
                  <v-row>
                    <v-col cols="12" sm="2">
                      <v-select v-model="rombel.tingkat" label="Tingkat" :items="[1,2,3,4,5,6]" solo dense :rules="required"></v-select>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-select v-model="rombel.pararel" label="Pararel" :items="['0', 'A', 'B', 'C', 'D']"  solo dense @change="genNamaRombel" :rules="required"></v-select>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-text-field v-model="rombel.nama_rombel" label="Nama Rombel"  solo dense></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-text-field type="number" v-model="rombel.siswa" label="Siswa Lk"  solo dense :rules="required"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-text-field type="number" v-model="rombel.siswi" label="Siswa Pr"  solo dense :rules="required"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-btn class="btnSubmit" type="submit" rounded block>Simpan</v-btn>
                    </v-col>
                    
                  </v-row>
                </v-form>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-expand-transition>
      <v-container>
        <v-col>
          <v-data-table
            :items="rombels"
            :headers="headers"
            :search="search"
            outline
          ></v-data-table>
        </v-col>
      </v-container>
    </div>
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
export default {
  name: 'GuruRombel',
  components: { DashLayout },
  data: () => ({
    form: false,
    search: '',
    rombels: [],
    required: [v => !!v || 'Isi Dulu'],
    headers: [
      { text: 'No', value: 'no' },
      { text: 'Kode Rombel', value: 'kode_rombel' },
      { text: 'Nama Rombel', value: 'nama_rombel' },
      { text: 'Jml Siswa', value: 'siswa' },
      { text: 'Jml Siswi', value: 'siswi' },
    ],
    rombel: {}
  }),
  methods: {
    getMyRombels() {
      axios({
        method: 'post',
        url: '/guru/rombel/'+this.guru.id
      }).then( res => {
        let rombels = []
        res.data.rombels.forEach((item,index) => {
          item.no = index+1
          rombels.push(item)
        })

        this.rombels = rombels
      })
    },
    simpan() {
      if (this.$refs.formRombel.validate()) {
        let rombel = this.rombel
        rombel.periode_id = this.$page.props.periode.kode_periode
        rombel.kode_rombel = this.guru.sekolah_id+this.$page.props.periode.kode_periode+'-'+rombel.tingkat+((rombel.pararel != '0')?rombel.pararel.toLowerCase():'')
        rombel.guru_id = this.guru.id
        rombel.sekolah_id = this.guru.sekolah_id
        rombel.periode_id = this.$page.props.periode.kode_periode
        // console.log(rombel)
        axios({
          method: 'post',
          url: '/guru/rombel/store',
          data: rombel
        }).then( res => {
          this.getMyRombels()
          this.form = false
        })
      }
    },
    genNamaRombel() {
      this.rombel.nama_rombel = 'Kelas '+this.rombel.tingkat+((this.rombel.pararel != '0') ? this.rombel.pararel.toUpperCase() : '')
    }
  },
  computed: {
    guru() {
      return this.$page.props.user.userable
    }
  },
  mounted() {
    this.getMyRombels()
  }
}
</script>

<style scoped>
  .btnPrimary {
    color: white;
    background: linear-gradient(to right, rgb(47, 174, 206),rgb(219, 78, 102));
  }
  .btnSubmit {
    color: white;
    background: linear-gradient(to right, rgb(18, 91, 185),rgb(76, 129, 179));
  }
</style>