<template>
  <div v-if="!cookiesAccepted && stateChecked" class="cookie-law-container container">
    <div class="row">
      <div class="col-9 flex-center">
        <p class="cookie-law-message flex-center">
          Sellel veebilehel kasutatakse kasutajamugavuse suurendamise ja toimimise parandamise eesmärgil "küpsiseid"
        </p>
      </div>
      <div class="col flex-center">
        <button class="cookie-law-button" @click="setCookiesAccepted()">
          Nõustun
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      cookiesAccepted: false,
      stateChecked: false
    }
  },
  mounted: function() {
    this.checkAcceptState()
  },
  methods: {
    checkAcceptState: function() {
      const state = localStorage.getItem('cookiesAccepted')
      this.cookiesAccepted = state
      this.stateChecked = true
    },
    setCookiesAccepted: function() {
      localStorage.setItem('cookiesAccepted', true)
      this.checkAcceptState()
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.cookie-law-container {
  padding-top: 5px;
  padding-bottom: 10px;
}
.cookie-law-message {
  margin-bottom: 0px;
}
.flex-center {
  display: flex;
  align-content: center;
  align-items: center;
  align-self: center;
}
.cookie-law-button {
  background-color: $green;
  color: white;
  border: none;
}
</style>
