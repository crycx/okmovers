<template>
  <b-jumbotron class="tips">
    <h2 class="tips-header">
      Kolimisnõuanded
    </h2>
    <div class="row">
      <tip
        v-for="item in content"
        :key="item.id"
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
      content: [
        { id: 1 },
        { id: 2 },
        { id: 3 },
        { id: 4 },
        { id: 5 },
        { id: 6 },
        { id: 7 },
        { id: 1 },
        { id: 2 },
        { id: 3 },
        { id: 4 },
        { id: 5 },
        { id: 6 },
        { id: 7 }
      ]
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
  }
}
</style>
