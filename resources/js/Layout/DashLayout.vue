<template>
    <v-app id="dash">
        <v-app-bar app dense color="green darken-3" dark>
            <v-app-bar-title>Dashboard</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-app-bar-nav-icon @click="sidebar = !sidebar" class="hidden-sm-and-up"></v-app-bar-nav-icon>
        </v-app-bar>
        <v-navigation-drawer app class="prim-grad" v-model="sidebar">
            <v-list color="#333333dd" dense class="py-1">
            <v-list-item class="white--text" dense >
                <v-list-item-avatar class="my-0">
                    <v-icon class="white--text">mdi-book-open</v-icon>
                </v-list-item-avatar>
                <v-list-item-title>JURNAL</v-list-item-title>
            </v-list-item>
            </v-list>
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
        background-image: linear-gradient(to top right, rgba(0, 255, 187, 0.864), rgb(30, 112, 71));
    }
</style>