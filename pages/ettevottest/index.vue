<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="container">
            <div class="heading-container">
              <h1 class="post-title">
                Ettevõttest
              </h1>
            </div>
            <content-renderer :id="34" :type="'page'" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ContentRenderer from '@/components/general/ContentRenderer.vue'
export default {
  components: {
    ContentRenderer
  },
  mounted: function() {}
}
</script>

<style lang="scss">
</style>
