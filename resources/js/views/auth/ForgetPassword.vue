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
                                        clearable
                                        outlined
                                        required
                                        :rules="[v => !!v || 'Email is required']"
                                        type="email"
                                        label="Enter your email">
                                    </v-text-field>
                                    <v-card-actions>
                                        <v-btn color="success" tile x-large block dark type="submit" :loading="form.submitting">Reset password</v-btn>
                                    </v-card-actions>
                                    <v-card-actions>
                                        <v-btn block :to="{ name: 'login' }" x-large tile color="secondary" :disabled="form.submitting"><v-icon left>mdi-arrow-left</v-icon> Back to login</v-btn>
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
                email: null,
            },
        },
    }),
    methods: {
        onSubmit() {
            if (this.$refs.form.validate())
            {
                this.form.submitting = true
                axios.post('api/forgot-password', this.form.data)
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
    }
}
</script>
