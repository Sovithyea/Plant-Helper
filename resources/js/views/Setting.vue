<template>
<v-container fluid>
  <v-card class="mb-3">
    <v-card-title>{{ $t('setting') }}</v-card-title>
    <v-card-subtitle>View and manage setting</v-card-subtitle>
  </v-card>

  <v-card class="mb-4">
    <v-card-title>
        <v-card-title>
            {{ user.first_name }} {{user.last_name}}
        </v-card-title>
    </v-card-title>
  </v-card>
  <v-card>
    <v-tabs fixed-tabs>
      <v-tab>
        <v-icon left>mdi-account</v-icon>
        {{ $t('label.profile') }}
      </v-tab>
      <v-tab>
        <v-icon left>mdi-account</v-icon>
        {{ $t('label.change_password') }}
      </v-tab>
      <!-- <v-tab>
        <v-icon left>mdi-account</v-icon>
        {{ $t('label.notification') }}
      </v-tab> -->
      <!-- <v-tab>
        <v-icon left>mdi-account</v-icon>
        {{ $t('devices') }}
      </v-tab> -->
      <v-tab-item>
        <v-form @submit.prevent="updateProfile" ref="formProfile" lazy-validation :disabled="formProfile.submitting">
          <v-card flat>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <!-- <input-image-crop
                    v-model="formProfile.data.avatar"
                    :label="$t('label.avatar')">
                  </input-image-crop> -->
                </v-col>
                <v-col cols="12" class="py-0">

                  <v-text-field
                      autocomplete="off"
                      :label="$t('label.last_name')"
                      name="last_name"
                      v-model="formProfile.data.last_name"
                      required
                      :rules="[v => !!v || $t('validation.last_name')]"
                      outlined>
                  </v-text-field>
                </v-col>
                <v-col cols="12" class="py-0">

                  <v-text-field
                      autocomplete="off"
                      :label="$t('label.first_name')"
                      name="first_name"
                      v-model="formProfile.data.first_name"
                      required
                      :rules="[v => !!v || $t('validation.first_name')]"
                      outlined>
                  </v-text-field>
                </v-col>
                <v-col cols="12" class="py-0">

                  <v-text-field
                      autocomplete="off"
                      :label="$t('label.username')"
                      name="username"
                      v-model="formProfile.data.username"
                      required
                      :rules="[v => !!v || $t('validation.username')]"
                      outlined>
                  </v-text-field>
                </v-col>
                <v-col cols="12" class="py-0">

                  <v-text-field
                      autocomplete="off"
                      :label="$t('label.email')"
                      name="email"
                      v-model="formProfile.data.email"
                      prepend-inner-icon="mdi-email"
                      type="email"
                      required
                      :rules="[v => !!v || $t('validation.email')]"
                      outlined>
                  </v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-btn type="submit" :loading="formProfile.submitting" color="success">{{ $t('button.save_changes') }}</v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-form>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <v-form @submit.prevent="changePassword" lazy-validation ref="formPassword" :disabled="formPassword.submitting">
              <v-row>
                <v-col cols="12" class="py-0">
                  <v-text-field
                      v-model="formPassword.data.old_password"
                      autocomplete="off"
                      :label="$t('label.old_password')"
                      prepend-inner-icon="mdi-lock"
                      required
                      :rules="[v => !!v || $t('validation.old_password')]"
                      type="password"
                      outlined>
                  </v-text-field>
                </v-col>
                <v-col cols="12" class="py-0">
                  <v-text-field
                      v-model="formPassword.data.password"
                      autocomplete="off"
                      :label="$t('label.new_password')"
                      prepend-inner-icon="mdi-lock"
                      required
                      :rules="[v => !!v || $t('validation.new_password'), v => (v && v.length >= 8) ||  $t('validation.new_password_at_least')]"
                      type="password"
                      outlined>
                  </v-text-field>
                </v-col>
                <v-col cols="12" class="py-0">
                  <v-text-field
                      v-model="formPassword.data.password_confirmation"
                      autocomplete="off"
                      :label="$t('label.confirm_password')"
                      prepend-inner-icon="mdi-lock"
                      required
                      :rules="confirmPasswordRule"
                      type="password"
                      outlined>
                  </v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-btn type="submit" ref="btn_change_password" :loading="formPassword.submitting" color="success">{{ $t('button.save_changes') }}</v-btn>
                </v-col>
              </v-row>
              </v-form>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <!-- <v-tab-item>
        <v-card flat>
          <v-card-text>
            <v-list>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>{{ $t('label.notification') }}</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    <v-switch></v-switch>
                  </v-list-item-action>
                </v-list-item>
              </v-list>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            {{ $t('devices') }}
          </v-card-text>
        </v-card>
      </v-tab-item> -->
    </v-tabs>
  </v-card>
</v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import axiosApiInstance from '../utilites'
export default {
    data: () => ({
      dialog: null,
      tab: null,

      formProfile: {
        submitting: false,
        data: {
          avatar: {
            src: '',
            file: null
          },
          first_name: '',
          last_name: '',
          username: '',
          email: '',
        }
      },

      formPassword: {
        submitting: false,
        data: {
          old_password: '',
          password: '',
          confirm_password: '',
        }
      }
    }),

    computed: {
      ...mapGetters('auth', {
        user: 'user'
      }),

      confirmPasswordRule()
      {
        return [
          v => !!v || this.$t('validation.confirm_password'),
          () => this.formPassword.data.password == this.formPassword.data.password_confirmation || this.$t('validation.confirm_password_not_match')
        ]
      }
    },

    mounted()
    {
      this.fetchProfile()
    },

    methods: {
      fetchProfile()
      {
        axiosApiInstance.get('setting/profile')
        .then(( response ) => {
          this.initFormProfile(response)
        })
      },

      initFormProfile(response)
      {
        this.formProfile.data = {
          avatar: {
            src: response.data.avatar,
            file: ''
          },
          first_name: response.data.first_name,
          last_name: response.data.last_name,
          username: response.data.username,
          email: response.data.email,
        }
      },

      updateProfile()
      {
        if (this.$refs.formProfile.validate())
        {
          this.formProfile.submitting = true
          let formData = new FormData()

          formData.append('first_name', this.formProfile.data.first_name)
          formData.append('last_name', this.formProfile.data.last_name)
          formData.append('username', this.formProfile.data.username)
          formData.append('email', this.formProfile.data.email)
        //   if (this.formProfile.data.avatar.src) formData.append('avatar[src]', this.formProfile.data.avatar.src)
        //   if (this.formProfile.data.avatar.file) formData.append('avatar[file]', this.formProfile.data.avatar.file)
          axiosApiInstance.post('setting/change_profile', formData, {
            headers: {'content-type': 'multipart/form-data'},
            params: {'_method': 'PUT'}
          })
          .then(( response ) => {
            this.$store.dispatch('pushNotification', { message: response.data.message, type: 'success' })
            this.fetchProfile()
            this.$store.dispatch("auth/getUser").catch(() => {})
          })
          .catch(({ response }) => {
            this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
          })
          .finally(() => {
            this.formProfile.submitting = false
          })
        }
      },

      changePassword()
      {
        if (this.$refs.formPassword.validate())
        {
          this.$refs.btn_change_password.$el.focus()
          this.$refs.btn_change_password.$el. blur()
          this.formPassword.submitting = true
          axiosApiInstance.post('setting/change_password', this.formPassword.data)
          .then(( response ) => {
            // this.$refs.formPassword.reset()
            this.$store.dispatch('pushNotification', { message: response.data.message, type: 'success' })
          })
          .catch(({ response }) => {
            this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
          })
          .finally(() => {
            this.formPassword.submitting = false
          })
        }
      },

    },
}
</script>
