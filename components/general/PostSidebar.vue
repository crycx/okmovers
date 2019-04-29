<template>
  <ul v-if="dataIsLoaded" class="slug-side-menu-ul">
    <li v-for="item in content" :key="item.id" class="slug-side-menu-item">
      <nuxt-link :to="parentPage + '/' + item.object_slug">
        {{ item.title.toUpperCase() }}
      </nuxt-link>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    menuId: {
      type: Number,
      default: null
    },
    parentPage: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      content: [],
      dataIsLoaded: false
    }
  },
  mounted: function() {
    this.getSidebarItems()
  },
  methods: {
    getSidebarItems: function() {
      const self = this

      this.$axios
        .get(
          'http://playground.ermine.ee/okmovers-api/wp-json/wp-api-menus/v2/menus/' +
            this.menuId
        )
        .then(function(response) {
          self.content = response.data.items
          self.dataIsLoaded = true
          self.setActive()
        })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.slug-side-menu-ul {
  padding-top: 25px;
  padding-bottom: 25px;
}
.slug-side-menu-item {
  font-size: 12px;
  list-style-type: square;
  a {
    color: white;
    .nuxt-link-active {
      color: $orange;
    }
    &:hover {
      text-decoration-line: none;
      color: $orange-dark;
    }
    &:active {
      color: $orange;
    }
  }
}
</style>
