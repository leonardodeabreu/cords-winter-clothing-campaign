<template lang="pug">
  .team.team--capitao-america(v-show="hero")
    img(:src="hero.background" width="100%")
    .team__wrapper
      v-layout(row align-center)
        v-flex(xs4) &nbsp;
        v-flex.team__info(xs8)
          v-layout(column)
            .info__posicao(:class="hero.colors.secondary" v-show="hero.position > 0")
              | {{ hero.position }}&ordm; Lugar
            .info__name(:class="hero.colors.primary") {{ hero.name }}
            .info__score(:class="hero.colors.secondary" v-show="hero.score > 0")
              | {{ hero.score }}
              small KGs
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { Hero } from '@/heroes/hero.interface';

@Component
export default class HeroComponent extends Vue {
  @Prop({ type: Object })
  private hero?: Hero;
}
</script>

<style lang="sass" scoped>
  .team
    height: 100vh
    position: relative
    &__wrapper
      position: absolute
      left: 20px
      right: 20px
      bottom: 20px
    &__info
      .info
        &__name,
        &__score,
        &__posicao
          color: #fff
          background: #212121
          text-transform: uppercase
          font-weight: bold
          padding: 16px
          text-shadow: 1px 1px 0 rgba(0,0,0,.25)
        &__posicao
          font-size: 22px
          position: relative
          margin-right: auto
          display: inline-block
          &:after
            content: ''
            width: 0
            height: 0
            border-style: solid
            border-width: 70px 0 0 70px
            border-color: transparent transparent transparent rgba(0,0,0,.5)
            position: absolute
            right: 0
            top: 0
            transform: translateX(100%)
        &__score
          margin-left: auto
          display: inline-block
          font-size: 42px
          position: relative
          &:before
            content: ''
            width: 0
            height: 0
            border-style: solid
            border-width: 0 100px 100px 0
            border-color: transparent rgba(0,0,0,.5) transparent transparent
            position: absolute
            left: 0
            bottom: 0
            transform: translateX(-100%)
        &__name
          font-size: 62px
          position: relative
          z-index: 3
          background: red
</style>
