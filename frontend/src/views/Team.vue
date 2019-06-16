<template lang="pug">
  .team-page
    transition(name="fade-transition" mode="out-in")
      .loading(v-if="loading")
        v-progress-circular(
          :size="270"
          :width="27"
          color="white"
          indeterminate
          )
      hero-component(:hero="hero" v-else)
</template>

<script lang="ts">
import { AxiosResponse } from 'axios';
import { Component, Vue, Prop } from 'vue-property-decorator';
import HeroComponent from '@/components/Hero.vue';
import { PlayerService } from '@/services/player.service';
import { TeamService } from '@/services/team.service';
import { HeroFactory } from '@/heroes/hero.factory';
import { Hero } from '@/heroes/hero.interface';

@Component({ components: { HeroComponent } })
export default class TeamComponent extends Vue {
  private heroFactory: HeroFactory = new HeroFactory();
  private hero!: Hero;
  private loading: boolean = true;
  private timer?: any = undefined;

  private created() {
    PlayerService
      .getById(this.$route.params.team)
      .then((response: AxiosResponse) => {
        const teamId: number = response.data.data.team.id;
        TeamService
          .getById(teamId)
          .then((responseTeam: AxiosResponse) => {
            this.loading = false;
            const { data } = responseTeam;
            this.hero = this.heroFactory.createHero(teamId, data.data.position, data.data.kilos);
            this.startTimer();
          });
      })
      .catch(() => {
        this.$router.push({ name: 'cords' });
      });
  }

  private startTimer(): void {
    if (this.timer) {
      clearTimeout(this.timer);
    }

    this.timer = setTimeout(() => {
      this.$router.push({ name: 'score' });
    }, 6000);
  }

  private beforeDestroy() {
    if (this.timer) {
      clearTimeout(this.timer);
    }
  }
}
</script>

<style lang="sass" scoped>
  .team-page
    position: fixed
    left: 0
    top: 0
    bottom: 0
    right: 0
    overflow: hidden
  .loading
    position: absolute
    left: 50%
    top: 50%
    transform: translate(-50%, -50%)
</style>
