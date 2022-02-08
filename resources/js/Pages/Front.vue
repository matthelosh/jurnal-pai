<template>
    <front-layout :pageTitle="pageTitle">
        <v-img src="/img/bg-front.jpg" gradient="to top right, #34ff56df, #0078ff" width="100vw" height="100vh">
            <v-container fill-height align="center" justify="center">
                <v-row>
                    <v-col>
                        <h1 class="text-center white--text">Assalamualaikum</h1>
                    </v-col>
                </v-row>
            </v-container>
        </v-img>
    </front-layout>    
</template>

<script>
import FrontLayout from '../Layout/FrontLayout'
export default {
    name: 'Front',
    components: { FrontLayout },
    props: { pageTitle: String},
}
</script>
