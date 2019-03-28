<template>
  <div class="reviews">
    <div class="row">
      <div class="col-1" />
      <div class="col-10">
        <div class="row">
          <review v-for="item in content" :key="item.id" :title="item.title" :content="item.content" />
        </div>
      </div>
      <div class="col-1" />
    </div>
  </div>
</template>

<script>
import Review from '@/components/frontpage/Review.vue'
export default {
  components: {
    Review
  },
  data: function() {
    return {
      content: [],
      page: 1
    }
  },
  mounted: function() {
    this.getReviewData(this.page)
  },
  methods: {
    getReviewData: function(page) {
      const self = this
      this.$axios
        .get('posts?categories=6&per_page=2&page=' + self.page)
        .then(function(response) {
          console.log(response)
          self.content = []
          for (let i = 0; i < response.data.length; i++) {
            const review = {}
            review.id = response.data[i].id
            review.title = response.data[i].title.rendered
            review.content = response.data[i].content.rendered
            self.content.push(review)
          }
          console.log(self.content)
        })
    }
  }
}
</script>

<style>
</style>
