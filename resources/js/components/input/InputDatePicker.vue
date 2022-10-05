<template>
  <v-menu
    ref="menu"
    v-model="menu"
    :close-on-content-click="false"
    transition="scale-transition"
    offset-y
    min-width="auto"
  >
    <template v-slot:activator="{ on }">
      <v-text-field v-model="dateFormat"
        v-on:input="$emit('input', $event)"
        v-on="on"
        readonly
        :dense="dense"
        clearable
        outlined
        :hint="hint"
        :persistent-hint="persistentHint"
        :disabled="disabled"
        :hide-details="hideDetails"
        :prepend-inner-icon="prependInnerIcon"
        :required="required"
        :rules="rules"
        @change="initDate"
        :label="label"
        :placeholder="placeholder"
      />
    </template>
    <v-date-picker
      v-model="selected"
      @input="menu = false"
      @change="change"
      :min="parseDate(min)"
      :max="parseDate(max)"
    />
  </v-menu>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: ''
    },
    label: {
      type: String,
    },
    placeholder: {
      type: String,
    },
    required: {
      type: Boolean,
      default: false
    },
    rules: {

    },
    min: {
      type: String,
    },
    max: {
      type: String,
    },
    disabled: {
      type: Boolean,
      default: false
    },
    hideDetails: {
      type: Boolean,
      default: false
    },
    hint: {
      type: String,
    },
    persistentHint: {
      type: Boolean,
      default: false
    },
    dense: {
      type: Boolean,
      default: false
    },
    prependInnerIcon: {
        type: String,
    }
  },
  data () {
    return {
      menu: null,
      date: null,
      selected: null,
    }
  },
  computed: {
    dateFormat: {
      get () {
        return this.value
      },
      set (value) {
        this.$emit('input', value)
      }
    },
  },
  mounted(){
    setTimeout(() => {
      this.initDate()
    }, 100);
  },
  methods: {
    parseDate (date) {
      if (!date) { return null }
      const [day, month, year] = date.split('/')
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
    },
    initDate()
    {
      this.selected = this.parseDate(this.dateFormat)
    },
    change()
    {
      const [year, month, day] = this.selected.split('-')
      this.dateFormat = `${day.padStart(2, 0)}/${month.padStart(2, '0')}/${year}`
      this.$emit('change', this.dateFormat)
    }
  }
}
</script>
