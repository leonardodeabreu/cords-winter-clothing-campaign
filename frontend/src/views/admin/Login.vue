<template lang="pug">
  v-container(fluid fill-height)
    v-layout(row align-center justify-center)
      v-snackbar(
        v-model="snackbar"
        bottom
        )
        | E-mail e/ou senha inválidos
        v-btn(
          flat
          icon
          color="pink"
          @click="closeSnackBar"
          )
          v-icon close
      v-form(@submit.prevent="submit")
        v-card
          v-card-title Acesso restrito
          v-divider
          v-card-text
            v-text-field(
              label="E-mail"
              v-model="loginDTO.email"
              )
            v-text-field(
              label="Senha"
              type="password"
              v-model="loginDTO.password"
              )
          v-divider
          v-card-actions
            v-btn(flat type="submit" block color="success") Acessar
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { AxiosResponse } from 'axios';
import { LoginService } from '@/services/login.service';
import { LoginDTO } from './LoginDTO';

@Component
export default class LoginComponent extends Vue {
  private snackbar: boolean = false;

  private loginDTO: LoginDTO = {
    email: '',
    password: '',
  };

  private closeSnackBar() {
    this.snackbar = false;
  }

  private submit() {
    LoginService.auth(this.loginDTO)
      .then(({ data }: AxiosResponse) => {
        const token: string = data.data.access_token;
        if (token) {
          localStorage.setItem('cords-token', token);
        }
        this.$router.push('/admin');
      })
      .catch(() => {
        this.snackbar = true;
      });
  }
}
</script>
