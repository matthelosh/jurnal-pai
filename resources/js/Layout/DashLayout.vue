<template>
    <v-app id="dash">
        <v-app-bar app  color="white" clipped-left elevation="1">
            <v-app-bar-title class="body-1" v-html="pageTitle ? pageTitle : 'Dashboard'"></v-app-bar-title>
            <v-spacer></v-spacer>
            <v-app-bar-nav-icon @click="sidebar = !sidebar" class="hidden-sm-and-up"></v-app-bar-nav-icon>
        </v-app-bar>
        <v-navigation-drawer class="mr-1" v-model="sidebar" app clipped>
            <!-- <v-list-item  style="background:teal;box-shadow: 0 4px 5px rgba(0,0,0,0.3);color:white;">
                <v-list-item-title><h3>JURNAL PAI <small>KKG WAGIR</small></h3></v-list-item-title>
            </v-list-item> -->
            <!-- <v-divider class="white"></v-divider> -->
            <v-list dense shaped>
                <v-subheader>MENU</v-subheader>
                <!-- <inertia-link as="v-list-item"
                    v-for="(menu,i) in $page.props.menus" :key="i"
                    :href="menu.url == '#' ? '#' : route($page.props.user.role+'.'+menu.url)"
                    :class="isActive(menu.url)"
                    class="my-1"
                >
                    <v-list-item-avatar class="ma-0">
                        <v-icon >{{ menu.icon }}</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-title>{{menu.label}}</v-list-item-title>
                </inertia-link> -->
                <v-list-item-group v-for="(menu,i) in $page.props.menus" :key="i"> 
                    <v-list-group v-if="menu.subs.length > 0" :prepend-icon="menu.icon" :value="check(menu)" active-class="aktif-parent" @error="ruteError">
                        <template v-slot:activator>
                            <v-list-item-title>{{ menu.label }}</v-list-item-title>
                        </template>
                        <inertia-link as="v-list-item" v-for="(sub, s) in menu.subs" :key="s" :href="route($page.props.user.role+'.'+sub.url)" :class="isActive(sub.url)">
                                <v-list-item-avatar class="ma-0">
                                <v-icon >{{ sub.icon }}</v-icon>
                            </v-list-item-avatar>
                        <v-list-item-title>{{sub.label}}</v-list-item-title>
                        </inertia-link>
                    </v-list-group>
                    <inertia-link v-else as="v-list-item"
                        :href="menu.url == '#' ? '#' : route($page.props.user.role+'.'+menu.url)"
                        :class="isActive(menu.url)"
                        class="my-1"
                        :prepend-icon="menu.icon"
                    >
                        <!-- <v-list-group :prepend-icon="menu.icon"> -->
                            <!-- <v-list-item> -->
                                <v-list-item-icon><v-icon>{{menu.icon}}</v-icon></v-list-item-icon>
                                <v-list-item-title>{{menu.label}}</v-list-item-title>
                            <!-- </v-list-item> -->
                        <!-- </v-list-group> -->
                            
                    </inertia-link>
                </v-list-item-group>
                <v-divider></v-divider>
                <inertia-link as="v-list-item" method="post" href="/logout" >
                    <v-list-item-avatar>
                        <v-icon >mdi-exit-to-app</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-title >Keluar</v-list-item-title>
                </inertia-link>
            </v-list>
        </v-navigation-drawer>
        <v-main style="background: #efeeff;" app>
            
            <!-- <transition name="fade" v-bind="$attrs" v-on="$listeners"> -->
                <slot />
            <!-- </transition> -->
        </v-main>
        <div id="loading" class="d-flex align-center justify-center" v-if="loading">
            <span>
                <v-icon class="mdi-spin text-h1">mdi-loading</v-icon>
                <h3 class="text-center mt-5">Mohon tunggu</h3>
            </span>
        </div>
    </v-app>
</template>

<script>
export default {
    name:'Dashboard',
    props: {pageTitle: String, loading: Boolean,menus: Array },
    data: () => ({
        sidebar: true,
        isLoading: true,
    }),
    methods: {
        ruteError(e) {
            console.log(e)
        },
        check(menu) {
            let subs = menu.subs
            let rute = this.route().current()
            let t = rute.split('.')
            let aktif = false
            subs.forEach(sub => {
                if(sub.url == t[1]) aktif = true
            })

            return aktif
        },
        logout(){
            axios.post('/logout').then(res=>{
                window.location.href = '/'
            })
        },
        isActive(url) {
            let text = url.split('/')
            let rute = this.route().current().split('.')
            return (rute[rute.length-1] == text[text.length -1]) ? 'aktif' : ''
        },
        tes(menu){
            alert(menu.url)
        }
    },
    computed: {
        // menus(){
        //     const datas = this.$page.props.menus
        //     let menus = datas.filter(menu => {
        //         menu.url = (menu.url != '/dashboard') ? '/'+this.$page.props.user.role+menu.url :'/dashboard'
        //         return menu.role.includes(this.$page.props.user.role)
        //     })

        //     return menus
        // },
        route() {
            return window.route
        },
        

    },
    beforeMount(){
        // this.loading = true
    },
    mounted() {
        // this.loading = false
    }
}
</script>

<style>
    #loading{
        position: fixed;
        width: 100vw;
        height: 100vh;
        background: rgba(60, 61, 60, 0.678);
    }
    #loading i, #loading h3 {
        animation: coloring 5s infinite ease-in-out;
    }

    @keyframes coloring {
        0%      { color: rgb(255, 192, 203); transition: color .35s;}
        20%     { color: rgb(155, 241, 241); transition: color .35s;}
        40%     { color: rgb(199, 199, 250); transition: color .35s;}
        60%     { color: rgb(252, 182, 252); transition: color .35s;}
        80%    { color: rgb(253, 241, 173); transition: color .35s;}
        100%    { color: rgb(255, 192, 203); transition: color .35s;}
    }
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
        background-image: linear-gradient(to bottom left, rgba(27, 34, 34, 0.159), rgba(43, 44, 46, 0.097));
    }
    .aktif-parent{
        /* background: linear-gradient(to right, rgba(46, 48, 48, 0.042),rgba(39, 34, 35, 0.07)); */
        /* box-shadow: 0 1px 1px rgba(241, 239, 239, 0.816); */
        /* border-bottom: 1px solid rgb(175, 172, 172); */
        transition: all .35s ease-in;
    }
    .aktif {
        background: linear-gradient(to right, rgba(126, 192, 192, 0.5), rgba(247, 212, 218, 0.487));
        box-shadow: inset 0 3px 5px rgba(177, 174, 174, 0.479);
        transition: all .35s ease-in;
    }

    .slide-fade-enter-active {
        transition: all 3s ease;
    }
    .slide-fade-leave-active {
        transition: all 3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(100px);
        opacity: 0;
    }

    .btnPrimary {
    color: white;
    background: linear-gradient(to right, rgb(47, 174, 206),rgb(219, 78, 102));
  }
  .btnSubmit {
    color: white;
    background: linear-gradient(to right, rgb(18, 91, 185),rgb(76, 129, 179));
  }
  .itemLink {
    text-decoration: none;
    color: transparent;
    background-image: linear-gradient(to right, rgb(189, 75, 170),rgb(219, 78, 102) );
    background-clip: text;
  }

  .grad-prim {
        background: #1D976C;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to top right, #93f9b885, #1d976c85);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to top right, #93f9b877, #1d976c70); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

  }

</style>