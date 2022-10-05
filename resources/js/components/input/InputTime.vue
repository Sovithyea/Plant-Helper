<template>
    <v-menu
        ref="menu"
        v-model="show"
        :close-on-content-click="false"
        :nudge-right="40"
        :return-value.sync="model"
        transition="scale-transition"
        offset-y
        max-width="290px"
        min-width="290px">
        <template v-slot:activator="{ on, attrs }">
            <v-text-field
                v-model="model"
                :label="label"
                :outlined="outlined"
                prepend-inner-icon="mdi-clock-time-four-outline"
                readonly
                :rules="rules"
                v-bind="attrs"
                v-on="on">
            </v-text-field>
        </template>
        <v-time-picker
            v-if="show"
            v-model="model"
            full-width
            :min="min"
            :format="format"
            @click:minute="$refs.menu.save(model)">
        </v-time-picker>
    </v-menu>
</template>

<script>
export default {
    props: {
        label: {},
        value: {},
        outlined: {},
        rules: {},
        min: {},
        format: {}

    },

    data: () => ({
        show: false,
    }),

    computed: {
        model: {
            get () {
                return this.value
            },
            set (value) {
                this.$emit('input', value)
            }
        }
    },

    methods: {
        change()
        {
            this.$emit('change', this.value)
        }
    }
}
</script>