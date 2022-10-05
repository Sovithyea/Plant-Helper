<template>
    <v-app>
        <v-main>
            <v-container class="fill-height fill_image" fluid>
                <v-row align="center" justify="center" dense>
                    <v-col cols="12" sm="8" md="4" lg="4" style="padding: 10px;">
                        <v-card elevation="0" color="#FFFFFFDD">
                            <v-card-subtitle class="text-center text-h5">{{$t('name')}}</v-card-subtitle>
                            <v-divider></v-divider>
                            <v-card-text>
                                <!-- <v-img v-if="logo" :src="logo" height="150" contain></v-img><br>
                                <v-alert v-if="error" tile color="error" dark>
                                    {{ error }}
                                </v-alert> -->
                                <!-- <v-img :src="`storage/logo.png`" height="150" contain></v-img><br> -->
                            <v-form lazy-validation ref="form" @submit.prevent="onSubmit" :disabled="form.submitting">
                                <!-- <v-col class="py-0" cols="12">
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
                                                class="rounded-0"
                                                :label="$t('Avatar')">
                                            </v-file-input>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-col> -->
                                <v-row>
                                    <v-col class="py-0" cols="12" sm="6">
                                        <v-text-field
                                            v-model="form.first_name"
                                            required
                                            :rules="[v => !!v || $t('First Name is required')]"
                                            outlined
                                            class="rounded-0"
                                            :label="$t('First Name')">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" sm="6">
                                        <v-text-field
                                            v-model="form.last_name"
                                            required
                                            :rules="[v => !!v || $t('Last Name is required')]"
                                            outlined
                                            class="rounded-0"
                                            :label="$t('Last Name')">
                                        </v-text-field>
                                    </v-col>
                                </v-row>

                                    <v-text-field
                                        v-model="form.username"
                                        required
                                        :rules="[v => !!v || $t('Username is required')]"
                                        outlined
                                        class="rounded-0"
                                        prepend-inner-icon="mdi-account"
                                        :label="$t('Username')">
                                    </v-text-field>

                                <v-text-field
                                    v-model="form.email"
                                    autocomplete="off"
                                    label="Enter your email"
                                    required
                                    :rules="[v => !!v || $t('Email is required')]"
                                    name="email"
                                    prepend-inner-icon="mdi-email"
                                    type="email"
                                    class="rounded-0"
                                    outlined>
                                </v-text-field>
                                <v-text-field
                                    v-model="form.password"
                                    autocomplete="off"
                                    required
                                    :rules="[v => !!v || $t('Password is required')]"
                                    label="Enter your password"
                                    name="password"
                                    prepend-inner-icon="mdi-lock"
                                    :type="show_password ? 'text': 'password'"
                                    class="rounded-0"
                                    outlined>
                                </v-text-field>
                                <v-text-field
                                    v-model="form.password_confirmation"
                                    autocomplete="off"
                                    label="Confirm your password"
                                    required
                                    :rules="[v => !!v || $t('Confirm Password is required')]"
                                    name="password"
                                    prepend-inner-icon="mdi-lock"
                                    :type="show_password ? 'text': 'password'"
                                    class="rounded-0"
                                    outlined>
                                </v-text-field>
                                <v-card-actions class="text--secondary" style="margin-top: -30px;">
                                    <v-checkbox v-model="show_password" color="#000000" label="Show password"></v-checkbox>
                                </v-card-actions>
                                <v-card-actions>
                                    <v-btn color="success" tile x-large block dark type="submit">Create Account</v-btn>
                                </v-card-actions>
                                <v-card-actions>
                                    <v-btn block :to="{ name: 'login' }" x-large tile color="secondary"><v-icon left>mdi-arrow-left</v-icon> Back to login</v-btn>
                                </v-card-actions>
                                <!-- <v-btn  color="success" x-large block dark :loading="form.submitting" type="submit">Create Account</v-btn> -->
                                <!-- <v-card-actions class="text--secondary">
                                    <v-spacer></v-spacer>
                                    <router-link :to="{ name: 'login' }" class="pl-2" style="color: #000000">Back to login</router-link>
                                </v-card-actions> -->
                                <!-- <v-card-actions>
                                    <v-btn block :to="{ name: 'login' }" x-large tile color="secondary"><v-icon left>mdi-arrow-left</v-icon> Back to login</v-btn>
                                </v-card-actions> -->
                                </v-form>
                            </v-card-text>
                            <v-card-actions class="ml-6 mr-6 text-center">
                                <p>By continuing, you agree to Yamato Green's <a href="#" class="pl-2" style="color: #000000">Policy</a> and <a href="#" class="pl-2" style="color: #000000">Terms of Use</a></p>
                            </v-card-actions>
                        </v-card>
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
import axiosApiInstance from '../../utilites'
export default {
    data: () => ({
        form : {
            // submitting: false,
            // data: {
                first_name: null,
                last_name: null,
                username: null,
                email: null,
                avatar: null,
                role: 'customer',
                password: null,
                password_confirmation: null,
            },
            // additional: {
                // avatar: null
            // }
        // },
        // error: null,
        // logo:null,
        show_password: false
    }),
    mounted() {

    },
    methods: {
        onInputFile(e)
        {
            if (e) this.form.additional.avatar = URL.createObjectURL(e)
            else this.form.additional.avatar = null
        },

        onSubmit(){
            if (this.$refs.form.validate())
            {
                console.log(this.form);
                this.form.submitting = true

                axiosApiInstance.post('register', this.form, {
                    // headers: { "Content-Type": "multipart/form-data"}
                })
                .then(( response ) => {
                    this.$router.push({ name: 'login' })
                    this.$store.dispatch('pushNotification', { message: response.data.message, type: 'success' })
                })
                .catch(({response}) => {
                    this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
                })
                .finally(() => {
                    this.form.submitting = false
                    console.log(formData);
                })
            }
        }
    }
}
</script>
