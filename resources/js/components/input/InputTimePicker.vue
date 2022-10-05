<template>
    <span >
        <v-text-field
            v-model="model"
            prepend-inner-icon="mdi-clock-outline"
            @click:prepend-inner="time_diaglog = true"
            clearable
            @input="timeInput"
            :maxLength="5"
            hint="H24:MN"
            persistent-hint
            :outlined="outlined"
            :label="label"
            :rules="rules"
            >
        </v-text-field>
        <v-dialog
            ref="time_menu"
            v-model="time_diaglog"
            :close-on-content-click="false"
            :return-value.sync="model"
            transition="scale-transition"
            max-width="290px"
            min-width="290px">
            <v-time-picker
                v-model="model"
                full-width
                format="24hr"
                :min="min"
                @click:minute="$refs.time_menu.save(model)">
            </v-time-picker>
        </v-dialog>
    </span>
</template>

<script>
export default {
    props: {
   
        value: {
            
        },
        label: {
            default:'Time picker'
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
        timeInput()
        {
            if (this.model && this.model.length == 2){
                this.model = this.model + ':'
            }
        }
    }
}
</script>