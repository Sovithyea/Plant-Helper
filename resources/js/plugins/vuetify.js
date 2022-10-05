import Vue from 'vue'
import Vuetify from 'vuetify'
// import { TiptapVuetifyPlugin } from 'tiptap-vuetify'

// const vuetify = new Vuetify()

Vue.use(Vuetify)
// Vue.use(TiptapVuetifyPlugin, {
//     vuetify,
//     iconsGroup: 'mdi'
// })

const opts = {
    icons: {
        iconfont: 'mdi'
    },
}

export default new Vuetify(opts)
