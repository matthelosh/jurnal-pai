<template>
  <dash-layout :pageTitle="'Data Sekolah'">
    <v-container>
      <v-row>
        <v-col>
          <v-btn color="primary" @click="formTambah = true">Tambah</v-btn>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-data-table
            :items="sekolahs"
            :headers="headers"
          ></v-data-table>
        </v-col>
      </v-row>
    </v-container>
    <v-dialog v-if="formTambah" v-model="formTambah" scrollable max-width="600">
      <v-card  >
        <v-card-title class="pa-0">
          <v-toolbar dense color="primary" dark>
            {{ sekolah.id ? 'Edit' : 'Tambah' }} Sekolah
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-form ref="formSekolah" @submit.prevent="simpan" class="py-5">
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field label="NPSN" v-model="sekolah.npsn" dense :rules="required" autofocus></v-text-field>
              </v-col>
              <v-col cols="12" sm="8">
                <v-text-field label="Nama Sekolah" v-model="sekolah.nama_sekolah" dense :rules="required"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea label="Alamat" v-model="sekolah.alamat" auto-grow rows="2" dense :rules="required"></v-textarea>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Telp./HP" v-model="sekolah.telp" dense ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Email" v-model="sekolah.email" dense  type="email"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Website" v-model="sekolah.website" dense></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Kepala Sekolah" v-model="sekolah.nama_ks" :rules="required" dense></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="NIP Kepala Sekolah"  v-model="sekolah.nip_ks" dense></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-btn block color="primary" type="submit">Simpan</v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
export default {
  name: 'Sekolah',
  components: {DashLayout},
  data: () => ({
    sekolah: {},
    sekolahs: [],
    formTambah: false,
    formImpor: false,
    required:[v => !!v || 'Harus Diisi'],
    headers: [
      { text: 'No', value: 'no', sortable: false },
      { text: 'NPSN', value: 'npsn' },
      { text: 'Nama Sekolah', value: 'nama_sekolah' },
      { text: 'Kepala Sekolah', value: 'nama_ks' },
      { text: 'Alamat', value: 'alamat' },
      { text: 'Opsi', value: 'opsi' }
    ]
  }),
  methods: {
    simpan() {
      if(this.$refs.formSekolah.validate()){
        axios({
          method: 'post',
          url: '/admin/sekolah/store',
          data: this.sekolah
        }).then( res => {
          this.getSekolahs()
        })
      }
          
      
    },
    getSekolahs() {
      axios({
        method: 'post',
        url: '/admin/sekolah'
      }).then( res => {
        let sekolahs = []
        if ( res.data.sekolahs.length > 0 ) {
          res.data.sekolahs.forEach((item,index) => {
            item.no = index+1
            sekolahs.push(item)
          })
          this.sekolahs = sekolahs
        }
      })
    }
  },
  mounted() {
    this.getSekolahs()
  }

}
</script>