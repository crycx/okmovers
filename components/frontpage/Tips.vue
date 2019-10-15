<template>
  <b-jumbotron class="tips">
    <h2 class="tips-header">
      KOLIMISNÕUANDED
    </h2>
    <div class="underline ml-auto mr-auto" />
    <div class="row tips-row">
      <tip
        v-for="item in content"
        :key="item.id"
        :title="item.title.rendered"
        :slug="item.slug"
      />
    </div>
  </b-jumbotron>
</template>

<script>
import Tip from '@/components/frontpage/Tip.vue'
export default {
  components: {
    Tip
  },
  data: function() {
    return {
      content: null
    }
  },
  mounted: function() {
    this.getData()
  },
  methods: {
    getData: function() {
      const self = this
      this.$axios
        .get('posts?categories=8&per_page=14')
        .then(function(response) {
          self.content = response.data
        })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';

.tips {
  margin-bottom: 0px;
  .tips-header {
    color: $orange;
    text-align: center;
    margin-bottom: 0;
  }
  .header-underline {
    color: $orange;
    height: 5px;
    background-color: $orange;
    width: 70px;
    display: flex;
    align-self: center;
    margin-bottom: 10px;
  }
  .underline {
    margin-bottom: 40px;
  }
}
@media screen and (max-width: $md) {
  .tips {
    padding: 0;
    .tips-header {
      padding-top: 15px;
    }
  }
  .tips-row {
    display: flex;
    justify-content: center;
  }
}
</style>
