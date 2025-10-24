<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <div class="relative flex min-h-svh flex-col items-center justify-center p-6 md:p-10">
        <Head title="Log in" />

        <div class="absolute inset-0 -z-10">
            <img
                src="https://images.unsplash.com/photo-1557683316-973673baf926?w=1920&auto=format&fit=crop&q=80"
                alt="Background"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
        </div>

        <div class="w-full max-w-sm md:max-w-3xl">
            <div class="flex flex-col gap-6">
                <Card class="overflow-hidden shadow-2xl py-0">
                    <CardContent class="grid p-0 md:grid-cols-2">
                        <div class="relative hidden bg-muted md:block">
                            <img
                                src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=800&auto=format&fit=crop&q=60"
                                alt="Login"
                                class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
                            >
                        </div>

                        <Form
                            v-bind="store.form()"
                            :reset-on-success="['password']"
                            v-slot="{ errors, processing }"
                            class="p-6 md:p-8"
                        >
                            <div class="flex flex-col gap-6">
                                <div class="flex flex-col items-center text-center">
                                    <h1 class="text-2xl font-bold">Welcome back</h1>
                                    <p class="text-balance text-muted-foreground">
                                        Login to your account
                                    </p>
                                </div>

                                <div
                                    v-if="status"
                                    class="text-center text-sm font-medium text-green-600"
                                >
                                    {{ status }}
                                </div>

                                <div class="grid gap-2">
                                    <Label for="email">Email</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        name="email"
                                        placeholder="m@example.com"
                                        required
                                        autofocus
                                        autocomplete="email"
                                    />
                                    <InputError :message="errors.email" />
                                </div>

                                <div class="grid gap-2">
                                    <div class="flex items-center">
                                        <Label for="password">Password</Label>
                                        <a
                                            v-if="canResetPassword"
                                            :href="request()"
                                            class="ml-auto text-sm underline-offset-2 hover:underline"
                                        >
                                            Forgot your password?
                                        </a>
                                    </div>
                                    <Input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                    />
                                    <InputError :message="errors.password" />
                                </div>

                                <div class="flex items-center">
                                    <Label for="remember" class="flex items-center gap-2">
                                        <Checkbox id="remember" name="remember" />
                                        <span class="text-sm">Remember me</span>
                                    </Label>
                                </div>

                                <Button
                                    type="submit"
                                    class="w-full"
                                    :disabled="processing"
                                    data-test="login-button"
                                >
                                    <LoaderCircle
                                        v-if="processing"
                                        class="h-4 w-4 animate-spin"
                                    />
                                    <span v-else>Login</span>
                                </Button>
                            </div>
                        </Form>
                    </CardContent>
                </Card>

                <div class="text-balance text-center text-xs text-white/90 [&_a]:underline [&_a]:underline-offset-4 hover:[&_a]:text-white">
                    By clicking continue, you agree to our <a href="#">Terms of Service</a>
                    and <a href="#">Privacy Policy</a>.
                </div>
            </div>
        </div>
    </div>
</template>

<style>
body {
    background-color: transparent !important;
}
</style>
