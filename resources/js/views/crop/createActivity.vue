<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Guide</v-card-title>
                <v-card-subtitle>Fill the below form to create new guides.</v-card-subtitle>
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
                                v-model="crop_id"
                                :items="crops"
                                item-text="name"
                                item-value="id"
                                readonly
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
import TextEditor from'../../components/input/TextEditor.vue';
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
                detail: '',
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
        ],
        crop_id: {

        }
    }),

    mounted()
    {
        this.loading = false,
        this.fetchData();
        this.fetchCropById();
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
                this.form.submitting = true
                let formData = new FormData()
                if (this.form.data.avatar) formData.append('avatar', this.form.data.avatar)
                if (this.form.data.detail) formData.append('detail', this.form.data.detail)
                formData.append('name', this.form.data.name);
                formData.append('crop_id', this.$route.params.crop);
                formData.append('stage', this.form.data.stage);
                axiosApiInstance.post('activity', formData, {
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

        fetchData()
        {
            axiosApiInstance.get('activity/create')
            .then(res => {
                // console.log(res);
                this.crops = res.data;
            })
            .catch(({ res }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
        },

        async fetchCropById () {
            axiosApiInstance.get(`crop/${ this.$route.params.crop }`)
            .then(response => {

                this.crop_id = response.data.id
                // console.log(this.crop_id);
            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                // this.loading = false
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
