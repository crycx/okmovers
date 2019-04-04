<template>
  <div class="reviews">
    <div class="row">
      <div class="col-1 reviews-button-col">
        <button class="reviews-button reviews-button-left" />
      </div>
      <div class="col-10">
        <div v-if="reviewsAreLoaded" class="row">
          <review v-for="item in content" :key="item.id" :title="item.title" :content="item.content" :image-url="item.imageUrl" />
        </div>
      </div>
      <div class="col-1 reviews-button-col">
        <button class="reviews-button reviews-button-right" />
      </div>
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
      pageLimit: null,
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
      self.contentIsLoaded = false
      self.reviewsAreLoaded = false
      this.$axios
        .get('posts?categories=6&per_page=2&page=' + self.page)
        .then(function(response) {
          console.log(response)
          self.content = []
          self.pageLimit = parseInt(response.headers['x-wp-totalpages'])
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
    },
    incrementPage: function() {
      const pagePre = this.page
      if (this.page === this.pageLimit) {
        this.page = 1
      } else {
        this.page += 1
      }
      if (this.page === pagePre) {
      } else {
        this.getImageUrls()
      }
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.reviews {
  padding-top: 5%;
  padding-bottom: 5%;
}
.reviews-button-col {
  display: flex;
  align-content: center;
  flex-direction: column;
  justify-content: center;
  .reviews-button {
    background-color: transparent;
    width: 0;
    height: 0;
    border-style: solid;
  }
  .reviews-button-left {
    border-width: 25px 50px 25px 0;
    border-color: transparent $orange transparent transparent;
    transition-property: border-color;
    transition-duration: 0.25s;
    transition-timing-function: linear;
    &:hover {
      border-color: transparent $orange-dark transparent transparent;
    }
  }
  .reviews-button-right {
    border-width: 25px 0 25px 50px;
    border-color: transparent transparent transparent $orange;
    transition-property: border-color;
    transition-duration: 0.25s;
    transition-timing-function: linear;
    &:hover {
      border-color: transparent transparent transparent $orange-dark;
    }
  }
}
</style>
