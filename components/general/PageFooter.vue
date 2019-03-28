<template>
  <div class="container-fluid footer">
    <div v-if="leftDataLoaded === true && rightDataLoaded === true" class="row">
      <div class="col-6 left-data-container">
        <h2>{{ dataLeft.title.rendered }}</h2>
        <div class="left-data-text" v-html="dataLeft.content.rendered" />
      </div>
      <div class="col-6 right-data-container">
        <h2>{{ dataRight.title.rendered }}</h2>
        <div class="left-data-text" v-html="dataRight.content.rendered" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      dataLeft: null,
      dataRight: null,
      leftDataLoaded: false,
      rightDataLoaded: false
    }
  },
  mounted: function() {
    this.getContent()
  },
  methods: {
    getContent: function() {
      const self = this
      this.$axios.get('posts/45').then(function(response) {
        console.log(response)
        self.dataLeft = response.data
        self.leftDataLoaded = true
      })
      this.$axios.get('posts/47').then(function(response) {
        self.dataRight = response.data
        self.rightDataLoaded = true
      })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';

.footer {
  background-color: $blue;
  color: white;
  height: $footer-height;
}
</style>
