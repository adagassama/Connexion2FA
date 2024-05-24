<template>
<div class="container" :class="{'register-mode': isSingUpMode }">
    <div class="forms-container">
        <div class="register-login">
            <form class="login-form">
                <h2 class="tittle">Connexion</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Email" />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" />
                </div>
                <input type="submit" value="Connexion" class="btn solid" />
            </form>

            <form class="sign-up-form" @submit.prevent="register">
                <h2 class="tittle">Inscription</h2>
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
</div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            isSingUpMode: false,
        }
    },
    methods: {
        async register() {
            try {
                await axios.post('http://127.0.0.1:8000/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                });
                alert('Register successful. Please login !');
            } catch (error) {
                console.error(error);
            }
        },
        toggleSignUpMode() {
            this.isSingUpMode = true
        },
        toggleSignInMode() {
            this.isSingUpMode = false
        }
    }
}
</script>

<style>
/* @import '../assets/form.css'; */
</style>
