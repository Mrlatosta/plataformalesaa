<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <label for="email">Email</label>
            <input type="text" name="email" v-model="form.email">
            <label for="password">Password</label>
            <input type="password" name="password" v-model="form.password">
            <br>
            <!-- Show errors only if they exist -->
            <p v-if="errors.length > 0" style="color:red" v-for="(err, k) in errors" :key="k">{{ err }}</p>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</template>

<script>
import { router } from '@inertiajs/vue3';
import axios from 'axios'; // Ensure axios is imported

export default {
    data: () => ({
        form: {
            email: '',
            password: '',
        },
        errors: [],
    }),
    methods: {
        login() {
            this.errors = []; // Reset errors
            // Basic client-side validation
            if (!this.form.email || !this.form.password) {
                this.errors = ["Both fields are required."];
                return;
            }

            axios
                .post('login', {
                    email: this.form.email,
                    password: this.form.password,
                })
                .then(() => {
                    router.get('inicio'); // Redirect to 'inicio' on success
                })
                .catch((err) => {
                    if (err.response && err.response.status) {
                        const status = err.response.status;

                        if (status === 422) {
                            const serverErrors = err.response.data.errors;
                            this.errors = Object.values(serverErrors).flat();
                        } else {
                            this.errors = ["Server error: " + status];
                        }
                    } else {
                        this.errors = ["Unexpected error occurred."];
                    }
                });
        },
    },
};
</script>
