<template>
  <div class="container-fluid footer">
    <div v-if="leftDataLoaded === true && rightDataLoaded === true && centerDataLoaded === true" class="row">
      <div class="col-md-5 col-sm-12 left-data-container">
        <div class="left-data-text" v-html="dataLeft.content.rendered" />
      </div>
      <div class="col-md-2 col-sm-12 center-data-container">
        <div class="center-data-text" v-html="dataCenter.content.rendered" />
      </div>
      <div class="col-md-5 col-sm-12 right-data-container">
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
        self.dataLeft = response.data
        self.leftDataLoaded = true
      })
      this.$axios.get('posts/274').then(function(response) {
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
  padding-bottom: 25px;
  .row {
    .left-data-text {
      font-weight: 600;
      h4 {
        font-weight: 600;
        color: $orange;
        font-size: 18px;
      }
      p {
        font-weight: 600;
        em {
          color: $orange;
          font-style: normal;
          a {
            color: $orange;
            font-style: normal;
          }
        }
      }
    }
    .center-data-text {
      text-align: center;
      font-weight: 600;
      p {
        margin-bottom: 2px;
        font-weight: 600;
        em {
          color: $green;
          font-style: normal;
          a {
            color: $orange;
            font-style: normal;
          }
        }
        strong {
          font-weight: 600;
          color: $orange;
          font-weight: normal;
          a {
            color: $orange;
            font-style: normal;
          }
        }
      }
    }
    .right-data-text {
      font-weight: 600;
      h4 {
        font-weight: 600;
        color: $orange;
        font-size: 18px;
      }
      p {
        font-weight: 600;
        em {
          color: $orange;
          font-style: normal;
          a {
            color: $orange;
            font-style: normal;
          }
        }
      }
    }
  }
  @media screen and (max-width: $md) {
    .left-data-text,
    .right-data-text,
    .center-data-text {
      h4 {
        text-align: center;
      }
      p {
        text-align: center;
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
  @media screen and (max-width: $md) {
    .link-container-right {
      padding-left: 0;
      .footer-link {
        margin-left: 15px;
        margin-right: 15px;
        .footer-link-image {
          height: 40px;
          width: 40px;
        }
      }
      justify-content: center;
    }
  }
}
</style>
