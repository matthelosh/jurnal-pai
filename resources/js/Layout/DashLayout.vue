<template>
    <v-app id="dash">
        <v-app-bar app dense color="primary" dark>
            <v-app-bar-title>{{ pageTitle ? pageTitle : 'Dashboard' }}</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-app-bar-nav-icon @click="sidebar = !sidebar" class="hidden-sm-and-up"></v-app-bar-nav-icon>
        </v-app-bar>
        <v-navigation-drawer app class="prim-grad" v-model="sidebar">
            <v-list-item class="white--text" dense >
                <v-list-item-title><h3>JURNAL PAI <small>KKG WAGIR</small></h3></v-list-item-title>
            </v-list-item>
            <v-divider class="white"></v-divider>
            <v-list dense>
                <inertia-link as="v-list-item"
                    v-for="(menu,i) in menus" :key="i"
                    :href="menu.url"
                    class="white--text"
                >
                    <v-list-item-avatar>
                        <v-icon color="white">{{ menu.icon }}</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-title>{{menu.label}}</v-list-item-title>
                </inertia-link>
                <v-divider color="white" inset></v-divider>
                <inertia-link as="v-list-item" @click="logout" >
                    <v-list-item-avatar>
                        <v-icon color="white">mdi-exit-to-app</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-title class="white--text">Keluar</v-list-item-title>
                </inertia-link>
            </v-list>
        </v-navigation-drawer>
        <v-main>
            <slot />
        </v-main>
        
        
        
    </v-app>
</template>

<script>
export default {
    name:'Dashboard',
    props: {pageTitle: String },
    data: () => ({
        sidebar: true,
    }),
    methods: {
        logout(){
            axios.post('/logout').then(res=>{
                window.location.href = '/'
            })
        }
    },
    computed: {
        menus(){
            const datas = this.$page.props.menus
            let menus = datas.filter(menu => {
                menu.url = (menu.url != '/dashboard') ? '/'+this.$page.props.user.role+menu.url:'/dashboard'
                return menu.role.includes(this.$page.props.user.role)
            })

            return menus
        }
    }
}
</script>

<style scoped>
    .prim-grad {
        
        background: url('/img/bg-front.jpg');
        background-size: cover;
        background-position: center center;
    }
    .prim-grad::before{
        z-index: -1;
        width: 100%;
        height: 100%;
        content: '';
        position: absolute;
        background-image: linear-gradient(to bottom left, rgba(15, 174, 179, 0.933), rgb(32, 85, 184, 0.95));
    }
</style>