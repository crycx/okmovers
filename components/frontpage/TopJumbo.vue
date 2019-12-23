<template>
  <b-jumbotron class="top-jumbo">
    <div class="row">
      <div class="col-md-12 col-lg-6 top-jumbo-left">
        <h2 class="top-jumbo-header">
          {{ title }}
        </h2>
        <div class="underline" />
        <div class="col-lg-8 col-md-10 offset-lg-2 offset-md-1">
          <div class="top-jumbo-text-container" v-html="text" />
        </div>
        <div class="row frontpage-button-row">
          <div class="col-6">
            <nuxt-link to="/hinnaparing">
              <button class="frontpage-button frontpage-button-green">
                Esita kiire hinnapäring
              </button>
            </nuxt-link>
          </div>
          <div class="col-6">
            <nuxt-link to="/kolimisnouanded">
              <button class="frontpage-button frontpage-button-blue">
                Vaata meie kolimisnippe
              </button>
            </nuxt-link>
          </div>
        </div>
      </div>
      <div class="col-6 top-jumbo-right d-none d-lg-block">
        <div v-if="videoIsLoaded" class="player-container">
          <b-embed 
            type="iframe"
            aspect="16by9"
            src="https://www.youtube.com/embed/ZBNKfED4MOg"
          /></b-embed>
        </div>
      </div>
    </div>
  </b-jumbotron>
</template>

<script>
export default {
  data: function() {
    return {
      contentVideo: null,
      videoIsLoaded: false,
      text: '',
      title: ''
    }
  },
  mounted: function() {
    this.getVideo()
    this.getText()
  },
  methods: {
    getVideo: function() {
      const self = this
      this.$axios.get('posts/310').then(function(response) {
        self.contentvideo = response.data.content.rendered
        self.videoIsLoaded = true
      })
    },
    getText: function() {
      const self = this
      this.$axios.get('posts/345').then(function(response) {
        self.text = response.data.content.rendered
        self.title = response.data.title.rendered
      })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.frontpage-button {
  font-size: 20px;
  max-width: 75%;
  border-radius: 6px;
  border-width: 0px;
  padding: 3% 3%;
}
.frontpage-button-blue {
  background-color: $blue;
  color: white;
  &:hover {
    background-color: $orange;
  }
}
.frontpage-button-green {
  border-style: solid;
  background-color: $green;
  color: white;
  &:hover {
    border-color: $orange;
    background-color: $orange;
  }
}
.top-jumbo-left {
  text-align: center;
}
.top-jumbo-header {
  margin-bottom: 0;
  color: $blue;
}
.top-jumbo-text-container {
  p {
    color: $blue;
    font-size: 20px;
    font-weight: bold;
  }
  em {
    color: $orange;
    font-style: normal;
  }
  del {
    color: $green;
    text-decoration: none;
  }
}
.player-container {
  background-color: $blue;
  height: 360px;
  width: 640px;
}
.frontpage-button-row {
  padding-left: 20%;
  padding-right: 20%;
}
@media screen and (max-width: 1330px) {
  .player-container {
    height: 300px;
    width: 533px;
  }
}
@media screen and (max-width: 1270px) {
  .frontpage-button {
    font-size: 18px;
    width: 100%;
  }
}
@media screen and (max-width: 1128px) {
  .frontpage-button {
    font-size: 14px;
    width: 100%;
  }
}
@media screen and (max-width: 1100px) {
  .player-container {
    height: 270px;
    width: 480px;
  }
}
@media screen and (max-width: 1080px) {
  .midjumbo-top-row {
    margin-left: 0;
    margin-right: 0;
  }
}
@media screen and (max-width: $lg) {
  .frontpage-button {
    font-size: 18px;
    width: 100%;
  }
  .frontpage-button-row {
    padding-left: 2%;
    padding-right: 2%;
  }
  .frontpage-button {
    max-width: 100%;
  }
}
</style>
