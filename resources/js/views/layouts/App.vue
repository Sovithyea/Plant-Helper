<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer"
            :clipped="$vuetify.breakpoint.mdAndUp"
            dark
            app
        >
            <v-list shaped>
                <v-list-item v-if="!$vuetify.breakpoint.lgAndUp"></v-list-item>
                <v-list-item dark :to="{ name: 'home' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-home-analytics</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{
                            $t("Dashboard")
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item dark :to="{ name: 'crop.index' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-pine-tree</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ $t("Crop") }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item dark :to="{ name: 'activity.index' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-merge</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ $t("Guide") }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item dark :to="{ name: 'disease.index' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-virus</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{
                            $t("Disease")
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-subheader>User Management</v-subheader>
                <v-list-item dark :to="{ name: 'user.index' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-account-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ $t("Users") }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-subheader>Setting</v-subheader>
                <v-list-item dark :to="{ name: 'setting' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-cog</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{
                            $t("setting")
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-subheader>Extra</v-subheader>

                <v-list-item dark :to="{ name: 'condition.index' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-television-guide</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{
                            $t("Condition")
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item dark :to="{ name: 'category.index' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-shape-outline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{
                            $t("Category")
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-subheader>Comment</v-subheader>
                <v-list-item dark :to="{ name: 'comment.index' }">
                    <v-list-item-icon>
                        <v-icon color="info">mdi-comment</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{
                            $t("comment")
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app dark>
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-toolbar-title>{{ $t("Plant Helper") }}</v-toolbar-title>
            <!-- <div v-if="$vuetify.breakpoint.smAndUp" class="ml-4 text-subtitle-2">Hello</div> -->
            <v-spacer></v-spacer>
            <v-menu open-on-hover offset-y offset-overflow>
                <template v-slot:activator="{ on, attrs }">
                    <v-avatar tile v-on="on" v-bind="attrs" class="mr-5">
                        <v-img
                            contain
                            :src="storagePath + 'lang/' + $i18n.locale + '.png'"
                        ></v-img>
                    </v-avatar>
                </template>
                <v-list dense>
                    <v-list-item @click="changeLanguage('km')">
                        <v-list-item-avatar tile>
                            <v-img
                                contain
                                :src="storagePath + 'lang/km.png'"
                            ></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>{{
                                $t("lang.km")
                            }}</v-list-item-title>
                            <v-list-item-subtitle
                                >ភាសាខ្មែរ</v-list-item-subtitle
                            >
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="changeLanguage('en')">
                        <v-list-item-avatar tile>
                            <v-img
                                contain
                                :src="storagePath + 'lang/en.png'"
                            ></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>{{
                                $t("lang.en")
                            }}</v-list-item-title>
                            <v-list-item-subtitle>English</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-menu offset-y transition="slide-y-transition" v-if="user">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn class="mr-2" icon v-bind="attrs" v-on="on">
                        <v-avatar color="primary" v-if="user.avatar">
                            <v-img :src="storagePath + user.avatar"></v-img>
                        </v-avatar>
                        <v-avatar color="primary" v-else>{{
                            user.first_name[0] + user.last_name[0]
                        }}</v-avatar>
                    </v-btn>
                </template>
                <v-card>
                    <v-list>
                        <v-list-item>
                            <v-list-item-avatar class="white--text">
                                <!-- <v-avatar color="primary" v-if="user.avatar">
                            <v-img :src="storagePath + user.avatar"></v-img>
                            </v-avatar>
                            <v-avatar color="primary"  v-else>
                            {{user.short_name}}
                            </v-avatar> -->
                                <v-avatar color="primary" v-if="user.avatar">
                                    <v-img
                                        :src="storagePath + user.avatar"
                                    ></v-img>
                                </v-avatar>
                                <v-avatar color="primary" v-else>{{
                                    user.first_name[0] + user.last_name[0]
                                }}</v-avatar>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    user.first_name + " " + user.last_name
                                }}</v-list-item-title>
                                <v-list-item-subtitle>{{
                                    user.email
                                }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list>
                        <v-list-item link dense :to="{ name: 'setting' }">
                            <v-list-item-icon>
                                <v-icon>mdi-cog</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    $t("setting")
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item link dense @click="logout">
                            <v-list-item-icon>
                                <v-icon>mdi-logout</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    $t("sign_out")
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
        </v-app-bar>
        <v-main class="grey lighten-4">
            <div style="position: fixed; right: 10px; z-index: 9999">
                <notification
                    v-for="notification in $store.state.notifications"
                    :key="notification.id"
                    :item="notification"
                ></notification>
            </div>
            <transition name="slide-x-transition" mode="out-in">
                <router-view></router-view>
            </transition>
        </v-main>
        <v-footer padless>
            <v-card flat tile width="100%" dark class="text-center">
                <v-card-text class="white--text"
                    >{{ new Date().getFullYear() }} —
                    <strong
                        >{{ $t("powered_by") }} Code4Everyone Team</strong
                    ></v-card-text
                >
            </v-card>
        </v-footer>
    </v-app>
</template>
<style>
.v-app-bar.v-app-bar--fixed {
    position: fixed;
    top: 0;
    z-index: 10 !important;
}
.v-btn {
    text-transform: none !important;
}
</style>
<script>
import { mapGetters } from "vuex";
import constants from "../../constants";
export default {
    data: () => ({
        storagePath: constants.storagePath,
        drawerMenu: [],
        drawer: null,
        notifications: [],
        count_notification: 0,
    }),
    computed: {
        ...mapGetters("auth", {
            user: "user",
        }),
    },

    beforeCreate() {
        this.$store.commit("auth/SET_REFRESHING", false);
        this.$i18n.locale = this.$store.state.locale;
        this.$store.dispatch("auth/getUser").catch(() => {});
    },

    methods: {
        logout() {
            this.$store.dispatch("auth/logout");
        },
        changeLanguage(locale) {
            this.$store.dispatch("changeLanguage", locale);
            this.$i18n.locale = locale;
        },
    },
};
</script>
