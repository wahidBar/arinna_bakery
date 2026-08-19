<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasskeyVerify from '@/components/PasskeyVerify.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: false,
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <Head title="Login — Arinna Bakery" />

    <div class="login-page">
        <!-- Sisi Kiri: Branding -->
        <div class="login-left">
            <div class="login-left-overlay" />
            <div class="login-left-content">
                <Link href="/" class="login-brand">
                    <img
                        src="/assets/img/logo/logo.png"
                        alt="Arinna Bakery"
                        class="login-logo"
                    />
                </Link>
                <div class="login-tagline">
                    <h2 class="login-tagline-title">Selamat Datang Kembali</h2>
                    <p class="login-tagline-desc">
                        Kelola toko roti Anda dengan mudah dan profesional
                        bersama Arinna Bakery.
                    </p>
                </div>
                <div class="login-badges">
                    <span class="login-badge">🥐 Fresh Daily</span>
                    <span class="login-badge">🎂 Premium Quality</span>
                    <span class="login-badge">🛍️ Fast Delivery</span>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="login-right">
            <div class="login-form-wrapper">
                <!-- Mobile logo -->
                <div class="login-mobile-logo">
                    <a href="/">
                        <img
                            src="/assets/img/logo/logo.png"
                            alt="Arinna Bakery"
                            class="login-logo-mobile"
                        />
                    </a>
                </div>

                <div class="login-form-header">
                    <h1 class="login-form-title">Selamat Datang</h1>
                    <p class="login-form-subtitle">
                        Masukkan kredensial Anda untuk mengakses dashboard
                    </p>
                </div>

                <div v-if="status" class="login-status-msg">
                    {{ status }}
                </div>

                <PasskeyVerify />

                <Form
                    v-bind="store.form()"
                    :reset-on-success="['password']"
                    v-slot="{ errors, processing }"
                    class="login-form"
                >
                    <!-- Email -->
                    <div class="form-group">
                        <Label for="email" class="form-label">Alamat Email</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            placeholder="nama@contoh.com"
                            class="form-input"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="form-label-row">
                            <Label for="password" class="form-label">Password</Label>
                            <Link
                                v-if="canResetPassword"
                                :href="request()"
                                class="forgot-link"
                                :tabindex="5"
                            >
                                Lupa password?
                            </Link>
                        </div>
                        <PasswordInput
                            id="password"
                            name="password"
                            required
                            :tabindex="2"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="form-input"
                        />
                        <InputError :message="errors.password" />
                    </div>

                    <!-- Remember me -->
                    <div class="form-remember">
                        <Label for="remember" class="remember-label">
                            <Checkbox
                                id="remember"
                                name="remember"
                                :tabindex="3"
                            />
                            <span>Ingat saya selama 30 hari</span>
                        </Label>
                    </div>

                    <!-- Submit -->
                    <Button
                        type="submit"
                        class="login-btn"
                        :tabindex="4"
                        :disabled="processing"
                        data-test="login-button"
                    >
                        <Spinner v-if="processing" class="btn-spinner" />
                        <span>{{
                            processing ? 'Memproses...' : 'Masuk Sekarang'
                        }}</span>
                    </Button>
                </Form>

                <div class="login-register-link">
                    Belum punya akun?
                    <Link :href="register()" :tabindex="6" class="register-link"
                        >Daftar sekarang</Link
                    >
                </div>

                <div class="login-footer">
                    <!-- Gunakan <a> biasa bukan <Link> Inertia karena home adalah Blade view -->
                    <a href="/" class="back-to-store"> ← Kembali ke Toko </a>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* ===================== FONTS ===================== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

/* ===================== LAYOUT ===================== */
.login-page {
    display: flex;
    min-height: 100dvh;
    font-family: 'Poppins', 'Inter', sans-serif;
    background: #f0f2ff;
}

/* ===================== LEFT PANEL ===================== */
.login-left {
    position: relative;
    display: none;
    flex: 1;
    background: url('/assets/img/category/ban-cat.png') center/cover no-repeat;
    overflow: hidden;
}

@media (min-width: 1024px) {
    .login-left {
        display: flex;
        align-items: stretch;
    }
}

.login-left-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(45, 52, 128, 0.95) 0%,
        rgba(45, 52, 128, 0.82) 50%,
        rgba(28, 32, 85, 0.95) 100%
    );
    z-index: 1;
}

.login-left-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 3rem 3.5rem;
    width: 100%;
}

.login-brand {
    display: inline-block;
}

.login-logo {
    height: 52px;
    object-fit: contain;
}

.login-tagline {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 3rem 0;
}

.login-tagline-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 1rem;
}

.login-tagline-desc {
    font-size: 1.05rem;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.7;
    max-width: 360px;
}

.login-badges {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
}

.login-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #fff;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    width: fit-content;
}

/* ===================== RIGHT PANEL ===================== */
.login-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f6ff;
    padding: 2rem 1.5rem;
    min-height: 100dvh;
}

.login-form-wrapper {
    width: 100%;
    max-width: 420px;
}

/* Mobile logo */
.login-mobile-logo {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

@media (min-width: 1024px) {
    .login-mobile-logo {
        display: none;
    }
}

.login-logo-mobile {
    height: 44px;
    object-fit: contain;
}

/* Form header */
.login-form-header {
    margin-bottom: 2rem;
}

.login-form-title {
    font-size: 1.85rem;
    font-weight: 700;
    color: #1e2560;
    margin-bottom: 0.4rem;
    line-height: 1.2;
}

.login-form-subtitle {
    font-size: 0.9rem;
    color: #7880b0;
    line-height: 1.5;
}

/* Status */
.login-status-msg {
    margin-bottom: 1rem;
    padding: 0.75rem 1rem;
    background: #eef9f0;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    color: #15803d;
    font-size: 0.875rem;
    text-align: center;
}

/* ===================== FORM ===================== */
.login-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #2d3480;
}

.form-label-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.forgot-link {
    font-size: 0.8rem;
    color: #6c7fd8;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.2s;
}

.forgot-link:hover {
    color: #4a5ed4;
    text-decoration: underline;
}

/* Input styling */
.form-input {
    border-color: #c8cef0 !important;
    background: #fff !important;
    color: #1e2560 !important;
    transition: border-color 0.2s, box-shadow 0.2s !important;
}

.form-input:focus,
.form-input:focus-within {
    border-color: #6c7fd8 !important;
    box-shadow: 0 0 0 3px rgba(108, 127, 216, 0.15) !important;
    outline: none !important;
}

/* Remember me */
.form-remember {
    margin-top: -0.25rem;
}

.remember-label {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: #5a6490;
    font-weight: 400;
}

/* Submit button */
.login-btn {
    width: 100%;
    height: 3rem;
    font-size: 0.975rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    background: linear-gradient(135deg, #6c7fd8 0%, #4a5ed4 100%);
    border: none;
    border-radius: 10px;
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
    transition: all 0.25s ease;
    box-shadow: 0 4px 16px rgba(108, 127, 216, 0.4);
}

.login-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, #5a6ec6 0%, #3d4fc0 100%);
    box-shadow: 0 6px 22px rgba(108, 127, 216, 0.55);
    transform: translateY(-1px);
}

.login-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.btn-spinner {
    width: 18px;
    height: 18px;
}

/* Register link */
.login-register-link {
    text-align: center;
    margin-top: 1.5rem;
    font-size: 0.875rem;
    color: #7880b0;
}

.register-link {
    color: #6c7fd8;
    font-weight: 600;
    text-decoration: none;
    margin-left: 0.25rem;
    transition: color 0.2s;
}

.register-link:hover {
    color: #4a5ed4;
    text-decoration: underline;
}

/* Footer */
.login-footer {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #dde2f8;
}

.back-to-store {
    font-size: 0.825rem;
    color: #8b95cc;
    text-decoration: none;
    transition: color 0.2s;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.back-to-store:hover {
    color: #6c7fd8;
}
</style>
