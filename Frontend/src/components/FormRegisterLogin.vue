<template>
<div class="container" :class="{'register-mode': isSingUpMode }">
    <div class="forms-container">
        <div class="login-register">
            <form class="login-form" @submit.prevent="handleLogin">
                <h2 class="title">Connexion</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input v-model="emailLogin" type="text" placeholder="Email"  required/>
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
                    <input v-model="name" type="text" placeholder="Nom Utilisateur" required/>
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
    <ModalForm v-if="showModal" :qrCodeUrl="qrCodeUrl" :tempToken="tempToken" @close="showModal = false" />
</div>
</template>

<script>
import axios from 'axios';
import ModalForm from './ModalForm.vue';

export default {
    components: {
       ModalForm
    },
    data() {
        return {
            name: '',
            email: '',
            password: '',
            emailLogin: '',
            passwordLogin: '',
            isSingUpMode: false,
            showModal: false,
            qrCodeUrl: '',
            tempToken: '',
        }
    },
    methods: {
        async handleRegister() {
            try {
                await axios.post('http://127.0.0.1:8000/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                });
                alert('Register successful. Please login !');
                this.resetRegisterFields()
            } catch (error) {
                console.error(error);
            }
        },
        async handleLogin() {
            try {
                   const response = await axios.post('http://127.0.0.1:8000/api/login', {
                    email: this.emailLogin,
                    password: this.passwordLogin,
                });
                if ( response.data.two_factor_required ) {
                   //this.qrCodeUrl = response.data.qrCodeUrl;
                   //this.tempToken = response.data.temp_token;
                   //this.showModal = true;
                    this.$emit('show-2fa', response.data.temp_token);
                    
                } else {
                    alert(' Login successful ');
                    this.resetLoginFields();
                }
            } catch (error) {
                console.error(error);
            }
        },
        toggleSignUpMode() {
            this.isSingUpMode = true
        },
        toggleSignInMode() {
            this.isSingUpMode = false
        },
        resetLoginFields(){
            this.emailLogin = "";
            this.passwordLogin = "";
        },
        resetRegisterFields(){
            this.name ="";
            this.email = "";
            this.password = "";
        },
    },
}
</script>

<style>
 @import '../assets/form.css';
</style>
