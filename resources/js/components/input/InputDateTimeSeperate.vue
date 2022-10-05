<template>
    <v-row>
        <v-col cols="6">
            <v-text-field 
                v-model="model.date"
                :outlined="outlined"
                clearable
                :hint="$t('hint.formatDate')"
                @input="dateInput"
                :rules="rules"
                :maxLength="10"
                persistent-hint
                prepend-inner-icon="mdi-calendar"
                @click:prepend-inner="date_diaglog = true"
                @blur="date = parseDate(model.date)"
                :label="label">
            </v-text-field>
            <v-dialog
                ref="date_menu"
                v-model="date_diaglog"
                :close-on-content-click="false"
                :return-value.sync="model.date"
                transition="scale-transition"
                :nudge-top="100 "
                max-width="290px"
                min-width="290px">
                <v-date-picker
                    v-model="date"
                    full-width
                    :min="parseDate(min)"
                    :max="parseDate(max)"
                    @input="$refs.date_menu.save(formatDate(date))">
                </v-date-picker>
            </v-dialog>
        </v-col>
        <v-col cols="6">
            <v-text-field
                v-model="model.time"
                prepend-inner-icon="mdi-clock-outline"
                @click:prepend-inner="time_diaglog = true"
                clearable
                @input="timeInput"
                :maxLength="5"
                hint="H24:MN"
                persistent-hint
                :outlined="outlined"
                placeholder="N/A">
            </v-text-field>
            <v-dialog
                ref="time_menu"
                v-model="time_diaglog"
                :close-on-content-click="false"
                :return-value.sync="model.time"
                transition="scale-transition"
                max-width="290px"
                min-width="290px">
                <v-time-picker
                    v-model="model.time"
                    full-width
                    format="24hr"
                    @click:minute="$refs.time_menu.save(model.time)">
                </v-time-picker>
            </v-dialog>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: {
        value: {

        },
        label: {

        },

        min: {

        },

        max: {

        },

        outlined: {
            type: Boolean,
            default: false
        },

        rules: {

        }
    },

    data: () => ({
        date: null,
        date_diaglog: false,
        time_diaglog: false,
    }),

    computed: {
        model: {
            get(){
                return this.value
            },
            set(value)
            {
                this.$emit('input', value)
            }
        },
    },

    methods: {
        formatDate (date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${day}/${month}/${year}`
        },

        parseDate (date) {
            if (!date) return null

            const [day, month, year] = date.split('/')
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        },

        dateInput()
        {
            if (this.model.date)
            {
                if (this.model.date.length == 2)
                {
                    this.model.date = this.model.date + '/'
                } else if (this.model.date.length == 5)
                {
                    this.model.date = this.model.date + '/'
                }
            }
        },

        timeInput()
        {
            if (this.model.time)
            {
                if (this.model.time.length == 2)
                {
                    this.model.time = this.model.time + ':'
                }
            }
        }
    }
}
</script>