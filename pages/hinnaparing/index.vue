<template>
  <div class="content page-slug">
    <div class="container-fluid">
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
export default {
  data: function() {
    return {
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
      const quoteFormData = new FormData()

      quoteFormData.set('name', this.form.name)
      quoteFormData.set('email', this.form.email)
      quoteFormData.set('phone', this.form.phone)
      quoteFormData.set('date', this.form.date)
      quoteFormData.set('start_floor', this.form.startFloor)
      quoteFormData.set('end_floor', this.form.endFloor)
      quoteFormData.set('list', this.form.list)

      this.$axios({
        method: 'post',
        url: 'http://localhost:3001/quote',
        data: quoteFormData
      }).then(function(response) {})
    }
  },
  head: function() {
    return {
      title: 'Kolimisteenused | OK Movers – Kolimine, Transport, Ladustamine'
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
</style>
