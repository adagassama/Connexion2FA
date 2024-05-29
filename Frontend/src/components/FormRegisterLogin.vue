<template>
    <div class="container" :class="{'register-mode': isSignUpMode }">
        <div class="forms-container">
            <div class="login-register">
                <form class="login-form" @submit.prevent="handleLogin">
                    <h2 class="title">Connexion</h2>
                    <div class="input-field">
                        <i class="fa fa-user"></i>
                        <input v-model="emailLogin" type="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input v-model="passwordLogin" type="password" placeholder="Password" required />
                    </div>
                    <input type="submit" value="Connexion" class="btn solid" />
                </form>

                <form class="register-form" @submit.prevent="handleRegister">
                    <h2 class="title">Inscription</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input v-model="name" type="text" placeholder="Nom Utilisateur" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input v-model="email" type="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input v-model="password" type="password" placeholder="Password" required />
                    </div>
                    <input type="submit" value="Inscription" class="btn" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Nouvel Utilisateur ?</h3>
                    <p>Veuillez cliquer ci-dessous pour vous inscrire !</p>
                    <button class="btn transparent" @click="toggleSignUpMode">S'enregistrer</button>
                </div>
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Déjà membre ?</h3>
                    <p>Veuillez cliquer ci-dessous pour vous connecter !</p>
                    <button class="btn transparent" @click="toggleSignInMode">Connexion</button>
                </div>
            </div>
        </div>

        <div>
            <span></span>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { registerUserApi, loginUserApi } from '@/services/apiService';

const name = ref('');
const email = ref('');
const password = ref('');
const emailLogin = ref('');
const passwordLogin = ref('');
const isSignUpMode = ref(false);
const emit = defineEmits(['show-2fa']);

const handleRegister = async () => {
    try {
        await registerUserApi({
            name: name.value,
            email: email.value,
            password: password.value,
        });
        resetRegisterFields()
    } catch (error) {
        resetRegisterFields()
    }
};

const handleLogin = async () => {
    try {
        const data = await loginUserApi({
            email: emailLogin.value,
            password: passwordLogin.value,
        });
        if (data.two_factor_required) {
            emit('show-2fa', data.temp_token);
        } else {
            resetLoginFields();
        }
        resetLoginFields();
    } catch (error) {
        resetLoginFields();
    }
};

const toggleSignUpMode = () => {
    isSignUpMode.value = true;
};
const toggleSignInMode = () => {
    isSignUpMode.value = false;
};
const resetLoginFields = () => {
    emailLogin.value = "";
    passwordLogin.value = "";
};
const resetRegisterFields = () => {
    name.value = "";
    email.value = "";
    password.value = "";
};

</script>

<style>
@import '../styles/styles.css';
</style>
