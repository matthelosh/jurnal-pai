<template>
    <v-app>
        <v-container style="background-image:url('/img/bg-front.jpg');background-size:cover;background-position:center center;" fluid fill-height class="pa-0">
            <v-img gradient="to top right, #45ff84dd, #6778fffe" height="100vh" width="100vw" >
                <v-container fluid fill-height>
                    <v-row>
                        <v-col class="hidden-sm-and-down"></v-col>
                        <v-col class="hidden-sm-and-down"></v-col>
                        <v-col class="d-flex justify-center">
                            <v-card  flat class="pa-5 loginBox" dark style="background:transparent;" :style="$vuetify.breakpoint.name == 'xs' ? 'border:0;':'border:1px solid white;'">
                                <v-card-text>
                                <h1 class="rtl text-center">بسم الله الرحمن الرحيم</h1>
                                <h3 class="text-center my-5">LOGIN</h3>
                                    <v-form ref="formLogin" @submit="login">
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field label="Username" v-model="user.username" append-icon="mdi-qrcode" :rules="rules.username" :error-messages="errors?errors.username[0]:''"></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field label="Password" :type="passwordOn ? 'password':''" :append-icon="passwordOn ? 'mdi-eye':'mdi-eye-off'" v-model="user.password" @click:append="passwordOn = !passwordOn" :rules="rules.password" :error-messages="(errors && errors.password) ? errors.password[0] : ''"></v-text-field>
                                            </v-col>
                                            <v-col class="d-flex justify-center">
                                                <v-btn color="white" outlined x-large type="submit">Login</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-img>
        </v-container>
    </v-app>
</template>

<script>
export default {
    name: 'Login',
    data: ()=>({
        user: {username:'', password:''},
        passwordOn: true,
        rules: {
            username: [v => !!v || 'Harus Diisi'],
            password: [v => !!v || 'Harus Diisi']
        },
        errors: null
    }),
    methods: {
        login(e){
            e.preventDefault()
            if(this.$refs.formLogin.validate()) {
                axios({
                    method: 'post',
                    url: '/login',
                    data: this.user
                }).then( res => {
                    if( res.status == 200) {
                        window.location.href='/dashboard'
                    }
                }).catch( err => {
                    console.log(err.response)
                    this.errors = err.response.data.errors
                })
            }
        }
    },
    computed: {},

}
</script>
