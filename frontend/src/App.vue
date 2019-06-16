<template lang="pug">
  v-app.app.grey.darken-4
    rfid(v-if="!isAdmin")
    .cords-copy-right(v-if="!isAdmin")
      img(src="/img/logo_cords.png" height="48")
    .cords-campanha(v-if="!isAdmin")
      img(src="/img/logo_campanha.png" height="120")
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
  .cords-copy-right
    position: fixed
    left: 0
    bottom: 0
    z-index: 100
    &:after
      content: ' '
      position: fixed
      left: 0
      bottom: 0
      width: 0
      height: 0
      border-style: solid
      border-width: 60px 0 0 60px
      border-color: transparent transparent transparent #811f1d
    & > img
      position: absolute
      z-index: 2
      bottom: 5px
      left: 5px
</style>
