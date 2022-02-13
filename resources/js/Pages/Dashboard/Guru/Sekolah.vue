<template>
  <dash-layout :loading="loading" :pageTitle="'<span class=\'mdi mdi-city-variant-outline\'></span> Sekolah'">
    <div>
      <v-toolbar>
        <v-btn icon @click="sidebar = !sidebar"><v-icon>mdi-menu</v-icon></v-btn>
        <v-spacer></v-spacer>
        <v-spacer></v-spacer>
        <v-btn class="btnPrimary" rounded @click="form = !form"> {{ !form ? 'Edit' : 'Selesai' }}</v-btn>
      </v-toolbar>
      <v-expand-transition mode="in-out">
        <v-row v-show="form" v-if="form">
          <v-col>
            <v-card color="grey lighten-2" tile>
              <v-card-text>
                <v-form ref="formSekolah" @submit.prevent="simpan">
                  <v-row>
                    <v-col cols="12" sm="2">
                      <v-text-field v-model="sekolah.telp" label="No. Telepon" prepend-inner-icon="mdi-phone" solo dense :rules="required"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-text-field v-model="sekolah.email" label="Email" prepend-inner-icon="mdi-email" solo dense></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-text-field v-model="sekolah.website" label="Website" prepend-inner-icon="mdi-web" solo dense></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-text-field v-model="sekolah.nama_ks" label="Kepala Sekolah" prepend-inner-icon="mdi-account-tie" solo dense :rules="required"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-text-field v-model="sekolah.nip_ks" label="NIP Kepala Sekolah" prepend-inner-icon="mdi-barcode" solo dense ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2">
                      <v-btn class="btnSubmit" type="submit" rounded block dark>Simpan</v-btn>
                    </v-col>
                    
                  </v-row>
                </v-form>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-expand-transition>
      <v-expand-transition>
      <v-container v-show="!form">
        <v-col>
          <v-card>
            <v-card-title><v-icon>mdi-city-variant-outline</v-icon> Data Sekolah</v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item>
                  <v-list-item-avatar><v-icon>mdi-label</v-icon></v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>Nama Sekolah</v-list-item-subtitle>
                    <v-list-item-title>{{ sekolah.nama_sekolah }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-avatar><v-icon>mdi-qrcode</v-icon></v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>NPSN</v-list-item-subtitle>
                    <v-list-item-title>{{ sekolah.npsn }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-avatar><v-icon>mdi-map-marker</v-icon></v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>Alamat Sekolah</v-list-item-subtitle>
                    <v-list-item-title class="text-wrap">{{ sekolah.alamat }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-avatar><v-icon>mdi-phone</v-icon></v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>No. Telepon</v-list-item-subtitle>
                    <v-list-item-title class="text-wrap">{{ sekolah.telp }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-avatar><v-icon>mdi-email</v-icon></v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>Email</v-list-item-subtitle>
                    <v-list-item-title class="text-wrap">{{ sekolah.email }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-avatar><v-icon>mdi-web</v-icon></v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>Website</v-list-item-subtitle>
                    <v-list-item-title class="text-wrap">{{ sekolah.website }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-avatar><v-icon>mdi-account-tie</v-icon></v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>Kepala Sekolah</v-list-item-subtitle>
                    <v-list-item-title class="text-wrap">{{ sekolah.nama_ks }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-avatar><v-icon>mdi-barcode</v-icon></v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>NIP Kepala Sekolah</v-list-item-subtitle>
                    <v-list-item-title class="text-wrap">{{ sekolah.nip_ks }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
      </v-container>
      </v-expand-transition>
    </div>
  </dash-layout>
</template>

<script>
import DashLayout from '../../../Layout/DashLayout'
export default {
  name: 'GuruSekolah',
  components: { DashLayout },
  data: () => ({
    form: false,
    loading: false,
    sekolah: {},
    required: [v => !!v || 'Harus Diisi']
  }),
  methods: {
    simpan(){
      this.loading  = true
      axios({
        method: 'put',
        url: '/guru/sekolah/',
        data: this.sekolah
      }).then( res => {
        this.getMySchool()
        this.form = false
        this.loading = false
      })
    },
    getMySchool(){
      this.loading = true
      axios({
        method: 'post',
        url: '/guru/sekolah/'+this.$page.props.user.userable.sekolah_id
      }).then( res => {
        this.sekolah= res.data.sekolah
        this.loading = false
      })
    }
  },
  created() {
    this.getMySchool()
  }
}
</script>