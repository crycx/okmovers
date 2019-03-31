<template>
  <b-jumbotron class="clients">
    <div class="row clients-header-cont">
      <h2 class="clients-header">
        Meie kliendid
      </h2>
    </div>
    <div class="row">
      <div class="col-1 clients-button-col">
        <button class="clients-button-left clients-button" @click="decrementPage" />
      </div>
      <div class="col-10">
        <div class="row client-images-container">
          <client v-for="item in content" :key="item.id" :url="item.source_url" />
        </div>
      </div>
      <div class="col-1 clients-button-col">
        <button class="clients-button-right clients-button" @click="incrementPage" />
      </div>
    </div>
  </b-jumbotron>
</template>

<script>
import Client from '@/components/frontpage/Client.vue'
export default {
  components: {
    Client
  },
  data: function() {
    return {
      content: [],
      page: 1,
      pageLimit: null,
      offset: 0
    }
  },
  mounted: function() {
    this.getClients(this.page)
  },
  methods: {
    getClients: function(page, offset) {
      const self = this
      this.$axios
        .get(
          'media?parent=150&per_page=6&page=' +
            this.page +
            '&offset=' +
            this.offset
        )
        .then(function(response) {
          self.content = response.data
          self.pageLimit = parseInt(response.headers['x-wp-totalpages'])
          console.log(self.content)
          console.log(self.pageLimit)
        })
    },
    incrementPage: function() {
      if (this.page === this.pageLimit && this.offset === 6) {
        this.page = 1
        this.offset = 0
      } else if (this.offset === 6) {
        this.offset = 0
        this.page += 1
      } else {
        this.offset += 1
      }
      this.getClients(this.page, this.offset)
    },
    decrementPage: function() {
      if (this.page === 1 && this.offset === 0) {
        this.page = this.pageLimit
      } else if (this.offset === 0) {
        this.page -= 1
        this.offset = 6
      } else {
        this.offset -= 1
      }
      this.getClients(this.page, this.offset)
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.clients {
  background-color: white;
}
.clients-header-cont {
  text-align: center;
  justify-content: center;
  .clients-header {
    color: $orange;
  }
}
.clients-button-col {
  display: flex;
  align-content: center;
  .clients-button {
    background-color: transparent;
    width: 0;
    height: 0;
    border-style: solid;
  }
  .clients-button-left {
    border-width: 100px 50px 100px 0;
    border-color: transparent $orange transparent transparent;
    &:hover {
      border-color: transparent $orange-dark transparent transparent;
    }
  }
  .clients-button-right {
    border-width: 100px 0 100px 50px;
    border-color: transparent transparent transparent $orange;
    &:hover {
      border-color: transparent transparent transparent $orange-dark;
    }
  }
}
</style>
