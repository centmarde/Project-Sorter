<template>
    <TopNav />

    <main>
        <div class="container">

            <div class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <router-link to="/"
                                             class="logo d-flex align-items-center w-auto">
                                    <img src="#"
                                         alt="">
                                    <span class="d-none d-lg-block">To work</span>
                                </router-link>
                            </div>

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <form class="row g-3"
                                          @submit.prevent="authStore.handleLogin(loginCredential)"
                                          novalidate>

                                        <div class="col-12">
                                            <label for="yourEmail"
                                                   class="form-label">
                                                Email
                                            </label>
                                            <input type="text"
                                                   v-model="loginCredential.email"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': authStore.errors[0] == 404 || authStore.errors.email }"
                                                   id="yourEmail"
                                                   required>
                                            <div v-if="authStore.errors.email"
                                                 class="invalid-feedback">
                                                {{ authStore.errors.email[0] }}
                                            </div>
                                            <div v-if="authStore.errors[0] == 404"
                                                 class="invalid-feedback">
                                                The email or password is incorrect!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword"
                                                   class="form-label">Password</label>
                                            <input type="password"
                                                   v-model="loginCredential.password"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': authStore.errors.password }"
                                                   id="yourPassword"
                                                   required>
                                            <div v-if="authStore.errors.password"
                                                 class="invalid-feedback">
                                                {{ authStore.errors.password[0] }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button v-if="!authStore.processing"
                                                    class="btn btn-primary w-100"
                                                    type="submit">
                                                Login
                                            </button>
                                            <button v-else
                                                    class="btn btn-primary w-100"
                                                    type="submit"
                                                    disabled>
                                                <span class="spinner-border spinner-border-sm"
                                                      role="status"
                                                      aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>
                                    </form>

                                    <div class="col-12 mt-3">
                                        <button @click="redirectToGoogle"
                                                class="btn btn-danger w-100">
                                            <i class="bi bi-google me-2"></i>
                                            Login with Google
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <p class="small mb-0">
                                            Don't have account?
                                            <router-link to="/register">
                                                Create an account
                                            </router-link>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>
</template>



<script setup>
import TopNav from './Includes/TopNav.vue';
import { ref } from 'vue';
import { useAuthStore } from '../../stores/auth';

const authStore = useAuthStore();

const loginCredential = ref({
    email: '',
    password: '',
});

// Redirect to Google authentication route
const redirectToGoogle = () => {
    window.location.href = '/auth/google/redirect'; // This route should be defined in your backend
};
</script>
