<template lang="pug">
  v-card(dark color="purple darken-3")
    v-btn(
      fab
      fixed
      right
      bottom
      color="purple"
      @click="goToForm"
      )
      v-icon add
    v-card-title
      strong Doações
    v-divider
    .grey.darken-3
      v-card-text
        table
          thead
            tr
              th(align="left")
                v-list-tile
                  v-list-tile-title Equipe
              th(align="center")
                v-list-tile
                  v-list-tile-title Kilos
          tbody
            tr(v-for="(item, index) in items" :key="index")
              td(width="100%")
                v-list-tile
                  v-list-tile-title {{ index + 1 }}&ordm; {{ item.name }}
              td(align="center")
                v-list-tile
                  v-list-tile-title.amber--text {{ item.kilos }}
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { DonationService } from '@/services/donation.service';
import { AxiosResponse } from 'axios';

@Component
export default class AdminComponent extends Vue {
  private items: any[] = [];

  private goToForm() {
    this.$router.push({
      name: 'donation-form',
    });
  }

  private getScore() {
    DonationService.getByTeam().then(({ data }: AxiosResponse) => {
      this.items = data.data;
    });
  }

  private created() {
    this.getScore();
  }
}
</script>
