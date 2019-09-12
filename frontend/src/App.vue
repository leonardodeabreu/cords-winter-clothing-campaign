<template lang="pug">
  v-app.app.grey.darken-4
    rfid(v-if="!isAdmin")
    .cords-copy-right(v-if="!isAdmin")
    .cords-campanha(v-if="!isAdmin")
    transition(name="fade-transition" mode="out-in")
      router-view(:key="$route.name + ($route.params.team || 'jairo')")
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Rfid from '@/components/Rfid.vue';

@Component({ components: { Rfid } })
export default class TeamComponent extends Vue {
  get isAdmin(): boolean {
    return window.location.href.includes('admin')
      || this.$route.name === 'login'
      || this.$route.name === 'home';
  }
}
</script>

<style lang="sass">
  html
    overflow: auto
  .app
    position: fixed
    left: 0
    top: 0
    right: 0
    bottom: 0
    overflow: auto
  .cords-campanha
    position: fixed
    left: 0
    top: 0
    z-index: 100

</style>
