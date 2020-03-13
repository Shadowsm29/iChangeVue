import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import Permissions from "~/mixins/Permissions"

import i18n from '~/plugins/i18n'
import App from '~/components/App'
import axios from "axios"

import '~/plugins'
import '~/components'

import './plugins/table.js'

Vue.prototype.$http = axios;
Vue.mixin(Permissions);
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
