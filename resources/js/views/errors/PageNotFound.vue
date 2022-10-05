<template>
    <v-app>
        <v-main>
            <v-container class="fill-height fill_image" fluid>
                <v-row align="center" justify="center" dense>
                    <v-col cols="12" sm="8" md="4" lg="4" style="padding: 10px;">
                        <v-card elevation="0">
                            <v-img src="storage/error/page_not_found.png"></v-img>
                            <v-card-title>We're sorry, Page Not Found</v-card-title>
                            <v-card-text>
                                The page your are looking for does not exist, might have been removed, or is temporary unavailable.
                            </v-card-text>
                            <v-card-actions>
                                <v-btn color="primary" outlined @click="$router.go(-1)">Back</v-btn>
                                <v-btn color="success" link :to="{ name: 'home' }">Back to home</v-btn>
                            </v-card-actions>
                        </v-card>
                        <!-- <v-card elevation="0" color="#FFFFFFDD">
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                            ></v-img>

                            <v-card-text>
                                <v-btn :to="{ name: 'home' }" class="rounded-0" color="success" x-large block dark>Back to home page</v-btn>
                            </v-card-text>
                            <v-card-actions class="ml-6 mr-6 text-center">
                                <p>By continuing, you agree to Yamato Green's <a href="#" class="pl-2" style="color: #000000">Policy</a> and <a href="#" class="pl-2" style="color: #000000">Terms of Use</a></p>
                            </v-card-actions>
                        </v-card> -->
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
