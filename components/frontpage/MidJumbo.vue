<template>
  <b-jumbotron class="mid-jumbo">
    <div class="col-10 offset-1">
      <div class="row frontpage-header">
        <h2 class="midjumbo-header">
          MIDA ME PAKUME
        </h2>
      </div>
      <div class="underline" />
      <div class="row midjumbo-top-row ml-auto mr-auto">
        <front-page-icon
          v-for="item in topRowContent"
          :key="item.id"
          :title="item.title.rendered"
          :text="item.excerpt.rendered"
          :featured-image="item.featured_media"
          :slug="item.slug"
        />
      </div>
      <div class="row">
        <front-page-icon
          v-for="item in bottomRowContent"
          :key="item.id"
          :title="item.title.rendered"
          :text="item.excerpt.rendered"
          :featured-image="item.featured_media"
          :slug="item.slug"
        />
      </div>
    </div>
    </div>
  </b-jumbotron>
</template>

<script>
import FrontPageIcon from '@/components/general/FrontPageIcon.vue'
export default {
  components: {
    FrontPageIcon
  },
  data: function() {
    return {
      topRowContent: [],
      bottomRowContent: []
    }
  },
  mounted: function() {
    this.getUpperRow()
    this.getLowerRow()
  },
  methods: {
    getUpperRow: function() {
      const self = this
      this.$axios.get('posts?categories=18').then(function(response) {
        self.topRowContent = response.data
      })
    },
    getLowerRow: function() {
      const self = this
      this.$axios.get('posts?categories=19').then(function(response) {
        self.bottomRowContent = response.data
      })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';

.mid-jumbo {
  background-color: $blue;
  color: white;
  padding-top: 1%;
}
.midjumbo-header {
  padding-top: 25px;
  margin-bottom: 0;
  &:after {
    content: ' ';
    height: 5px;
    background-color: $orange;
  }
}
.midjumbo-top-row {
  width: 80%;
}
.frontpage-header {
  display: flex;
  justify-content: center;
  text-align: center;
  color: $orange;
}
</style>
