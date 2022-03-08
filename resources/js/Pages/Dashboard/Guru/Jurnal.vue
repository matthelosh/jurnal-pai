<template>
  <dash-layout :pageTitle="'<span class=\'mdi mdi-clipboard-list\'></span> Jurnal'">
    <div>
      <v-toolbar>
        <v-btn icon><v-icon>mdi-menu</v-icon></v-btn>
        Data Jurnal
        <v-spacer></v-spacer>
        <v-btn rounded dark color="primary" @click="jurnal.form = !jurnal.form">{{ jurnal.form ? 'Selesai' : 'Buat' }}</v-btn>
      </v-toolbar>
      <v-expand-transition>
        <v-container v-if="jurnal.form" style="background: #ffffff;">
          <span v-if="jadwals">
            <v-form ref="formJurnal" @submit.prevent="simpan" >
              <v-row>
                <v-col cols="12" sm="4">
                  <v-select :items="rombels" item-text="text" item-value="value" label="Rombel" v-model="jurnal.data.rombel_id" @change="getPembelajaran" ></v-select>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-select :items="pembelajarans" item-value="id" label="Pembelajaran" v-model="jurnal.data.tema" return-object @change="setSub">
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
                <v-col cols="12" sm="4">
                  <v-select label="Sub Tema" :items="subs" multiple v-model="jurnal.data.subtema"></v-select>
                </v-col>
                <v-col cols="12" v-if="kds.length > 0">
                  <h4>Kompetensi Dasar dan Indikator</h4>
                  <table width="100%" border="1" style="border-collapse: collapse;">
                    <thead>
                      <tr>
                        <th>KOMPETENSI DASAR</th>
                        <th>INDIKATOR PENCAPAIAN KOMPETENSI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="kd in kds" :key="kd.id">
                        <td>
                          {{ kd.kode_kd }}
                        </td>
                        <td>
                          <ul v-for="ipk in kd.indikators" :key="ipk.id">
                            <li>{{ipk.kode_indikator}} {{ipk.teks}}</li>
                          </ul>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-textarea label="Presensi Siswa" hint="Contoh: A:5, I:2, S: 3" v-model="jurnal.data.absensi_siswa" rows="2" auto-grow></v-textarea>
                </v-col>
                <v-col cols="12" sm="8">
                  <quill-editor v-model="jurnal.data.catatan"></quill-editor>
                </v-col>
                <v-col cols="12">
                  <v-btn type="submit" color="primary" block rounded>Simpan</v-btn>
                </v-col>
              </v-row>
            </v-form>
          </span>
          <v-alert v-else color="error lighten-2"  border="left" class="d-flex justify-start">
            <v-icon>mdi-alert</v-icon>
            <span class="text-h5">Tidak ada jadwal mengajar untuk hari ini</span>
          </v-alert>
        </v-container>
      </v-expand-transition>
      <v-container>
        <v-col>
          <v-card>
            <v-card-text>
              <v-data-table
                :items="jurnal.items"
                :headers="jurnal.headers"
                :loading="jurnal.loading"
              >
                <template v-slot:[`item.catatan`]="{item}">
                  <span v-html="item.catatan"></span>
                </template>
                <template v-slot:[`item.opsi`]="{item}">
                  <span>
                    <v-btn icon color="primary" @click="cetakJurnal(item)"> <v-icon>mdi-printer</v-icon></v-btn>
                  </span>
                </template>
              </v-data-table>
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
      headers: [
        { text: 'No', value: 'no'},
        { text: 'Rombel', value: 'rombel_id' },
        { text: 'Tanggal', value: 'tanggal'},
        { text: 'Pembelajaran', value: 'tema'},
        { text: 'Absensi Siswa', value: 'absensi_siswa'},
        { text: 'Catatan', value: 'catatan'},
        { text: 'Opsi', value: 'opsi'},
      ],
      data: {}
    },
    haris: ['Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
    jadwals: [],
    rawrombels: [],
    pembelajarans: [],
    subs: [],
    kds: []
  }),
  methods: {
    cetakJurnal(item) {
      // console.log(item)
      let kelas = item.rombel_id.split('-')
      // this.getKds(item.kd_id, kelas[1].substr(0,1))
      let tr = ''
      axios({
        method: 'post',
        url: '/guru/pembelajaran/kd?tingkat='+kelas[1].substr(0,1),
        data: {kds: item.kd_id.split(',')}
      }).then( res => {
        // console.log(res.data)
        res.data.kds.forEach(kd => {
          let ipk = ''
          kd.indikators.forEach(ip => {
            ipk += `<li>${ip.kode_indikator}. ${ip.teks}</li>`
          })
          tr += `<tr>
            <td width="50%">${kd.kode_kd}. ${kd.teks}</td><td><ul>${ipk}</ul></td>
          
          </tr>`
        })
        let html = `
        <!doctype html>
        <html>
          <head>
            <style>
              table#kop {
                width: 100%;
                border-bottom: 5px double black;
              }
              table#kop td {
                text-align: center;
              }
              table#kop  h1,h2,h3,h4,p {
                margin:0;padding:0;
                text-align:center;
              }
              table#kd td,
              table#meta td {
                text-align: left;
              }
              table#kd td{
                padding: 0 10px;
              }
              table#kd td ul {
                list-style: none;
                padding: 0;
                margin:0;
              }
              @media print {
                size: 8in 13in;
              }
            </style>
          </head>
          <body>
            <div class="page">
              <table id="kop">
                <tr>
                  <td><img src="/img/malangkab.png" width="75" /></td>
                  <td>
                    <h3>PEMERINTAH KABUPATEN MALANG</h3>
                    <h3>KOORWIL DINAS PENDIDIKAN KECAMATAN WAGIR<h3>
                    <h2>${this.$page.props.user.userable.sekolah.nama_sekolah}</h2>
                    <h3>NPSN: ${this.$page.props.user.userable.sekolah.npsn}</h3>
                    <p>${this.$page.props.user.userable.sekolah.alamat}</p>
                    <p>Email: ${this.$page.props.user.userable.sekolah.email}</p>
                  </td>
                </tr>
              </table>
              <h3>JURNAL PELAKSANAAN PEMBELAJARAN<h3>
              <h3>PENDIDIKAN AGAMA ISLAM<h3>
              <table id="meta" width="100%">
                <tr>
                  <td>Hari/Tanggal</td><td>:</td><td>${item.hari}, ${item.tanggal}</td><td>Kelas / Semester</td><td>:</td><td>${kelas[1]} / ${item.periode_id.substr(-1,1)}</td>
                </tr>
                <tr>
                  <td>Pembelajaran</td><td>:</td><td>${item.tema}</td><td>Alokasi Waktu</td><td>:</td><td>4 X 35 menit</td>
                </tr>
                <tr>
                  <td>Sub Pembelajaran</td><td>:</td><td>${item.subtema}</td><td>Tahun Pelajaran</td><td>:</td><td>${item.periode_id.substr(0,2)} / ${item.periode_id.substr(2,2)}</td>
                </tr>
              </table>
              <br />
              <table id="kd" width="100%" border="1" style="border-collapse:collapse;">
                <thead> 
                  <tr>
                    <th width="50%">KOMPETENSI DASAR</th><th>INDIKATOR PENCAPAIAN KOMPETENSI</th>
                  </tr>
                </thead>
                <tbody>
                  ${tr}
                </tbody>
              </table>
              <br />
              <table border="1" style="border-collapse:collapse;" width="100%">
                <thead>
                  <tr>
                    <th>Absensi Siswa</th><th>Catatan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="30%">${item.absensi_siswa}</td><td>${item.catatan}</td>
                  </tr>
                </tbody>
              </table>
              <div class="spacer" style="margin: 20px;"></div>
              <table width="100%">
                <tr>
                  <td width="40%" style="text-align: center;">
                    Mengetahui,<br />
                    Kepala Sekolah

                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b>${this.$page.props.user.userable.sekolah.nama_ks}</b></u><br />
                    NIP. ${this.$page.props.user.userable.sekolah.nip_ks}
                  </td>
                  <td width="20%">

                  </td>
                  <td width="40%" style="text-align: center;">
                    Wagir, ${item.tanggal} <br />
                    Guru PAI dan BP

                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b>${this.$page.props.user.userable.nama}</b></u><br />
                    NIP. ${this.$page.props.user.userable.nip}
                  </td>
                </tr>
              </table>
            </div>
          </body>
        </html>`
        let win = window.open('','', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0')
        win.document.write(html)
        setTimeout(() => {
          win.print()
        }, 500)
      })
      
    },
    simpan(){
      let date = new Date(), today = date.getDay(), hari = this.haris[today]
      let data = this.jurnal.data
      data.periode_id = this.$page.props.periode.kode_periode
      data.sekolah_id = this.$page.props.user.userable.sekolah.npsn
      data.guru_id = this.$page.props.user.userable_id
      data.hari = hari
      data.tanggal = date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate()
      data.kd_id = []
      // data.tema = data.tema.ke+'. '+data.tema.judul
      _.forEach(data.kds, function( item ) {
        data.kd_id.push(item.kode_kd)
      })
      axios({
        method: 'post',
        url: '/guru/jurnal/store',
        data: data
      }).then( res => {
        this.$refs.formJurnal.reset()
        this.jurnal.form = false
        this.getJurnals()
      })
    },
    setSub(e){
      let subs = e.sub.split(",")
      this.subs = subs
      this.getKds(e.kd_id, e.tingkat)
    },
    getKds(kds, tingkat ) {
      axios({
        method: 'post',
        url: '/guru/pembelajaran/kd?tingkat='+tingkat,
        data: {kds: kds.split(',')}
      }).then( res => {
        this.jurnal.data.kds = res.data.kds
        this.kds = res.data.kds
      })
    },
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
    },
    getJurnals() {
      this.jurnal.loading = true
      axios({
        method: 'post',
        url: '/guru/jurnal?guruId='+this.$page.props.user.userable_id+'&periode='+this.$page.props.periode.kode_periode
      }).then( res => {
        let jurnals = []
        res.data.jurnals.forEach((item,index) => {
          item.no = index+1
          jurnals.push(item)
        })
        this.jurnal.items = jurnals
        this.jurnal.loading = false
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
    },
    ipks() {
      return "Halo"
    }
  },
  created(){
    this.getJadwals()
    this.getJurnals()
  }
}
</script>