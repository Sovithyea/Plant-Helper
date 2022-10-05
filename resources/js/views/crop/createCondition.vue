<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader
                    class="px-4 pb-3"
                    type="text"
                ></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Conditions</v-card-title>
                <v-card-subtitle
                    >Fill the below form to create new condition.
                    {{ $route.params.crop }}</v-card-subtitle
                >
            </template>
        </v-card>
        <v-form
            lazy-validation
            ref="form"
            @submit.prevent="onSubmit"
            :disabled="form.submitting"
        >
            <v-card>
                <v-card-subtitle>
                    <v-btn
                        class="ma-1"
                        outlined
                        color="primary"
                        @click="$router.go(-1)"
                        ><v-icon left>mdi-arrow-left</v-icon
                        >{{ $t("Back") }}</v-btn
                    >
                </v-card-subtitle>
                <!-- <v-card-subtitle class="mb-3">Fill the form bellow to create new user</v-card-subtitle> -->
                <v-card-text>
                    <v-row>
                        <v-col class="py-0" cols="12">
                            <v-list-item class="px-0 mb-5">
                                <v-list-item-avatar
                                    size="128"
                                    class="w-75 mx-auto"
                                    tile
                                    color="grey"
                                >
                                    <!-- <v-img :src="form.additional.avatar" contain></v-img> -->
                                    <v-img
                                        contain
                                        :src="
                                            constants.storagePath +
                                            form.data.avatar
                                        "
                                        width="150px"
                                        height="150px"
                                    ></v-img>
                                </v-list-item-avatar>

                                <!-- <v-list-item-content>
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
                                </v-list-item-content> -->
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
                        <v-col class="py-0" cols="12">
                            <v-autocomplete
                                v-model="form.data.condition_id"
                                :items="conditions"
                                item-text="name"
                                item-value="id"
                                clearable
                                required
                                :rules="[
                                    (v) => !!v || $t('Condition is required'),
                                ]"
                                outlined
                                :label="$t('Condition')"
                            >
                            </v-autocomplete>
                        </v-col>

                        <v-col class="py-0" cols="12" sm="6">
                            <v-text-field
                                type="number"
                                v-model="form.data.min"
                                required
                                :rules="[(v) => !!v || $t('Min is required')]"
                                outlined
                                :label="$t('Min')"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12" sm="6">
                            <v-text-field
                                type="number"
                                v-model="form.data.max"
                                required
                                :rules="[(v) => !!v || $t('Max is required')]"
                                outlined
                                :label="$t('Max')"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col class="py-0" cols="12" sm="12">
                            <v-text-field
                                type="number"
                                v-model="form.data.regular"
                                required
                                :rules="[
                                    (v) => !!v || $t('Regular is required'),
                                ]"
                                outlined
                                :label="$t('Regular')"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions class="px-4 pb-4">
                    <v-btn
                        type="submit"
                        color="success"
                        :loading="form.submitting"
                        ><v-icon left>mdi-checkbox-marked-circle-outline</v-icon
                        >Save</v-btn
                    >
                    <!-- <v-btn color="secondary" @click="$router.go(-1)"><v-icon left>mdi-cancel</v-icon>Cancel</v-btn> -->
                </v-card-actions>
            </v-card>
        </v-form>
    </v-container>
</template>
<script>
import axiosApiInstance from "../../utilites";
import contants from "../../constants";
export default {
    data: () => ({
        constants: contants,
        loading: true,
        current_date: null,
        form: {
            submitting: false,
            data: {
                name: null,
                avatar: null,
                min: null,
                max: null,
                regular: null,
                condition_id: null
            },
            additional: {
                avatar: null,
            },
        },
        conditions: [

        ],
        crops: [

        ],

        crop_id: {

        }

    }),

    mounted() {
        this.loading = false;
        this.fetchConditions();
        this.fetchCrop()
        this.fetchCropById()
    },

    watch: {
        "form.data.condition_id"(newValue) {
            if (newValue) {
                axiosApiInstance
                    .get(`condition/${newValue}`)
                    .then((response) => {
                        // console.log(response.data);
                        this.form.data.avatar = response.data.avatar;
                        this.form.data.condition_id = response.data.id
                        // this.form.data.min = response.data.min
                        // this.form.data.max = response.data.max
                        // this.form.data.regular = response.data.regular
                    })
                    .catch(({ response }) => {
                        this.$store.dispatch("pushNotification", {
                            message: response.data.message,
                            type: "error",
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } else {
                this.$nextTick(() => {
                    this.form.data.avatar = null;
                });
            }
        },
    },
    methods: {
        onInputFile(e) {
            if (e) this.form.additional.avatar = URL.createObjectURL(e);
            else this.form.additional.avatar = null;
        },

        onSubmit() {
            if (this.$refs.form.validate()) {
                this.form.submitting = true;
                let formData = new FormData();

                formData.append("crop_id", this.$route.params.crop);
                formData.append("condition_id", this.form.data.condition_id);
                formData.append("min", this.form.data.min);
                formData.append("max", this.form.data.max);
                formData.append("regular", this.form.data.regular);
                axiosApiInstance
                    .post("crop/condition", formData, {
                        headers: { "Content-Type": "multipart/form-data" },
                    })
                    .then((response) => {
                        this.$store.dispatch("pushNotification", {
                            message: response.data.message,
                            type: "success",
                        });
                        this.$router.go(-1);
                    })
                    .catch(({ response }) => {
                        this.$store.dispatch("pushNotification", {
                            message: response.data.message,
                            type: "error",
                        });
                    })
                    .finally(() => {
                        this.form.submitting = false;
                    });
            }
        },

        async fetchConditions() {
            axiosApiInstance
                .get(`/crop/conditions`)
                .then((response) => {

                    this.conditions = response.data;
                })
                .catch(({ response }) => {
                    this.$store.dispatch("pushNotification", {
                        message: response.data.message,
                        type: "error",
                    });
                });
        },


        async fetchCrop()
        {
            axiosApiInstance.get('/disease/create')
            .then(response => {
                this.crops = response.data;
                // console.log(this.crops);
            })
            .catch(({response}) => {
                // console.log('lol');
            })
            .finally(() => {
                // console.log('lol');
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
    },
};
</script>
