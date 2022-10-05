<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Crops</v-card-title>
                <v-card-subtitle>Fill the below form to edit the crop..</v-card-subtitle>
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
                        <v-col class="py-0" cols="12" sm="6">
                            <v-text-field
                                v-model="form.data.name"
                                required
                                :rules="[(v) => !!v || $t('Name is required')]"
                                outlined
                                :label="$t('Name')"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12" sm="6">
                            <v-text-field
                                type="number"
                                v-model="form.data.harvest"
                                required
                                :rules="[
                                    (v) => !!v || $t('Harvest is required'),
                                ]"
                                outlined
                                :label="$t('Harvest')"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <v-text-field
                                type="number"
                                v-model="form.data.expire"
                                required
                                :rules="[
                                    (v) => !!v || $t('Expire is required'),
                                ]"
                                outlined
                                :label="$t('Expire')"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <v-autocomplete
                                v-model="form.data.category_id"
                                :items="categories"
                                required
                                :rules="[
                                    (v) => !!v || $t('Category is required'),
                                ]"
                                outlined
                                :label="$t('Category')"
                                item-text="name"
                                item-value="id"
                                clearable
                            >
                            </v-autocomplete>
                        </v-col>
                        <!-- <v-col class="py-0" cols="12">
                            <v-text-field
                                v-model="form.data.phone"
                                required
                                outlined
                                :label="$t('Phone number')">
                            </v-text-field>
                        </v-col> -->
                        <!-- <v-col class="py-0" cols="12">
                            <input-date-picker
                                v-model="form.data.dob"
                                required
                                :rules="[v => !!v || $t('Date of birth is required')]"
                                :max="current_date"
                                outlined
                                :label="$t('Date of birth')">
                            </input-date-picker>
                        </v-col> -->
                        <v-col class="py-0" cols="12">
                            <text-editor
                                v-model="form.data.detail"
                                :label="'Crop detail'"
                            ></text-editor>
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
import category from '../../router/custom/category'
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
                harvest: null,
                expire: null,
                category_id: null,
                detail: '',
                avatar: null,
            },
            additional: {
                avatar: null,
            },

        },
        categories: [],
    }),

    mounted()
    {
        this.fetchData()
        this.fetchCategory()
    },

    methods:
    {
        fetchData()
        {
            axiosApiInstance.get(`crop/${ this.$route.params.crop }/edit`)
            .then(response => {
                this.form = response.data
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
                if (this.form.data.detail) formData.append("detail", this.form.data.detail);
                formData.append("name", this.form.data.name);
                formData.append("harvest", this.form.data.harvest);
                formData.append("expire", this.form.data.expire);
                formData.append("category_id", this.form.data.category_id);
                axiosApiInstance.post(`crop/${ this.$route.params.crop }`, formData, {
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
        async fetchCategory() {
            axiosApiInstance
                .get("/crop/create")
                .then((response) => {
                    this.categories  = response.data;
                    // console.log(this.form.categories)
                })
                .catch(({ response }) => {
                    this.$store.dispatch("pushNotification", {
                        message: response.data.message,
                        type: "error",
                    });
                });
        },

        // keyDown(e)
        // {
        //     var charCode = e.keyCode
        //     console.log(e)
        //     if (charCode < 8 || charCode > 9 && charCode < 16 || charCode > 20 && charCode < 33 || charCode > 40 && charCode < 45 || charCode == 47 || charCode > 57 && charCode < 61 || charCode > 61 && charCode < 91 || charCode > 91) e.preventDefault();
        // }
    }

}
</script>
