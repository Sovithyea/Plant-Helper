import axios from "axios";
import constants from "../../constants";
import router from "../../router";
import axiosApiInstance from "../../utilites";

const state = {
    authenticated: false,
    user: {
        id: null,
        first_name: null,
        last_name: null,
        username: null,
        email: null,
        menus: [],
        ability: [],
    },
    accessToken: null,
    refreshToken: null,
    isTokenRefreshing: false,
};

const getters = {
    authenticated(state) {
        return state.authenticated;
    },
    user(state) {
        return state.user;
    },
    accessToken(state) {
        return state.accessToken;
    },
};

const mutations = {
    SET_AUTH_USER(state, value) {
        state.user = value;
    },
    SET_AUTH_TOKEN(state, token) {
        state.accessToken = token.access_token;
        state.refreshToken = token.refresh_token;
    },
    SET_AUTHENTICATED(state, value) {
        state.authenticated = value;
    },
    SET_REFRESHING(state, value) {
        state.isTokenRefreshing = value;
    },
    REMOVE_AUTH_TOKEN(state) {
        state.accessToken = null;
        state.refreshToken = null;
    },
};

const actions = {
    login({ commit }, credential) {
        return new Promise((resolve, reject) => {
            axios
                .post("api/login", credential)
                .then((response) => {
                    commit("SET_AUTHENTICATED", true);
                    commit("SET_AUTH_TOKEN", response.data);
                    resolve(response);
                })
                .catch((response) => {
                    reject(response);
                });
        });
    },

    getUser({ commit }) {
        return new Promise((resolve, reject) => {
            axiosApiInstance
                .get("/auth/user")
                .then((response) => {
                    commit("SET_AUTH_USER", response.data);
                    resolve();
                })
                .catch((error) => {
                    reject();
                });
        });
    },

    logout({ commit }) {
        commit("SET_AUTHENTICATED", false);
        commit("REMOVE_AUTH_TOKEN");
        router.push({ name: "login" });
    },

    refreshToken({ commit, state }) {
        return new Promise((resolve, reject) => {
            commit("SET_REFRESHING", true);
            axios
                .post("api/refresh", {
                    refresh_token: state.refreshToken,
                })
                .then((response) => {
                    commit("SET_AUTHENTICATED", true);
                    commit("SET_AUTH_TOKEN", response.data);
                    resolve();
                })
                .catch((response) => {
                    commit("SET_AUTHENTICATED", false);
                    commit("REMOVE_AUTH_TOKEN");
                    window.localStorage.setItem(
                        "redirect",
                        window.location
                            .toString()
                            .replace(constants.baseUrl, "")
                    );
                    router.push({ name: "login" });
                    reject(response);
                })
                .finally(() => {
                    commit("SET_REFRESHING", false);
                });
        });
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
