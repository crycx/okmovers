<template>
  <b-jumbotron class="top-jumbo">
    <div class="row">
      <div class="col-6 top-jumbo-left">
        <h2 class="top-jumbo-header">
          {{ title }}
        </h2>
        <div class="underline underline-wide" />
        <div class="col-8 offset-2">
          <div class="top-jumbo-text-container" v-html="text" />
        </div>
        <div class="row">
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
      <div class="col-6 top-jumbo-right">
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
        console.log(response.data.content.rendered)
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
</style>
