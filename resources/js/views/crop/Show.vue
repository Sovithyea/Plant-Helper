<template>
    <v-container fluid>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Crop</v-card-title>
                <v-card-subtitle>{{ $t('Crop Detail') }}</v-card-subtitle>
            </template>
        </v-card>
        <v-card class="mb-3">
            <v-card-subtitle>
                <v-btn class="ma-1" outlined color="primary" @click="$router.go(-1)"><v-icon left>mdi-arrow-left</v-icon>Back</v-btn>
                <v-btn class="ma-1" color="warning" :to="{ name: 'crop.edit' }"><v-icon left>mdi-pencil-box-outline</v-icon>Edit crop</v-btn>
                <v-btn class="ma-1" color="red" dark :to="{ name: 'crop.createDisease',params:{disease: model.id} }"><v-icon left>mdi-plus</v-icon>Add disease</v-btn>
                <v-btn class="ma-1" color="primary" dark :to="{ name: 'crop.createCondition',params:{condition: model.id} }"><v-icon left>mdi-plus</v-icon>Add condition</v-btn>
                <v-btn class="ma-1" color="success" dark :to="{ name: 'crop.createActivity',params:{condition: model.id} }"><v-icon left>mdi-plus</v-icon>Add Guide</v-btn>
            </v-card-subtitle>
            <v-card-text v-if="!loading">
                <v-row justify="center">
                    <v-col cols="12" md="4">
                        <v-card elevation="0">
                            <v-card-subtitle class="text-center">
                                <!-- <v-avatar size="86" color="grey">

                                    <span class="text-h5" v-else>{{ model.first_name[0].toUpperCase() + ' ' + model.last_name[0].toUpperCase() }}</span>
                                </v-avatar> -->
                                <v-img v-if="model.avatar" contain :src="constants.storagePath + model.avatar" width="150px" height="150px"></v-img>
                                <!-- <div class="text-subtitle-2 mt-5">{{ model.first_name + ' ' + model.last_name }}</div> -->
                            </v-card-subtitle>

                        </v-card>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-card-text>
                                <v-list-item dense>
                                    <v-list-item-icon>
                                        <!-- <v-icon>mdi-email-outline</v-icon> -->
                                        Crop:
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{model.name}}</v-list-item-title>
                                        <!-- <v-list-item-subtitle>{{ $t('First Name') }}</v-list-item-subtitle> -->
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item dense>
                                    <v-list-item-icon>
                                        <!-- <v-icon>mdi-email-outline</v-icon> -->
                                        Harvest (days):
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ model.harvest }}</v-list-item-title>
                                        <!-- <v-list-item-subtitle>{{ $t('Last Name') }}</v-list-item-subtitle> -->
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item dense>
                                    <v-list-item-icon>
                                        <!-- <v-icon>mdi-email-outline</v-icon> -->
                                        Expire (days):
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ model.expire }}</v-list-item-title>
                                        <!-- <v-list-item-subtitle>{{ $t('Email') }}</v-list-item-subtitle> -->
                                    </v-list-item-content>
                                </v-list-item>

                            </v-card-text>
                    </v-col>
                </v-row>
                <v-list-item dense>
                    <v-list-item-icon class="font-weight-bold">

                        Crop's Detail:

                    </v-list-item-icon>
                    <v-list-item-content>
                        <p v-html="model.detail" class="pt-1"></p>

                    </v-list-item-content>
                </v-list-item>
            </v-card-text>
        </v-card>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Disease</v-card-title>
                <v-card-subtitle>{{model.name}} {{ $t('Crop disease') }}</v-card-subtitle>
            </template>
            <v-card-text>
                <v-data-table
            :headers="dataTable.headers"
            :items="dataTable.data"
            :options.sync="options"

            :loading="loading"
        >
            <!-- plan -->
            <template #[`item.no`]="{ item, index }" :ref="item.id">
                {{ options.itemsPerPage * (options.page - 1) + index + 1 }}
            </template>

            <template #[`item.avatar`]="{ item }" :ref="item.id">
                <v-avatar size="64" class="ma-1" tile>
                    <v-img
                        :src="constants.storagePath + item.avatar"
                        contain
                    ></v-img>
                </v-avatar>
            </template>

            <template #[`item.diagnosis`]="{ item }" :ref="item.id">
               <td v-html="item.diagnosis" class="text-start pt-3"></td>
            </template>
            <template #[`item.actions`]="{ item }">
                <v-tooltip top>
                    <template #activator="{ on, attrs }">
                        <v-btn
                            color="primary"
                            v-bind="attrs"
                            icon
                            small
                            :to="{
                                name: 'disease.show',
                                params: { disease: item.id },
                            }"
                            v-on="on"
                            ><v-icon>mdi-eye</v-icon></v-btn
                        >
                    </template>
                    <span>Detail</span>
                </v-tooltip>
            </template>
        </v-data-table>
            </v-card-text>
        </v-card>
        <!-- Condition  -->
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Condition</v-card-title>
                <v-card-subtitle>{{model.name}} {{ $t('Crop condition') }}</v-card-subtitle>
            </template>
            <v-card-text>
                <v-data-table
                    :headers="dataTable1.headers"
                    :items="dataTable1.items"
                    :options.sync="options1"
                    :loading="loading"
                >
            <!-- plan -->
            <template #[`item.no`]="{ item, index }" :ref="item.id">
                {{ options.itemsPerPage * (options.page - 1) + index + 1 }}
            </template>

            <template #[`item.avatar`]="{ item }" :ref="item.id">
                <v-avatar size="64" class="ma-1" tile>
                    <v-img
                        :src="constants.storagePath + item.avatar"
                        contain
                    ></v-img>
                </v-avatar>
            </template>

            <template #[`item.actions`]="{ item }">
                <v-tooltip top>
                    <template #activator="{ on, attrs }">
                        <v-btn
                            color="warning"
                            icon
                            small
                            :to="{
                                name: 'cropCondition.edit',
                                params: {
                                    crop: model.id,
                                    condition: item.id
                                },
                            }"
                            v-bind="attrs"
                            v-on="on"
                            ><v-icon>mdi-pencil-box-outline</v-icon></v-btn
                        >
                    </template>
                    <span>Edit</span>
                </v-tooltip>
            </template>
        </v-data-table>
        </v-card-text>
    </v-card>
        <v-card class="mb-3">
            <template v-if="loading">
                <v-skeleton-loader type="card-heading"></v-skeleton-loader>
                <v-skeleton-loader class="px-4 pb-3" type="text"></v-skeleton-loader>
            </template>
            <template v-else>
                <v-card-title>Guide</v-card-title>
                <v-card-subtitle>{{model.name}} {{ $t('Crop Guide') }}</v-card-subtitle>
            </template>
            <v-card-text>

        <!-- activity -->
                <v-data-table
            :headers="dataTable2.headers"
            :items="dataTable2.data"
            :options.sync="options"

            :loading="loading"
        >
            <!-- plan -->
            <template #[`item.no`]="{ item, index }" :ref="item.id">
                {{ options.itemsPerPage * (options.page - 1) + index + 1 }}
            </template>

            <template #[`item.avatar`]="{ item }" :ref="item.id">
                <v-avatar size="64" class="ma-1" tile>
                    <v-img
                        :src="constants.storagePath + item.avatar"
                        contain
                    ></v-img>
                </v-avatar>
            </template>

            <template #[`item.detail`]="{ item }" :ref="item.id">
               <td v-html="item.detail" class="text-start pt-3"></td>
            </template>

            <template #[`item.stage`]="{ item }" :ref="item.id">
               <td class="text-start pt-3"> {{ item.stage == 1 ? 'Nursery' : 'Planting' }}</td>
            </template>

            <template #[`item.actions`]="{ item }">
                <v-tooltip top>
                    <template #activator="{ on, attrs }">
                        <v-btn
                            color="primary"
                            v-bind="attrs"
                            icon
                            small
                            :to="{
                                name: 'activity.show',
                                params: { activity: item.id },
                            }"
                            v-on="on"
                            ><v-icon>mdi-eye</v-icon></v-btn
                        >
                    </template>
                    <span>Detail</span>
                </v-tooltip>
            </template>
        </v-data-table>
            </v-card-text>
        </v-card>
    </v-container>

</template>
<script>
import contants from "../../constants";
import axiosApiInstance from '../../utilites'
export default {
    data: () => ({
        loading: true,
        constants: contants,
        model: {},
        options: {
            sortBy: ["id"],
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
            },
        },
        dataTable2: {
            headers: [],
            items: [],
            totalItems: 0,
            meta: {
                total: 0,
            },
        },
        // [ 'text' => 'No', 'sortable' => false, 'value' => 'no'],
        //         [ 'text' => 'Avatar', 'sortable' => false, 'value' => 'avatar'],
        //         [ 'text' => 'Name', 'sortable' => false, 'value' => 'name'],
        //         [ 'text' => 'Harvest', 'sortable' => false, 'value' => 'harvest'],
        //         [ 'text' => 'Expire', 'sortable' => false, 'value' => 'expire'],
        //         [ 'text' => 'Type', 'sortable' => false, 'value' => 'category.name'],
        //         // [ 'text' => 'Detail', 'sortable' => false, 'value' => 'detail'],
        //         [ 'text' => 'Actions', 'sortable' => false, 'value' => 'actions'],
        options1: {
            sortBy: ["id"],
            sortDesc: [true],
            itemsPerPage: 15,
            page: 1,
        },
        dataTable1: {
            headers: [
                {
                text: 'No',
                sortable: false,
                value: 'no'
                },
                {
                text: 'Avatar',
                sortable: false,
                value: 'avatar'
                },
                {
                text: 'Name',
                sortable: false,
                value: 'name'
                },
                {
                text: 'Min',
                sortable: false,
                value: 'pivot.min'
                },
                {
                text: 'Max',
                sortable: false,
                value: 'pivot.max'
                },
                {
                text: 'Regular',
                sortable: false,
                value: 'pivot.regular'
                },
                {
                text: 'Actions',
                sortable: false,
                value: 'actions'
                }
            ],
            items: [],
            totalItems: 0,
            meta: {
                total: 0,
            },
        },
        searchQuery: null,
    }),

    mounted()
    {
        this.fetchData()
        this.fetchDisease()
        this.fetchCondition()
        this.fetchActivity()
    },

    methods:
    {
        fetchData()
        {
            axiosApiInstance.get(`crop/${ this.$route.params.crop }`)
            .then(response => {

                this.model = response.data

            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.loading = false
            })
        },
        fetchDisease()
        {
            axiosApiInstance.get(`crop/${ this.$route.params.crop }/disease`, {
                params: {
                        page: this.options.page,
                        perpage:
                            this.options.itemsPerPage === -1
                                ? this.dataTable.totalItems
                                : this.options.itemsPerPage,
                        search: this.searchQuery,
                    },
                })
            .then(response => {
                // this.model = response.data
                this.dataTable = response.data
                // console.log(response.data)

            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.loading = false
            })
        },

        fetchCondition()
        {
            axiosApiInstance.get(`crop/${ this.$route.params.crop }/condition`, {
                params: {
                        page: this.options1.page,
                        perpage:
                            this.options1.itemsPerPage === -1
                                ? this.dataTable.totalItems
                                : this.options1.itemsPerPage,
                        search: this.searchQuery,
                    },
                })
            .then(response => {
                // this.model = response.data
                // console.log(response.data.data[0].condition);
                this.dataTable1.items = response.data.data[0].condition
                // console.log(response.dataTable1.items)

            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.loading = false
            })
        },

        fetchActivity()
        {
            axiosApiInstance.get(`crop/${ this.$route.params.crop }/activity`, {
                params: {
                        page: this.options.page,
                        perpage:
                            this.options.itemsPerPage === -1
                                ? this.dataTable.totalItems
                                : this.options.itemsPerPage,
                        search: this.searchQuery,
                    },
                })
            .then(response => {
                // this.model = response.data
                this.dataTable2 = response.data
                // console.log(response.data)

            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
