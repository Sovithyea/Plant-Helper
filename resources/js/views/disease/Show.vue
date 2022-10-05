<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Diseases</v-card-title>
                <v-card-subtitle>Disease Detail</v-card-subtitle>
            </template>
        </v-card>
        <v-card>
            <v-card-subtitle>
                <v-btn class="ma-1" outlined color="primary" @click="$router.go(-1)"><v-icon left>mdi-arrow-left</v-icon>Back</v-btn>
                <v-btn class="ma-1" color="warning" :to="{ name: 'disease.edit' }"><v-icon left>mdi-pencil-box-outline</v-icon>{{ $t('Edit Disease') }}</v-btn>
            </v-card-subtitle>
            <v-card-text v-if="!loading">
                <v-row justify="center">
                    <v-col cols="12" md="4">
                        <v-card elevation="0">
                            <v-card-subtitle class="text-center">
                                <!-- <v-avatar size="86" color="grey">

                                    <span class="text-h5" v-else>{{ model.first_name[0].toUpperCase() + ' ' + model.last_name[0].toUpperCase() }}</span>
                                </v-avatar> -->
                                <v-img v-if="model.avatar" contain :src="constants.storagePath + model.avatar" width="150px" height="150px"></v-img>
                                <!-- <div class="text-subtitle-2 mt-5">{{ model.first_name + ' ' + model.last_name }}</div> -->
                            </v-card-subtitle>
                            <v-list-item dense>
                                    <v-list-item-icon class="font-weight-bold error--text">
                                        <!-- <v-icon>mdi-email-outline</v-icon> -->
                                        Disease's name:
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{model.name}}</v-list-item-title>
                                        <!-- <v-list-item-subtitle>{{ $t('First Name') }}</v-list-item-subtitle> -->
                                    </v-list-item-content>
                            </v-list-item>

                        </v-card>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-card-text>

                            <v-list-item dense>
                                    <v-list-item-icon class="font-weight-bold success--text">
                                        <!-- <v-icon>mdi-email-outline</v-icon> -->
                                        Active on crop:
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{model.crop.name}}</v-list-item-title>
                                        <!-- <v-list-item-subtitle>{{ $t('First Name') }}</v-list-item-subtitle> -->
                                    </v-list-item-content>
                            </v-list-item>
                                <v-list-item dense>
                                    <v-list-item-icon class="font-weight-bold primary--text">
                                        <!-- <v-icon>mdi-email-outline</v-icon> -->
                                        diagnosis:
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <!-- <v-list-item-title class="pt-1"> -->
                                            <p v-html="model.diagnosis"></p>
                                        <!-- </v-list-item-title> -->
                                        <!-- <v-list-item-subtitle>{{ $t('Last Name') }}</v-list-item-subtitle> -->
                                    </v-list-item-content>
                                </v-list-item>


                            </v-card-text>


                    </v-col>
                </v-row>
                <v-list-item dense>
                                    <v-list-item-icon class="font-weight-bold primary--text">
                                        <!-- <v-icon>mdi-email-outline</v-icon> -->
                                        Cause:
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <p v-html="model.cause" class="pt-1"></p>
                                        <!-- <v-list-item-subtitle>{{ $t('Email') }}</v-list-item-subtitle> -->
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item dense>
                                    <v-list-item-icon class="font-weight-bold primary--text">
                                        <!-- <v-icon>mdi-email-outline</v-icon> -->
                                        Solution:
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <p v-html="model.solution" class="pt-1"></p>
                                        <!-- <v-list-item-subtitle>{{ $t('Username') }}</v-list-item-subtitle> -->
                                    </v-list-item-content>
                                </v-list-item>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
import constants from '../../constants'
import axiosApiInstance from '../../utilites'
export default {
    data: () => ({
        loading: true,
        constants: constants,
        model: {}
    }),

    mounted()
    {
        this.fetchData()
    },

    methods:
    {
        fetchData()
        {
            axiosApiInstance.get(`disease/${ this.$route.params.disease }`)
            .then(response => {
                this.model = response.data
                // console.log(response.data);
            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
