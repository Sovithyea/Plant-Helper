<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Guide</v-card-title>
                <v-card-subtitle>Fill the below form to edit the guides...</v-card-subtitle>
            </template>
        </v-card>
        <v-form lazy-validation ref="form" @submit.prevent="onSubmit" :disabled="form.submitting">
            <v-card>
                <v-card-subtitle>
                    <v-btn class="ma-1" outlined color="primary" @click="$router.go(-1)"><v-icon left>mdi-arrow-left</v-icon>{{ $t('Back') }}</v-btn>
                </v-card-subtitle>
                <!-- <v-card-subtitle class="mb-3">Fill the form bellow to create new user</v-card-subtitle> -->
                <v-card-text>
                    <v-row>
                        <v-col class="py-0" cols="12">
                            <v-list-item class="px-0 mb-5">
                                <v-list-item-avatar size="128" tile color="grey">
                                    <v-img v-if="!form.data.avatar" :src="constants.storagePath + form.additional.avatar" contain></v-img>
                                    <v-img v-else :src="form.additional.avatar" contain></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-file-input
                                        v-model="form.data.avatar"
                                        @change="onInputFile"
                                        show-size
                                        prepend-icon=""
                                        prepend-inner-icon="mdi-image"
                                        accept="image/*"
                                        outlined
                                        :label="$t('Avatar')">
                                    </v-file-input>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <v-autocomplete
                                v-model="form.data.crop_id"
                                :items="crops"
                                item-text="name"
                                item-value="id"
                                clearable
                                required
                                :rules="[v => !!v || $t('Crop is required')]"
                                outlined
                                :label="$t('Crop')">
                            </v-autocomplete>
                        </v-col>
                        <v-col class="py-0" cols="12" sm="12">
                            <v-text-field
                                v-model="form.data.name"
                                required
                                :rules="[v => !!v || $t('Name is required')]"
                                outlined
                                :label="$t('Name')">
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <v-autocomplete
                                v-model="form.data.stage"
                                :items="stages"
                                type="text"
                                item-text="label"
                                item-value="value"
                                clearable
                                required
                                :rules="[v => !!v || $t('Stage is required')]"
                                outlined
                                :label="$t('Stage')">
                            </v-autocomplete>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <!-- <text-editor v-model="form.data.detail" :label="'Solution (Optional)'"></text-editor> -->
                            <text-editor v-model="form.data.detail" :label="'Description (Optional)'"/>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions class="px-4 pb-4">
                    <v-btn type="submit" color="success" :loading="form.submitting"><v-icon left>mdi-checkbox-marked-circle-outline</v-icon>Save</v-btn>
                    <!-- <v-btn color="secondary" @click="$router.go(-1)"><v-icon left>mdi-cancel</v-icon>Cancel</v-btn> -->
                </v-card-actions>
            </v-card>
        </v-form>
    </v-container>
</template>
<script>

import constants from '../../constants'
import axiosApiInstance from '../../utilites'
export default {
    data: () => ({
        loading: true,
        current_date: null,
        constants: constants,
        form: {
            model: {},
            submitting: false,
            data: {
                name: null,
                detail: '',
                avatar: null,
                crop_id: null,
                stage: null,
            },
            additional: {
                avatar: null,
            }
        },
        crops: [

        ],
        stages: [
            {
                label: 'Nursery',
                value: 1
            },
            {
                label: 'Planting',
                value: 2
            }
        ]
    }),

    mounted()
    {
        this.fetchData()
    },

    methods:
    {
        async fetchData()
        {
            axiosApiInstance.get(`activity/${ this.$route.params.activity }/edit`)
            .then(response => {
                // console.log(response.data);
                this.form = response.data;
                this.crops = response.data[0];
                // console.log(this.form.additional.avatar);
                // console.log(response);
                // console.log(this.form);
            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.loading = false
            })
        },
        onInputFile(e)
        {
            if (e) this.form.additional.avatar = URL.createObjectURL(e)
            else this.form.additional.avatar = null
        },

        onSubmit()
        {
            if (this.$refs.form.validate())
            {
                this.form.submitting = true
                let formData = new FormData()
                formData.append('_method', 'PUT')
                if (this.form.data.avatar) formData.append('avatar', this.form.data.avatar)
                if (this.form.data.detail) formData.append('detail', this.form.data.detail)
                formData.append('name', this.form.data.name)
                formData.append('crop_id', this.form.data.crop_id)
                formData.append('stage', this.form.data.stage)
                axiosApiInstance.post(`activity/${ this.$route.params.activity }`, formData, {
                    headers: { "Content-Type": "multipart/form-data"}
                })
                .then(response => {
                    this.$store.dispatch('pushNotification', { message: response.data.message, type: 'success' })
                    this.$router.go(-1)
                })
                .catch(({ response }) => {
                    this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
                })
                .finally(() => {
                    this.form.submitting = false
                })
            }
        }

        // keyDown(e)
        // {
        //     var charCode = e.keyCode
        //     console.log(e)
        //     if (charCode < 8 || charCode > 9 && charCode < 16 || charCode > 20 && charCode < 33 || charCode > 40 && charCode < 45 || charCode == 47 || charCode > 57 && charCode < 61 || charCode > 61 && charCode < 91 || charCode > 91) e.preventDefault();
        // }
    }

}
</script>
