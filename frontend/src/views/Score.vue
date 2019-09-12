<template lang="pug">
  .score
    img(:src="boss.background" width="100%")
</template>

<script lang="ts">
import { AxiosResponse } from 'axios';
import { Component, Vue } from 'vue-property-decorator';
import { TeamService } from '@/services/team.service';
import { DonationService } from '@/services/donation.service';
import { Hero } from '@/heroes/hero.interface';
import { HeroFactory } from '@/heroes/hero.factory';
import { BossFactory } from '@/boss/boss.factory';
import { Boss } from '@/boss/boss.interface';

@Component
export default class TeamComponent extends Vue {
  private timer: any = undefined;
  private teams: any[] = [];
  private heroes: Hero[] = [];
  private kilos: number = 0;
  private heroFactory: HeroFactory = new HeroFactory();
  private bossFactory: BossFactory = new BossFactory();
  private boss?: any = {};

  get lifePercentage(): number {
    if (!this.boss) {
      return 100;
    }

    const done: number = this.kilos - this.boss.lifeFactor;
    return 100 - (done * 100 / (this.boss.life || 5000));
  }

  private getTeams() {
    const teams: string | null = localStorage.getItem('cords-teams');
    if (teams) {
      this.teams = JSON.parse(teams);
      this.createHeroes();
      return;
    }
    TeamService.list().then(({ data }: AxiosResponse) => {
      this.teams = data.data;
      this.createHeroes();
      localStorage.setItem('cords-teams', JSON.stringify(this.teams));
    });
  }

  private createHeroes() {
    if (this.teams.length === 0) {
      return;
    }
    this.teams.forEach((team: any) => {
      this.heroes.push(this.heroFactory.createHero(team.id, 0, 0));
    });
  }

  private getAllScore() {
    DonationService.getAllKilos().then(({ data }: AxiosResponse) => {
      const { kilos } = data.data;
      this.kilos = Math.round(kilos) || 0;
      this.createBoss();
    });
  }

  private createBoss() {
    this.boss = this.bossFactory.createBossByScore(this.kilos);
  }

  private startTimer(): void {
    if (this.timer) {
      clearTimeout(this.timer);
    }

    this.timer = setTimeout(() => {
      this.$router.push({ name: 'home'});
    }, 1000 * 60 * 5);
  }

  private beforeDestroy() {
    if (this.timer) {
      clearTimeout(this.timer);
    }
  }

  private created() {
    this.getTeams();
    this.getAllScore();
  }

  private mounted() {
    this.startTimer();
  }
}
</script>

<style lang="sass" scoped>
  .score
    position: fixed
    left: 0
    top: 0
    bottom: 0
    right: 0
    overflow: hidden
  .ranking-score
    width: 100%
    height: 30px
    &__score
      position: absolute
      left: 50%
      bottom: 0
      transform: translateX(-50%)
      color: #fff
      min-width: 90px
      padding: 8px
      font-size: 22px
      text-align: center
      border-radius: 4px
      text-shadow: 1px 1px 0 rgba(0,0,0,.4)
      z-index: 1
    &__position
      z-index: 2
      position: absolute
      left: 50%
      bottom: 40px
      transform: translateX(-50%)
      font-size: 32px
      color: #fff
      text-shadow: 1px 1px 0 rgba(0,0,0,.4)
      width: 48px
      height: 48px
      border-radius: 50%
      text-align: center
  .boss
    position: absolute
    left: 50%
    top: 62px
    transform: translate(-50%, 0)
    &--loki
      margin-left: -50px
    img
      animation: 3s infinite linear dancing
  .life
    position: absolute
    left: 50%
    top: 32px
    width: 220px
    border-radius: 5px
    background: linear-gradient(to bottom, #302d2a, #5c4734)
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(0, 0, 0, 0.08)
    transform: translateX(-50%)
    border: solid 3px #dbaf88
    padding: 1px
    &__done
      display: block
      height: 25px
      border-radius: 2px
      background: #86e01e linear-gradient(to bottom, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05))
      box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0.25), inset 0 1px rgba(255, 255, 255, 0.1)
    &__text
      position: absolute
      left: 50%
      top: 50%
      font-size: 18px
      line-height: 18px
      color: #fff
      text-shadow: 1px 1px 0 rgba(0,0,0,.25)
      transform: translate(-50%, -50%)
    &__name
      position: absolute
      left: 48px
      right: 48px
      top: -3px
      color: #fff
      text-shadow: 1px 1px 0 rgba(0,0,0,.25)
      transform: translateY(-100%)
      background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.5))
      text-align: center
      text-transform: uppercase
      font-size: 12px
      padding: 2px 0
      &:before,
      &:after
        content: ' '
        position: absolute
        bottom: 0
        width: 0
        height: 0
        border-style: solid
      &:before
        border-width: 0 0 16px 16px
        border-color: transparent transparent #dbaf88 transparent
        left: 0
        transform: translateX(-100%)
      &:after
        border-width: 16px 0 0 16px
        border-color: transparent transparent transparent #dbaf88
        right: 0
        transform: translateX(100%)
  .ranking
    position: fixed
    left: 0
    right: 0
    bottom: -2px
    height: 50vh
    z-index: 2
    background: linear-gradient(transparent, #000)
    &__characters-wrapper
      position: absolute
      left: 0
      right: 0
      bottom: 16px
    &__character
      position: relative
      margin-tiop: 0
      &:nth-child(2),
      &:nth-child(5)
        margin-top: 50px
      &:nth-child(3),
      &:nth-child(4)
        margin-top: 100px
  @keyframes dancing
    0%
      margin-top: 0
    50%
      margin-top: 20px
    100%
      margin-top: 0
</style>
