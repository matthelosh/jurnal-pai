<template>
  <div>
    <v-card>
        <v-card-title>Silabus <v-spacer></v-spacer><v-btn small rounded color="primary" @click="dialog=true">Tambah</v-btn></v-card-title>
        <v-card-text>
          Halo
        </v-card-text>
    </v-card>
    <v-dialog fullscreen transition="dialog-bottom-transition" v-model="dialog" scrollable>
      <v-card>
        <v-card-title class="ma-0 pa-0">
          <v-toolbar dense color="primary">Silabus
            <v-spacer></v-spacer>
            <v-btn fab small color="error" @click="dialog=false"><v-icon>mdi-close</v-icon></v-btn>
          </v-toolbar>
        </v-card-title>
        <v-card-text>
          <v-form ref="formSilabus" class="my-5">
            <v-row>
              <v-col cols="12" sm="2">
                <v-select v-model="silabus.kelas" label="Kelas" :items="['1','2','3','4','5','6']" @change="getKds"></v-select>
              </v-col>
              <v-col cols="12" sm="2">
                <v-select multiple v-model="silabus.pertemuan" label="Pertemuan" :items="['1','2','3','4','5','6','7','8,','9','10','11','12','13','14','15','16','17','18','19','20']"></v-select>
              </v-col>
              <v-col cols="12" sm="8">
                <v-select label="KD" :items="kds" v-model="silabus.kd_id" multiple item-value="kode_kd" @blur="getIndikators">
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
              <v-col cols="12" sm="3">
                <v-text-field v-model="silabus.waktu" label="Alokasi Waktu"></v-text-field>
              </v-col>
              <v-col cols="12" sm="3">
                <v-text-field v-model="silabus.penilaian" label="Penilaian"></v-text-field>
              </v-col>
              <v-col cols="12" sm="3">
                <v-text-field v-model="silabus.karakter" label="Karakter"></v-text-field>
              </v-col>
              <v-col cols="12" sm="3">
                <v-text-field v-model="silabus.keterangan" label="Keterangan"></v-text-field>
              </v-col>
              <v-col cols="12" sm="8">
                <p>Proses Pembelajaran</p>
                <!-- <input type="file" accept="image/*" id="img" @change="filePicked" class="d-none" /> -->
                <quill-editor v-model="silabus.proses" :options="QEProsesOpt" style="background: #efefefcf;color: #333;" ref="QEProses" ></quill-editor>
              </v-col>
              <v-col cols="12" sm="4">
                <p>Media Pembelajaran</p>
                <quill-editor v-model="silabus.media" :options="QEMediaOpt" style="background: #efefefcf;color: #333;" ref="QEMedia" ></quill-editor>
              </v-col>
              <v-col cols="12">
                <v-btn type="submit" color="primary" block>Simpan</v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: 'AdminSilabus',
  data: () => ({
    
    dialog: false,
    silabus: {},
    kds: [],
    QEProsesOpt: {
            modules: {
                toolbar: {
                    container: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'font': [] }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        ['clean'],
                        [
                          'link',
                        //  'image'
                         ]
                    ],
                    handlers: {
                        // image: () => {
                        //     document.querySelector('#img').click()
                            // this.filePicked()
                        // }
                    }
                },
                // imageResize: {
                //     modules: ["Resize", "DisplaySize", "Toolbar"]
                // }
            }
        },
        QEMediaOpt: {
            modules: {
                toolbar: {
                    container: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        [
                          'link',
                        //  'image'
                         ]
                    ],
                    handlers: {
                        // image: () => {
                        //     document.querySelector('#img').click()
                            // this.filePicked()
                        // }
                    }
                },
                // imageResize: {
                //     modules: ["Resize", "DisplaySize", "Toolbar"]
                // }
            }
        }
  }),
  methods: {
    // filePicked(e){
    //   const quill = this.$refs.quillEdit.quill
    //   var range = quill.selection.lastRange
    //   const img = e
    //   let url = URL.createObjectURL(e.target.files[0])
    //   // console.log(url)
    //   var image = `<img src="${url}" width="50" />`
    //   const delta = quill.clipboard.convert(image)
    //   quill.root.innerHTML = image
    // },
    getKds(e){
      axios({
        method: 'post',
        url: '/admin/perangkat/get?tipe=kd&tingkat='+e+'&semester='+this.semester
      }).then( res => {
        this.kds = _.orderBy(res.data.kds, kd => kd.kode_kd.substr(2,1))
      })
    },
    getIndikators(){
      let kds = this.silabus.kd_id
      axios({
        method: 'post',
        url: '/admin/perangkat/get?tipe=indikator&tingkat='+this.silabus.kelas,
        data: {kds: kds}
      }).then(res => {
        console.log(res)
      })
    }
  }
}
</script>