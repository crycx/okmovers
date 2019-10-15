<template>
  <div class="content page-slug">
    <div v-if="loading" class="sendingLoad">
      <div class="lds-ring">
        <div /><div /><div /><div />
      </div>
    </div>
    <div class="container">
      <div class="row alert-container">
        <div class="col-12">
          <div v-if="messageSent" class="alert alert-success">
            <h2>Päring saadetud!</h2>
          </div>
          <div v-if="messageFailed" class="alert alert-danger">
            <h2>Midagi läks valesti! Proovige hiljem uuesti.</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <contact-header />
        </div>
      </div>
      <div class="row contact-form-row">
        <div class="col-md-4 col-sm-12 contacts-container" v-html="contacts" />
        <div class="col-md-8 col-sm-12">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <b-input v-model="form.name" type="text" placeholder="Nimi" />
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <b-input v-model="form.email" type="email" placeholder="E-mail" />
              </div>
            </div>
          </div>
          <div class="form-group">
            <b-textarea v-model="form.content" placeholder="Kirjuta meile!" rows="5" />
          </div>
          <div class="row">
            <div class="col-12 button-container">
              <button class="send-button" @click="sendForm">
                SAADA
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import ContactHeader from '@/components/general/ContactHeader.vue'
export default {
  components: {
    ContactHeader
  },
  data: function() {
    return {
      contacts: null,
      loading: false,
      sent: false,
      messageSent: false,
      messageFailed: false,
      form: {
        name: '',
        email: '',
        content: ''
      }
    }
  },
  mounted: function() {
    this.getContacts()
  },
  methods: {
    getContacts: function() {
      const self = this
      this.$axios.get('posts/246').then(function(response) {
        self.contacts = response.data.content.rendered
      })
    },
    sendForm: function() {
      const self = this
      const quoteFormData = new FormData()

      quoteFormData.set('name', this.form.name)
      quoteFormData.set('email', this.form.email)
      quoteFormData.set('content', this.form.content)

      this.loading = true
      this.$axios({
        method: 'post',
        url: 'https://emailservice.ermine.ee/contact',
        data: quoteFormData
      })
        .then(function(response) {
          if (response.status === 200) {
            self.loading = false
            self.done = true
            self.displaySuccess(self)
            self.form.name = ''
            self.form.email = ''
            self.form.content = ''
          } else {
            self.loading = false
            self.done = true
            self.displayFailure(self)
          }
        })
        .catch(function(error) {
          console.log(error)
          self.loading = false
          self.done = true
          self.displayFailure(self)
        })
    },
    displaySuccess: function(ctx) {
      ctx.messageSent = true
      setTimeout(function() {
        ctx.messageSent = false
      }, 5000)
    },
    displayFailure: function(ctx) {
      ctx.messageFailed = true
      setTimeout(function() {
        ctx.messageFailed = false
      }, 5000)
    }
  },
  head: function() {
    return {
      title: 'Kolimisteenused | OK Movers – Kolimine, Transport, Ladustamine',
      link: [{ rel: 'canonical', href: 'https://www.okmovers.ee/kontakt' }]
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.heading-container {
  text-align: center;
  .post-title {
    color: $orange;
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

.contact-form-row {
  margin-top: 30px;
  margin-bottom: 20px;
}
.contacts-container {
  text-align: center;
  border-right-style: solid;
  border-right-color: $blue;
  border-right-width: 1px;
  margin-bottom: 20px;
  p {
    color: $blue;
  }
}
.button-container {
  display: flex;
  justify-content: center;
  .send-button {
    border-radius: 6px;
    font-size: 20px;
    justify-self: center;
    border: none;
    color: white;
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
</style>
