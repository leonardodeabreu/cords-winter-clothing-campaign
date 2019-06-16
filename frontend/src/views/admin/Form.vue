<template lang="pug">
  v-form(@submit.prevent="submit")
    v-card(dark color="purple darken-3")
      v-btn(
        fab
        fixed
        right
        bottom
        color="purple"
        type="submit"
        )
        v-icon check
      v-layout(row align-center)
        v-btn.my-0(
          icon
          flat
          @click="goToList"
          )
          v-icon chevron_left
        v-card-title
          strong Cadastrar {{ title }}
      v-divider
      v-card-text.grey.darken-3
        v-alert(
          :value="errors.length > 0"
          type="error"
          )
          .title Ocorreram os seguintes erros:
          ul.mt-3
            li(v-for="(error, index) in errors" :key="index") {{ error }}
        component(:is="entity.formComponent" :DTO="DTO")
      v-card-actions.grey.darken-4(v-if="$route.params.id")
        v-btn(block flat color="error" @click="openDeleteModal") Excluir
      v-dialog(v-model="deleteModal")
        v-card
          v-card-title  Tem certeza que deseja excluir este registro?
          v-card-actions
            v-btn(block flat color="success" @click="deleteItem") Sim
            v-btn(block flat color="error" @click="closeDeleteModal") Não
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { UserService } from '@/services/user.service';
import { EntityFactory } from '@/entities/entity.factory';
import { PlayerEntity } from '@/entities/player.entity';
import { DonationEntity } from '@/entities/donation.entity';
import { AxiosResponse, AxiosError } from 'axios';
import { Location } from 'vue-router';

@Component
export default class AdminComponent extends Vue {
  private entityFactory: EntityFactory = new EntityFactory();
  private entity!: PlayerEntity | DonationEntity;
  private items: any[] = [];
  private page: number = 1;
  private errors: string[] = [];
  private deleteModal: boolean = false;
  private DTO: any = {};

  get title() {
    return this.entity ? this.entity.title : '';
  }

  get headers() {
    return this.entity ? this.entity.headers : [];
  }

  private goToList(query: any) {
    this.$router.push({
      query,
      name: this.$route.name && this.$route.name.replace('-form', '-list'),
    });
  }

  private openDeleteModal() {
    this.deleteModal = true;
  }

  private closeDeleteModal() {
    this.deleteModal = false;
  }

  private deleteItem() {
    const { id } = this.$route.params;
    this.entity.service.delete(id).then(() => {
      this.goToList({
        success: 'true',
      });
    });
  }

  private submit() {
    this.errors = [];
    this.entity.service.save(this.DTO)
      .then(() => {
        this.goToList({
          success: 'true',
        });
      })
      .catch((error: AxiosError) => {
        const resonse: any = error.response;
        if (resonse) {
          Object.keys(resonse.data.errors).forEach((key: string) => {
            if (!Array.isArray(resonse.data.errors[key])) {
              resonse.data.errors[key] = [resonse.data.errors[key]];
            }
            resonse.data.errors[key].forEach((item: string) => {
              this.errors.push(item);
            });
          });
        }
      });
  }

  private created() {
    this.entity = this.entityFactory.createEntity(this.$route.meta.type);
    const { id } = this.$route.params;
    if (id) {
      this.entity.service.getById(id).then(({ data }: AxiosResponse) => {
        this.DTO = data.data;
      });
    }
  }
}
</script>
