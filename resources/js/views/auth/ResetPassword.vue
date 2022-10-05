<template>
    <v-app>
        <v-main>
            <v-container class="fill-height fill_image" fluid>
                <v-row align="center" justify="center" dense>
                    <v-col cols="12" sm="8" md="4" lg="4" style="padding: 10px;">
                        <v-form lazy-validation ref="form" @submit.prevent="onSubmit" autocomplete="off" :disabled="form.submitting">
                            <v-card elevation="0" color="#FFFFFFDD">
                                <v-card-subtitle class="text-center text-h5">{{ $t('name') }}</v-card-subtitle>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-text-field
                                        v-model="form.data.email"
                                        prepend-inner-icon="mdi-email"
                                        readonly
                                        clearable
                                        outlined
                                        required
                                        :rules="[v => !!v || 'Email is required']"
                                        type="email"
                                        label="Enter your email">
                                    </v-text-field>
                                    <v-text-field
                                        v-model="form.data.password"
                                        required
                                        :rules="[v => !!v || 'New Password is required']"
                                        outlined
                                        clearable
                                        type="password"
                                        label="New Password">
                                    </v-text-field>
                                    <v-text-field
                                        v-model="form.data.password_confirmation"
                                        required
                                        :rules="[
                                            v => !!v || 'Password confirmation is required',
                                            v => v == form.data.password || 'Password does not matched.'
                                        ]"
                                        outlined
                                        clearable
                                        type="password"
                                        label="Password Confirmation">
                                    </v-text-field>
                                    <v-card-actions>
                                        <v-btn color="success" tile x-large block dark type="submit">Reset password</v-btn>
                                    </v-card-actions>
                                    <v-card-actions>
                                        <v-btn block :to="{ name: 'login' }" x-large tile color="secondary"><v-icon left>mdi-arrow-left</v-icon> Back to login</v-btn>
                                    </v-card-actions>
                                </v-card-text>
                            </v-card>
                        </v-form>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
    .fill_image {
        background-image: url('../../../../public/storage/bg.jpg');
        background-clip: content-box;
        background-size: cover;
    }
</style>

<script>
import axios from 'axios'
export default {
    data: () => ({
        form : {
            submitting: false,
            data: {
                token: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
        },
    }),

    mounted()
    {
        this.form.data.email = this.$route.query.email
        this.form.data.token = this.$route.params.token
    },

    methods: {
        onSubmit() {
            if (this.$refs.form.validate())
            {
                this.form.submitting = true
                axios.post('api/reset-password', this.form.data)
                .then(response => {
                    this.$store.dispatch('pushNotification', { message: response.data.message, type: 'success' })
                    this.$router.push({ name: 'login' })
                })
                .catch(({ response }) => {
                    this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
                })
                .finally(() => {
                    this.form.submitting = false
                })
            }
        }
    }
}
</script>
