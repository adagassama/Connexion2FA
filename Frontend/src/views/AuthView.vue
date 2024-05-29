<template>
  <FormRegisterLogin v-if="!loggedIn && !show2FA" @show-2fa="show2FAForm" />
  <Verify2FACode v-if="show2FA" :tempToken="tempToken" @verified="loginSuccess" />
</template>

<script setup>
import { ref } from 'vue';
import FormRegisterLogin from '@/components/FormRegisterLogin.vue';
import Verify2FACode from '@/components/Verify2FACode.vue';

const loggedIn = ref(false);
const show2FA = ref(false);
const tempToken = ref('');

const show2FAForm = (token) => {
    tempToken.value = token;
    show2FA.value = true;
};

const loginSuccess = () => {
    loggedIn.value = true;
    show2FA.value = false;
};
</script>

<style>
  
</style>
