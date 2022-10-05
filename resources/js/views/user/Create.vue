<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Users</v-card-title>
                <v-card-subtitle>Fill the below form to create new user.</v-card-subtitle>
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
                        <v-col class="py-0" cols="12" sm="6">
                            <v-text-field
                                v-model="form.data.first_name"
                                required
                                :rules="[v => !!v || $t('First Name is required')]"
                                outlined
                                :label="$t('First Name')">
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12" sm="6">
                            <v-text-field
                                v-model="form.data.last_name"
                                required
                                :rules="[v => !!v || $t('Last Name is required')]"
                                outlined
                                :label="$t('Last Name')">
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <v-text-field
                                v-model="form.data.username"
                                required
                                :rules="[v => !!v || $t('Username is required')]"
                                outlined
                                :label="$t('Username')">
                            </v-text-field>
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
                            <v-text-field
                                v-model="form.data.email"
                                type="email"
                                required
                                :rules="[v => !!v || $t('Email is required')]"
                                outlined
                                :label="$t('Email')">
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12">
                            <v-autocomplete
                                v-model="form.data.role"
                                :items="['admin', 'customer']"
                                required
                                :rules="[v => !!v || $t('Role is required')]"
                                outlined
                                :label="$t('Role')">
                            </v-autocomplete>
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
import axiosApiInstance from '../../utilites'
export default {
    data: () => ({
        loading: true,
        current_date: null,
        form: {
            submitting: false,
            data: {
                first_name: null,
                last_name: null,
                username: null,
                email: null,
                avatar: null,
                role: 'customer'
            },
            additional: {
                avatar: null,
            }
        }
    }),

    mounted()
    {
        this.loading = false
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
                formData.append('first_name', this.form.data.first_name)
                formData.append('last_name', this.form.data.last_name)
                formData.append('username', this.form.data.username)
                formData.append('email', this.form.data.email)
                formData.append('role', this.form.data.role)
                axiosApiInstance.post('user', formData, {
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
