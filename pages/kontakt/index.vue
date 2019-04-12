<template>
  <div class="content page-slug">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <contact-header />
        </div>
      </div>
      <div class="row contact-form-row">
        <div class="col-md-4 col-sm-12 contacts-container" v-html="contacts" />
        <div class="col-md-8 col-sm-12">
          <b-form>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <b-input type="text" placeholder="Nimi" />
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <b-input type="email" placeholder="E-mail" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <b-textarea placeholder="Kirjuta meile!" rows="5" />
            </div>
            <div class="row">
              <div class="col-12 button-container">
                <button class="send-button" @click="sendForm">
                  SAADA
                </button>
              </div>
            </div>
          </b-form>
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
      const quoteFormData = new FormData()

      quoteFormData.set('name', this.form.name)
      quoteFormData.set('email', this.form.email)
      quoteFormData.set('content', this.form.content)

      this.$axios({
        method: 'post',
        url: 'http://localhost:3001/contact',
        data: quoteFormData
      }).then(function(response) {
        console.log(response)
      })
    }
  },
  head: function() {
    return {
      title: 'OK Movers',
      meta: [{ hid: 'description', name: 'description', content: 'asso pls' }]
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

.contact-form-row {
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
