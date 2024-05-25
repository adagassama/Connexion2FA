<template>
  <FormRegisterLogin v-if="!loggedIn && !show2FA" @show-2fa="show2FAForm"/>
  <Verify2FACode v-if="show2FA" :tempToken="tempToken" @verified="loginSuccess"/>
</template>

<script >
import FormRegisterLogin from './components/FormRegisterLogin.vue';
import Verify2FACode from './components/Verify2FACode.vue';

export default {
  data () {
    return {
      loggedIn: false,
      show2FA: false,
      tempToken:'',
    };
  },
  components: {
    FormRegisterLogin,
    Verify2FACode
  },
  methods: {
    showLogin() {
      this.loggedIn = false;
      this.show2FA = false;
    },
    show2FAForm(tempToken) {
      this.tempToken = tempToken;
      this.show2FA = true;
    },
    loginSuccess() {
      this.loggedIn = true;
      this.show2FA = false;
    },
  }
}

</script>

<style scoped>

</style>
