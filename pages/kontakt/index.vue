<template>
  <div class="content page-slug">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="heading-container">
            <h1 class="post-title">
              stuff here as header
            </h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4 contacts-container" v-html="contacts" />
        <div class="col-8">
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
                <button class="send-button">
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
export default {
  data: function() {
    return {
      contacts: null
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
.contacts-container {
  text-align: center;
  border-right-style: solid;
  border-right-color: $blue;
  border-right-width: 1px;
  p {
    color: $blue;
  }
}
.button-container {
  display: flex;
  justify-content: center;
  .send-button {
    background-color: $green;
    border: 0;
    color: white;
    width: 200px;
    height: 50px;
    font-size: 24px;
  }
}
</style>
