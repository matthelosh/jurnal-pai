<template>
  <dash-layout>
    <v-container>
      <v-row>
        <v-col>
          <v-expand-transition>
            <v-card v-if="showForm">
              <v-card-title>Formulir Guru</v-card-title>
              <v-card-text>
                <v-form ref="formGuru" @submit.prevent="simpan">
                  <v-row>
                    <v-col cols="12" sm="3">
                      <v-text-field label="NIP" v-model="guru.nip" solo></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="3">
                      <v-text-field label="Nama" v-model="guru.nama" :rules="[v => !!v || 'Harus Diisi']" solo></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-select label="Jenis Kelamin" v-model="guru.jk" :items="['Laki-laki','Perempuan']" :rules="[v => !!v || 'Harus Diisi']" solo></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                      <v-autocomplete label="Sekolah" v-model="guru.sekolah_id" :items="sekolahs" item-text="text" item-value="value" :rules="[v => !!v || 'Harus Diisi']" solo></v-autocomplete>
                    </v-col>
                    <v-col cols="12">
                      <v-btn dark color="primary" block type="submit">Simpan</v-btn>
                    </v-col>
                  </v-row>
                </v-form>
              </v-card-text>
            </v-card>
          </v-expand-transition>
          <v-expand-transition>
            <v-card v-if="formImpor">
              <v-card-text>
                <v-row>
                  <v-col><h3>Form Impor</h3></v-col>
                  <v-col><v-file-input outlined type="file" ref="file" label="File Excel" accept=".xls,.xlsx, .ods, .csv" @change="onFilePicked"></v-file-input></v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-data-table
                      :items="datagurus"
                      :headers="imporHeaders"
                      v-if="datagurus.length > 0"
                      :loading="parsingFile"
                    >
                      <template v-slot:top>
                        <v-container>
                          <v-row>
                            <v-col>
                              <h3>DATA GURU YANG AKAN DIIMPOR</h3>
                            </v-col>
                            <v-col class="d-flex justify-end">
                              <v-btn color="primary" small @click="impor">Upload</v-btn>
                            </v-col>
                          </v-row>
                        </v-container>
                      </template>
                    </v-data-table>
                    <v-alert color="info" border="left" v-else dark>
                      Pilih File Excel Guru
                    </v-alert>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-expand-transition>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-card>
            <v-card-text>
              <v-data-table
                :items="gurus"
                :headers="headers"
                show-select
                v-model="selected"
                :search="search"
                :loading="parsingFile"
              >
                <template v-slot:top>
                  <v-container>
                    <v-row>
                      <v-col>
                        <v-btn color="primary" @click="showForm = !showForm" small>{{ showForm ? 'Sembunyikan' :'Baru' }}</v-btn>
                        <v-btn color="success darken-2" @click="formImpor = !formImpor" small>{{ formImpor ? 'Sembunyikan' :'Impor' }}</v-btn>
                        <v-btn color="error" @click="deleteSome" small v-if="selected.length > 0">Hapus Terpilih</v-btn>
                        <v-btn color="info" @click="buatAkun" small v-if="selected.length > 0">Buat Akun</v-btn>
                      </v-col>

                      <v-col>
                        <v-text-field dense hide-details label="Cari" clearable append-icon="mdi-magnify" v-model="search"></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </template>
                <template v-slot:[`item.nama`]="{item}">
                  <a href="#" @click="edit(item)" hover class="link-nama">
                    {{ item.nama }}
                  </a>
                </template>
                <template v-slot:[`item.opsi`]="{item}">
                  <span>
                    <v-btn icon color="error" @click="hapus(item)"><v-icon>mdi-delete</v-icon></v-btn>
                  </span>
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
import XLSX from 'xlsx'
export default {
  name: 'AdminGuru',
  components: {DashLayout},
  props: {},
  data: () => ({
    parsingFile: false,
    search:'',
    showForm: false,
    formImpor: false,
    guru: {},
    gurus: [],
    headers: [
      { text: 'No', value: 'no'},
      { text: 'NIP', value: 'nip'},
      { text: 'Nama', value:'nama'},
      { text: 'Username', value:'userable.username'},
      { text: 'JK', value: 'jk'},
      { text: 'Sekolah', value: 'sekolah.nama_sekolah'},
      { text: 'Opsi', value: 'opsi'}
    ],
    selected: [],
    file: null,
    datagurus: [],
    imporHeaders: [
      { text: 'NIP', value: 'nip'},
      { text: 'Nama', value: 'nama'},
      { text: 'JK', value: 'jk' },
      { text: 'Sekolah', value: 'sekolah_id' }
    ],
    sekolahs: []
  }),
  methods: {
    buatAkun(){
      axios({
        method: 'post',
        url: '/admin/guru/buatakun',
        data: this.selected
      }).then(res => {
        this.getGurus()
      })
    },
    impor(){
      axios({
        method: 'post',
        url: '/admin/guru/impor',
        data: this.datagurus
      }).then(res => {
        this.datagurus = []
        this.formImpor = false
        this.getGurus()
      })
    },
    onFilePicked(e){
      const file = e
      const reader = new FileReader()
      this.parsingFile = true
      reader.onload = (e) => {
        const binstr = e.target.result
        const wb = XLSX.read(binstr, { type: 'binary'})
        let wsname = wb.SheetNames[0]
        const ws = XLSX.utils.sheet_to_json(wb.Sheets[wsname])
        let datas = []
        for ( var i = 0; i < ws.length; i++) {
          datas.push(ws[i])
        }

        this.datagurus = datas
        this.parsingFile = false
      }

      reader.readAsBinaryString(e)
    },
    edit(item){
      this.showForm = true
      this.guru = item
    },
    simpan(e) {
      e.preventDefault
      if(this.$refs.formGuru.validate()) 
      {
        axios({
          method: 'post',
          url: '/admin/guru/store',
          data: this.guru
        }).then(res => {
          this.showForm = false
          this.$refs.formGuru.reset()
          this.getGurus()
        })
      }
    },
    deleteSome(){
      this.confirm('Yakin Menghapus Data-data Guru Terpilih?')
          .then(() => {
            axios({
              method: 'delete',
              url: '/admin/guru/',
              data: this.selected
            }).then(res => {
              this.selected = []
              this.getGurus()
            })
          }).catch(err => {

          })
    },
    hapus(item){
      this.confirm('Yakin Menghapus Data Guru '+item.nama+'?')
          .then(() => {
            axios({
              method: 'delete',
              url: '/admin/guru/'+item.id
            }).then(res => {
              this.getGurus()
            })
          }).catch(err => {
            alert('Tidak Jadi')
          })
    },
    confirm(text) {
      return new Promise((resolve, reject) => {
        let ok = confirm(text)
        return ok ? resolve(true) : reject(false)
      })
    },
    getGurus(){
      this.parsingFile=true
      axios({
        method: 'post',
        url: '/admin/guru'
      }).then(res => {
        this.gurus = res.data.gurus
        this.parsingFile=false
      })
    }, 
    setSekolahs() {
      let items = []
      const datas = this.$page.props.sekolah
      datas.forEach(item => {
        items.push({text: item.nama_sekolah, value: item.npsn})
      })

      this.sekolahs = items
    }
  },
  computed: {
  },
  created(){
    this.getGurus()
    this.setSekolahs()
  }
}
</script>

<style scoped>
  .link-nama {
    text-decoration: none;
    text-transform: uppercase;
  }

  .link-nama:hover {
    text-decoration: underline;
  }
</style>