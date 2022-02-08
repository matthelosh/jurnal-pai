<template lang="html">
    <v-app id="app">
        <v-app-bar app
      color="transparent"
      flat
      
      dark
    >
      

      <v-toolbar-title>{{ pageTitle }}</v-toolbar-title>

      <v-spacer></v-spacer>
      <v-app-bar-nav-icon @click="sidebar=!sidebar"></v-app-bar-nav-icon>

    </v-app-bar>
        
        <v-navigation-drawer  right app v-model="sidebar" color="transparent" dark> 
            <v-img gradient="to top right, #45ffac78, #679887" height="100vh">
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-h6">Menu</v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-action>
                        <v-btn icon color="warning" @click="sidebar=!sidebar"><v-icon>mdi-close</v-icon></v-btn>
                    </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <v-list>
                    <inertia-link as="v-list-item" href="/">
                        <v-list-item-icon><v-icon>mdi-home-outline</v-icon></v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Beranda</v-list-item-title>
                        </v-list-item-content>
                    </inertia-link>
                    <inertia-link as="v-list-item" href="/tentang">
                        <v-list-item-icon><v-icon>mdi-information-outline</v-icon></v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Tentang Jurnal</v-list-item-title>
                        </v-list-item-content>
                    </inertia-link>
                    <inertia-link as="v-list-item" href="/login">
                        <v-list-item-icon><v-icon>mdi-lock</v-icon></v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Login</v-list-item-title>
                        </v-list-item-content>
                    </inertia-link>
                </v-list>
            </v-img>
        </v-navigation-drawer>
        <slot />
    </v-app>
</template>

<script>
export default {
    name: 'FrontLayout',
    props: {pageTitle: String},
    data: () => ({
        sidebar: false,

    }),
    computed: {
        titlePage(){
            return this.$pageTitle
        }
    }
}
</script>
