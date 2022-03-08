<template>
  <dash-layout>
    <v-container>
      <v-row>
        <v-col>
          <v-card>
            <v-toolbar
              color="cyan"
              dark
              flat
            >
              <v-icon>mdi-cogs</v-icon>

              <v-toolbar-title>&nbsp; Pengaturan</v-toolbar-title>

              <v-spacer></v-spacer>

              <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
              </v-btn>

              <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>

              <template v-slot:extension>
                <v-tabs
                  v-model="tab"
                  align-with-title
                >
                  <v-tabs-slider color="yellow"></v-tabs-slider>

                  <v-tab>
                    <v-icon>mdi-calendar</v-icon>
                    Periode
                  </v-tab>
                  <v-tab>
                    <v-icon>mdi-menu-open</v-icon>
                    Menu
                  </v-tab>
                </v-tabs>
              </template>
            </v-toolbar>
            <v-tabs-items v-model="tab">
              <v-tab-item>
                <v-card flat>
                  <v-card-title>
                      <v-icon>mdi-calendar</v-icon>
                      Periode
                      <v-spacer></v-spacer>
                      <v-btn small rounded color="primary" @click="periode.form = !periode.form">{{ periode.form ? 'Selesai' :'Tambah'}}</v-btn>
                  </v-card-title>
                  <v-card-text >
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
              </v-tab-item>
              <v-tab-item>
                <v-card flat>
                  <v-card-title>
                      <v-icon>mdi-menu-open</v-icon>
                      Menu
                      <v-spacer></v-spacer>
                      <v-btn small rounded color="primary" @click="menu.form = !menu.form">{{ menu.form ? 'Selesai' :'Tambah'}}</v-btn>
                  </v-card-title>
                  <v-card-text >
                    <v-expand-transition>
                      <v-form ref="formMenu" @submit.prevent="simpanMenu" v-if="menu.form">
                        <v-container>
                          <v-row>
                            <v-col>
                              <v-select label="Parent" v-model="menu.data.parent_id" dense :items="parents" item-text="label" item-value="id"></v-select>
                            </v-col>
                            <v-col>
                              <v-text-field label="Label" v-model="menu.data.label" dense></v-text-field>
                            </v-col>
                            <v-col>
                              <v-text-field label="Ikon" v-model="menu.data.icon" dense></v-text-field>
                            </v-col>
                            <v-col>
                              <v-text-field label="URL" v-model="menu.data.url" dense></v-text-field>
                            </v-col>
                            <v-col>
                              <v-select label="Role" v-model="menu.data.role" multiple :items="['admin','guru','pengawas']" dense></v-select>
                            </v-col>
                            <v-col>
                              <v-btn type="submit" small color="info" rounded :loading="menu.loading">Simpan</v-btn>
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
                      :items="menu.items" :headers="menu.headers" no-data-text="Kosong" :loading="menu.loading"
                    >
                      <template v-slot:[`item.label`]="{item}">
                        <a href="#" @click="editMenu(item)" block>{{item.label}}</a>
                      </template>
                      <template v-slot:[`item.icon`]="{item}">
                        <v-icon>{{ item.icon }}</v-icon>
                      </template>
                      <template v-slot:[`item.opsi`]="{item}">
                        <v-btn icon @click="hapusMenu(item)" color="error" ><v-icon>mdi-delete</v-icon></v-btn>
                      </template>
                    </v-data-table>
                  </v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs-items>

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
    tab:null,
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
    menu: {
      form: false,
      data: {},
      loading: false,
      items: [],
      headers: [
        { text: 'Label', value: 'label'},{ text: 'Ikon', value: 'icon'},{ text: 'URL', value: 'url'},{ text: 'Role', value: 'role'}, { text: 'Opsi', value: 'opsi'}
      ],
    },
    tes: '',
    tapels: ['2021-2022', '2022-2023','2023-2024','2024-2025'],
  }),
  methods: {
    editMenu(menu){
      this.menu.form=true
      menu.role = menu.role.split(',')
      this.menu.data = menu
      // this.menu.data.role = menu.role.split(',')
    },
    hapusMenu(menu) {
      this.menu.loading = true
      let label = menu.label
      axios({
        method: 'delete',
        url: '/admin/menu/'+menu.id
      }).then( res => {
        alert('Menu '+label + ' Dihapus')
        this.menu.loading = false
        this.getMenus()
      })
    },
    simpanMenu(){
      this.menu.loading = true
      axios({
        method: 'post',
        url: '/admin/menu/store',
        data: this.menu.data
      }).then(res => {
        this.getMenus()
        this.$refs.formMenu.reset()
        this.menu.loading = false
      }).catch(err => {
        this.menu.loading = false
      })
    },
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
    },
    getMenus() {
      this.menu.loading = true
      axios({
        method: 'post',
        url: '/admin/menu'
      }).then( res => {
        this.menu.items = res.data.menus
        this.menu.loading = false
      })
    }
  },
  computed: {
    parents() {
      const menus = this.menu.items
      let parents = menus.filter(menu => {
        return menu.parent_id == '0'
      })

      return parents
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
    this.getMenus()
  }

}
</script>