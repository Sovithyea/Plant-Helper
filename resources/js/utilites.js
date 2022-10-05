import axios from "axios"
import store from "./store"
import constants from './constants'

axios.defaults.baseURL = constants.baseUrl

const axiosApiInstance = axios.create({
  baseURL: constants.apiUrl,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },

})

axiosApiInstance.interceptors.request.use((config) => {
  const token = store.state.auth.accessToken
  config.headers['x-localization'] = store.state.locale
  if (token) config.headers['Authorization'] = `Bearer ${token}`

  return config
})

let failedQueue = [];

const processQueue = (error = null) => {
  if (error) failedQueue.forEach(prom => {prom.reject(error)})
  else failedQueue.forEach(prom => { prom.resolve()})

  failedQueue = [];
}

axiosApiInstance.interceptors.response.use(response => {
  return response
}, async error => {
  const originalRequest = error.config

  if (error.response.status == 401 && !originalRequest._retry)
  {
    originalRequest._retry = true

    if(store.state.auth.isTokenRefreshing)
    {
      return new Promise(function(resolve, reject){
        failedQueue.push({ resolve, reject })
      })
      .then(() => {
        return axiosApiInstance(originalRequest)
      })
      .catch((_error) => {
        return Promise.reject(_error)
      })
    }

    return new Promise((resolve, reject) => {
      store.dispatch('auth/refreshToken').then(() => {
        processQueue();
        resolve(axiosApiInstance(originalRequest))
      }).catch((_error) => {
        window.location.replace('login')
        // processQueue(_error);
        reject(_error)
      })
    })
  }

  return Promise.reject(error);
})

export default axiosApiInstance
