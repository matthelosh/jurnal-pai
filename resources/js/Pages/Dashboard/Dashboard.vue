<template>
    <dash-layout>
        <v-container>
            Halo
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos mollitia et officiis nostrum deleniti atque ipsum omnis illum, fugiat natus voluptatem dolore? Nisi aperiam ex molestiae eveniet aliquam! Assumenda, aliquid?
        </v-container>
        <v-dialog 
            max-width="600"
            v-model="errors['403']"
        >
            <v-card color="error" dark height="100" class="d-flex align-center">
                <v-card-text class="d-flex align-center justify-center" fill-height>
                    <h3 class="text-center ma-0 pa-0">{{errors['403'].msg}}</h3>
                </v-card-text>
            </v-card>
        </v-dialog>
    </dash-layout>
</template>

<script>
import DashLayout from '../../Layout/DashLayout'
export default {
    name: 'Dashboard',
    props: { errors: Object },
    components: { DashLayout }
}
</script>