import Vue from 'vue'
import VueI18n from "vue-i18n";
import messages from './../lang/index.js'

Vue.use(VueI18n)

const i18n = new VueI18n({
    locale: 'en',
    fallbackLocale: 'en',
    silentTranslationWarn: true,
    messages,
})

export default i18n
