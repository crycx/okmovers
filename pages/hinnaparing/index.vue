<template>
  <div class="content page-slug">
    <div v-if="loading" class="sendingLoad">
      <div class="lds-ring">
        <div /><div /><div /><div />
      </div>
    </div>
    <div class="container-fluid">
      <div class="row alert-container">
        <div class="col-12">
          <div v-if="messageSent" class="alert alert-success">
            <h2>Päring saadetud!</h2>
          </div>
          <div v-if="messageFailed" class="alert alert-danger">
            <h2>{{ failureText }}</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="heading-container">
            <h1 class="post-title">
              Hinnapäring
            </h1>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-10 offset-1">
                <div class="upper-group">
                  <b-form-group>
                    <b-input v-model="form.name" type="text" placeholder="Sinu nimi" name="Nimi" />
                  </b-form-group>
                  <b-form-group>
                    <b-input v-model="form.email" type="email" placeholder="E-posti aadress" name="E-post" />
                  </b-form-group>
                  <b-form-group>
                    <b-input v-model="form.phone" type="text" placeholder="Telefon" name="Telefon" />
                  </b-form-group>
                </div>
                <div class="lower-group">
                  <b-form-group>
                    <b-input v-model="form.date" type="text" placeholder="Orienteeruv kolimise kuupäev" name="Kuupäev" />
                  </b-form-group>
                  <b-form-group>
                    <b-input v-model="form.startFloor" type="text" placeholder="Peale laadimise aadress/korrus/lift?" name="Peale laadimise aadress/korrus/lift" />
                  </b-form-group>
                  <b-form-group>
                    <b-input v-model="form.endFloor" type="text" placeholder="Maha laadimise aadress/korrus/lift?" name="Maha laadimise aadress/korrus/lift" />
                  </b-form-group>
                  <b-form-group>
                    <b-textarea v-model="form.list" placeholder="Siia palume sisestada võimalikult täpse asjade loetelu, kas on vaja midagi demonteerida, kas soovite kolimiskaste jne" rows="7" name="Asjade loetelu" />
                  </b-form-group>
                  <b-form-group class="quote-button-group">
                    <b-button class="quote-button" @click="sendForm">
                      SAADA
                    </b-button>
                  </b-form-group>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { required, email } from 'vuelidate'
export default {
  data: function() {
    return {
      loading: false,
      sent: false,
      messageSent: false,
      messageFailed: false,
      failureText: '',
      form: {
        name: '',
        email: '',
        phone: '',
        date: '',
        startFloor: '',
        endFloor: '',
        list: ''
      }
    }
  },
  methods: {
    sendForm: function() {
      const self = this
      const quoteFormData = new FormData()
      quoteFormData.set('name', this.form.name)
      quoteFormData.set('email', this.form.email)
      quoteFormData.set('phone', this.form.phone)
      quoteFormData.set('date', this.form.date)
      quoteFormData.set('start_floor', this.form.startFloor)
      quoteFormData.set('end_floor', this.form.endFloor)
      quoteFormData.set('list', this.form.list)

      this.loading = true
      this.$axios({
        method: 'post',
        url: 'https://emailservice.ermine.ee/quote',
        data: quoteFormData
      })
        .then(function(response) {
          if (response.status === 200) {
            self.loading = false
            self.done = true
            self.displaySuccess(self)
            self.form.name = ''
            self.form.email = ''
            self.form.phone = ''
            self.form.date = ''
            self.form.startFloor = ''
            self.form.endFloor = ''
            self.form.list = ''
          } else {
            self.loading = false
            self.done = true
            self.displayFailure(
              self,
              'Midagi läks valesti! Proovige hiljem uuesti.'
            )
          }
        })
        .catch(function(error) {
          console.log(error)
          self.loading = false
          self.done = true
          self.displayFailure(
            self,
            'Midagi läks valesti. Palun kirjutage email: <a href="mailto:info@okmovers.ee">info@okmovers.ee</a>'
          )
        })
    },
    displaySuccess: function(ctx) {
      ctx.messageSent = true
      setTimeout(function() {
        ctx.messageSent = false
      }, 5000)
    },
    displayFailure: function(ctx, text) {
      ctx.failureText = text
      ctx.messageFailed = true
      setTimeout(function() {
        ctx.messageFailed = false
        ctx.failureText = ''
      }, 5000)
    }
  },
  validations: {
    form: {
      name: { required },
      email: { required, email },
      phone: { required },
      date: { required },
      startFloor: { required },
      endFloor: { required },
      list: { required }
    }
  },
  head: function() {
    return {
      title: 'Kolimisteenused | OK Movers – Kolimine, Transport, Ladustamine',
      link: [{ rel: 'canonical', href: 'https://www.okmovers.ee/hinnaparing' }]
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.quote-button-group {
  display: flex;
  div {
    display: flex;
    justify-content: center;
    .quote-button {
      border-radius: 6px;
      font-size: 20px;
      justify-self: center;
      border: none;
      background-color: $green;
      transition-property: background;
      transition-duration: 0.25s;
      transition-timing-function: linear;
      width: 250px;
      height: 60px;
      &:hover {
        background-color: $orange;
      }
    }
  }
}
.alert {
  text-align: center;
  h2 {
    font-size: 24px;
  }
}
.sendingLoad {
  z-index: 99999;
  display: flex;
  position: fixed;
  top: 0;
  bottom: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  justify-content: center;
  align-content: center;
  .lds-ring {
    margin-top: 300px;
    display: inline-block;
    position: relative;
    width: 64px;
    height: 64px;
  }
  .lds-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 51px;
    height: 51px;
    margin: 6px;
    border: 6px solid #fff;
    border-radius: 50%;
    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: $green transparent transparent transparent;
  }
  .lds-ring div:nth-child(1) {
    animation-delay: -0.45s;
  }
  .lds-ring div:nth-child(2) {
    animation-delay: -0.3s;
  }
  .lds-ring div:nth-child(3) {
    animation-delay: -0.15s;
  }
  @keyframes lds-ring {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
}
</style>
