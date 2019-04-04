<template>
  <div class="container-fluid footer">
    <div v-if="leftDataLoaded === true && rightDataLoaded === true" class="row">
      <div class="col-5 left-data-container">
        <div class="left-data-text" v-html="dataLeft.content.rendered" />
      </div>
      <div class="col-2 center-data-container">
        <div class="center-data-text" v-html="dataCenter.content.rendered" />
      </div>
      <div class="col-5 right-data-container">
        <div class="right-data-text" v-html="dataRight.content.rendered" />
        <div class="row link-container-right">
          <div class="footer-link">
            <a href="https://www.facebook.com/kolimisteenused/">
              <img class="footer-link-image" src="~/assets/facebook-logo.png">
            </a>
          </div>
          <div class="footer-link">
            <a href="https://www.linkedin.com/company/okmovers/about/">
              <img class="footer-link-image" src="~/assets/linkedin-logo.png">
            </a>
          </div>
          <div class="footer-link">
            <a href="https://www.youtube.com/channel/UCn9U6__qb3g79lGmSjbXUfA">
              <img class="footer-link-image" src="~/assets/youtube-logo.png">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      dataLeft: null,
      dataCenter: null,
      dataRight: null,
      leftDataLoaded: false,
      centerDataLoaded: false,
      rightDataLoaded: false
    }
  },
  mounted: function() {
    this.getContent()
  },
  methods: {
    getContent: function() {
      const self = this
      this.$axios.get('posts/270').then(function(response) {
        console.log(response)
        self.dataLeft = response.data
        self.leftDataLoaded = true
      })
      this.$axios.get('posts/274').then(function(response) {
        console.log(response)
        self.dataCenter = response.data
        self.centerDataLoaded = true
      })
      this.$axios.get('posts/272').then(function(response) {
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
  height: auto;
  padding-top: 25px;
  .row {
    .left-data-text {
      h4 {
        color: $orange;
        font-size: 18px;
      }
      p {
        em {
          color: $orange;
          font-style: normal;
        }
      }
    }
    .center-data-text {
      text-align: center;
      p {
        em {
          color: $green;
          font-style: normal;
        }
        strong {
          color: $orange;
          font-weight: normal;
        }
      }
    }
    .right-data-text {
      h4 {
        color: $orange;
        font-size: 18px;
      }
      p {
        em {
          color: $orange;
          font-style: normal;
        }
      }
    }
  }
  .link-container-right {
    display: flex;
    flex-direction: row;
    justify-content: left;
    padding-left: 15px;
    .footer-link {
      margin-right: 30px;
      .footer-link-image {
        height: 40px;
        width: 40px;
      }
    }
  }
}
</style>
