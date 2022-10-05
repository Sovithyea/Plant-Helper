<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Diseases</v-card-title>
                <v-card-subtitle>Fill the below form to create new disease.</v-card-subtitle>
            </template>
        </v-card>
        <v-form lazy-validation ref="form" @submit.prevent="onSubmit" :disabled="form.submitting">
            <v-card>
                <v-card-subtitle>
                    <v-btn class="ma-1 mr-5" outlined color="primary" @click="$router.go(-1)"><v-icon left>mdi-arrow-left</v-icon>{{ $t('Back') }}</v-btn>
                </v-card-subtitle>
                <!-- <v-card-subtitle class="mb-3">Fill the form bellow to create new user</v-card-subtitle> -->
                <v-card-text>
                    <v-row>
                        <v-col class="py-0" cols="12">
                            <v-list-item class="px-0 mb-5">
                                <v-list-item-avatar size="128" tile color="grey">
                                    <v-img :src="form.additional.avatar" contain></v-img>
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
                            <text-editor v-model="form.data.diagnosis" :label="'Diganosis (Optional)'"></text-editor>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <text-editor v-model="form.data.cause" :label="'Cause (Optional)'"></text-editor>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <text-editor v-model="form.data.solution" :label="'Solution (Optional)'"></text-editor>
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
import TextEditor from '../../components/input/TextEditor.vue';
import axiosApiInstance from '../../utilites'
export default {
    components: { TextEditor },
    data: () => ({
        loading: true,
        current_date: null,
        form: {
            submitting: false,
            data: {
                name: null,
                avatar: null,
                crop_id: null,
                diagnosis: '',
                cause: '',
                solution: ''
            },
            additional: {
                avatar: null,
            }
        },
        crops: [

        ],
    }),

    mounted()
    {
        this.loading = false
        this.fetchCrop()
    },

    methods:
    {
        onInputFile(e)
        {
            if (e) this.form.additional.avatar = URL.createObjectURL(e)
            else this.form.additional.avatar = null
        },

        onSubmit()
        {
            if (this.$refs.form.validate())
            {
                console.log(this.form);
                this.form.submitting = true
                let formData = new FormData()
                if (this.form.data.avatar) formData.append('avatar', this.form.data.avatar)
                if (this.form.data.diagnosis) formData.append('diagnosis', this.form.data.diagnosis)
                if (this.form.data.cause) formData.append('cause', this.form.data.cause)
                if (this.form.data.solution) formData.append('solution', this.form.data.solution)
                formData.append('name', this.form.data.name)
                formData.append('crop_id', this.form.data.crop_id)
                axiosApiInstance.post('disease', formData, {
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
        },

        async fetchCrop()
        {
            axiosApiInstance.get('/disease/create')
            .then(response => {
                this.crops = response.data;

            })
            .catch(({response}) => {
                // console.log('lol');
            })
            .finally(() => {
                // console.log('lol');
            })
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
