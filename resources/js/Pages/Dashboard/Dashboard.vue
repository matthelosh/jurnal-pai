<template>
    <dash-layout>
        <v-container>
            <v-row>
                <v-col></v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="4">
                    <v-card tile elevation="5">
                        <v-card-text>
                            <v-card-title>Halo {{route().current()}}</v-card-title>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-dialog 
            max-width="600"
            v-model="errors['403']"
            v-if="errors['403']"
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
    components: { DashLayout },
    data: () => ({

    }),
    computed: {
        route() {
            return window.route
        }
    }
}
</script>