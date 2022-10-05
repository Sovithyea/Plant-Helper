
<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>User</v-card-title>
                <v-card-subtitle>List all users.</v-card-subtitle>
            </template>
        </v-card>
        <v-dialog v-model="diaglogDelete" max-width="500">
            <v-card>
                <v-card-title>{{ $t('Are you sure?') }}</v-card-title>
                <v-card-text>{{ $t('Do you want to delete?') }}</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="secondary" outlined :disabled="deleting" @click="diaglogDelete = false"><v-icon left>mdi-cancel</v-icon>Cancel</v-btn>
                    <v-btn color="error" :loading="deleting" @click="onConfirmDelete"><v-icon left>mdi-trash-can-outline</v-icon>Confirm</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-data-table
            :headers="dataTable.headers"
            :items="dataTable.data"
            :options.sync="options"
            :server-items-length="dataTable.meta.total"
            :loading="loading">

            <template #[`top`]>
                <v-toolbar flat>
                    <v-btn class="ma-1" color="primary" :to="{ name: 'user.create' }"><v-icon left>mdi-plus</v-icon>{{ $t('New user') }}</v-btn>
                    <a href="/api/userExport" style="text-decoration: none;" class="mx-5">

                    <!-- <v-btn :loading="exporting" @click="onExport()" class="mx-5" color="success"><v-icon left >mdi-download</v-icon>Export User</v-btn> -->
                    <v-btn color="success"><v-icon left>mdi-download</v-icon>Export User</v-btn>

                    </a>
                    <v-btn class="ma-1 mr-5" color="warning" :to="{ name: 'user.trash' }"><v-icon left>mdi-delete</v-icon>{{ $t('User Trash') }}</v-btn>
                    <v-spacer></v-spacer>
                    <!-- <div class="ma-3" style="width: 250px">
                        <v-text-field
                        outlined
                        dense
                        hide-details
                        :label="$t('search')"
                        @input="search"
                        v-model="q"
                        ></v-text-field>
                    </div> -->
                </v-toolbar>
            </template>
            <!-- plan -->
            <template #[`item.no`]="{ item, index }" :ref="item.id">
                {{ options.itemsPerPage * (options.page - 1) + index + 1 }}
            </template>

            <template #[`item.avatar`]="{ item }" :ref="item.id">
                <v-avatar size="64" class="ma-1" tile>
                    <v-img :src="constant.storagePath + item.avatar" contain></v-img>
                </v-avatar>
            </template>

            <!-- actions -->
            <template #[`item.actions`]="{ item }">
                <v-tooltip top>
                    <template #activator="{ on, attrs }">
                        <v-btn color="primary" v-bind="attrs" icon small :to="{ name: 'user.show', params: { user: item.id } }" v-on="on"><v-icon>mdi-eye</v-icon></v-btn>
                    </template>
                    <span>Detail</span>
                </v-tooltip>
                <v-tooltip top>
                    <template #activator="{ on, attrs }">
                        <v-btn color="warning" icon small :to="{ name: 'user.edit', params: { user: item.id } }" v-bind="attrs" v-on="on"><v-icon>mdi-pencil-box-outline</v-icon></v-btn>
                    </template>
                    <span>Edit</span>
                </v-tooltip>
                <v-tooltip top>
                    <template #activator="{ on, attrs }">
                        <v-btn color="error" :disabled="item.id === user.id" icon small v-bind="attrs" @click="onClickDelete(item)" v-on="on"><v-icon>mdi-trash-can-outline</v-icon></v-btn>
                    </template>
                    <span>Delete</span>
                </v-tooltip>
            </template>
        </v-data-table>
    </v-container>
</template>
<script>
import { mapGetters } from 'vuex'
import contants from '../../constants'
import axiosApiInstance from '../../utilites'
export default {
    data: () => ({
        loading: true,
        constant: contants,
        diaglogDelete: false,
        deleteItem: null,
        deleting: false,
        exporting: false,
        options: {
            sortBy: ['id'],
            sortDesc: [true],
            itemsPerPage: 15,
            page: 1,
        },
        dataTable: {
            headers: [],
            items: [],
            totalItems: 0,
            meta: {
                total: 0,
            }
        },

        searchQuery: null,
    }),

    watch: {
        options: {
            handler() {
                this.fetchData();
            },
        },
    },

    computed:
    {
        ...mapGetters('auth', {
            user: 'user'
        })
    },

    mounted()
    {
        this.fetchData()
    },

    methods: {
        async fetchData()
        {
            this.loading = true
            axiosApiInstance.get('user', {
                params: {
                    page: this.options.page,
                    perpage: this.options.itemsPerPage === -1 ? this.dataTable.totalItems : this.options.itemsPerPage,
                    search: this.searchQuery,
                }
            })
            .then(response => {
                this.dataTable = response.data
            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.loading = false
            })
        },

        onClickDelete(item)
        {
            this.deleteItem = item.id
            this.diaglogDelete = true
        },

        onConfirmDelete()
        {
            this.deleting = true
            axiosApiInstance.delete(`user/${ this.deleteItem }`)
            .then( response => {
                this.fetchData()
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'success' })
                this.diaglogDelete = false
            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.deleting = false
            })
        },

        // onExport()
        // {
        //     this.exporting = true
        //     axiosApiInstance.get('userExport', {
        //         headers: {
        //             responseType: 'blob',
        //         }
        //     })
        //     .then(response => {
        //         var fileURL = window.URL.createObjectURL(new Blob([response.data]));
        //         var fileLink = document.createElement('a');

        //         fileLink.href = fileURL;
        //         fileLink.setAttribute('download', 'users.xlsx');
        //         document.body.appendChild(fileLink);
        //         fileLink.click();
        //         this.$store.dispatch('pushNotification', { message: response.data.message, type: 'success' })
        //     })
        //     .catch(({ response }) => {
        //         this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
        //     })
        //     .finally(() => {
        //         this.exporting = false
        //     })
        // }
    }
}
</script>
