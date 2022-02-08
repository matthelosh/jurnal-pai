<template>
    <front-layout :pageTitle="pageTitle">
        <v-img src="/img/bg-front.jpg" gradient="to top right, #34ff56df, #0078ff" width="100vw" min-height="100vh">
            <v-container fill-height align="center" justify="center">
                <v-row>
                    <v-col>
                        <h2 class="text-center white--text my-3">Tentang Jurnal PAI Kec. Wagir</h2>
                        <p class="text-justify white--text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum vitae illo delectus ex eius quo consequuntur rerum similique. Similique dolor corrupti fugit odit vel illo error iure fugiat obcaecati nostrum?</p>
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
