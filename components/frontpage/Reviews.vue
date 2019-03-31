<template>
  <div class="reviews">
    <div class="row">
      <div class="col-1" />
      <div class="col-10">
        <div v-if="reviewsAreLoaded" class="row">
          <review v-for="item in content" :key="item.id" :title="item.title" :content="item.content" :image-url="item.imageUrl" />
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
      page: 1,
      contentIsLoaded: false,
      reviewsAreLoaded: false
    }
  },
  watch: {
    contentIsLoaded: function(val) {
      this.getImageUrls()
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
            review.imageId = response.data[i].featured_media
            self.content.push(review)
          }
          self.contentIsLoaded = true
          console.log(self.content)
        })
    },
    getImageUrls: function() {
      const self = this
      console.log(this.content)
      console.log('imgurls getter')
      console.log(this.content.length)
      const promises = []
      for (let j = 0; j < this.content.length; j++) {
        // const self = this
        console.log('pushing promise...')
        promises.push(
          this.$axios
            .get('media/' + this.content[j].imageId)
            .then(function(response) {
              self.content[j].imageUrl = response.data.source_url
            })
        )
        Promise.all(promises).then(function(response) {
          self.reviewsAreLoaded = true
        })
      }
      console.log(promises)
    }
  }
}
</script>

<style lang="scss">
.reviews {
  padding-top: 5%;
  padding-bottom: 5%;
}
</style>
