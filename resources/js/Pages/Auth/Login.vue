<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      remember: form.remember ? "on" : "",
    }))
    .post(route("login"), {
      onFinish: () => form.reset("password"),
    });
};
</script>

<template>
  <Head title="Log in" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"
    >
      {{ status }}
    </div>

    <h1 class=" pb-5 pt-2 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
      Faça login em sua conta
    </h1>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Seu email" />
        <TextInput
          id="email"
          v-model="form.email"
          type="email"
          class="mt-1 block w-full"
          required
          autofocus
          autocomplete="username"
          placeholder="test@test.com"
        />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-5">
        <InputLabel for="password" value="Password" />
        <TextInput
          id="password"
          v-model="form.password"
          type="password"
          class="mt-1 block w-full"
          required
          autocomplete="current-password"
          placeholder="*********"
        />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="flex items-center justify-between mt-5 ">
        <label class="flex items-center">
          <Checkbox v-model:checked="form.remember" name="remember" />
          <span class="ms-2 text-sm text-gray-600 dark:text-gray-400"
            >Remember me</span
          >
        </label>
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="hover:underline font-medium text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        > 
        Esqueceu sua senha?

        
        </Link>
      </div>
      <!-- <div class="block mt-4">
        <label class="flex items-center">
          <Checkbox v-model:checked="form.remember" name="remember" />
          <span class="ms-2 text-sm text-gray-600 dark:text-gray-400"
            >Remember me</span
          >
        </label>
      </div> -->

      <div class="block mb-3 mt-5">
        <PrimaryButton
          class="w-full pb-4 justify-center"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Log in
        </PrimaryButton>
      </div>
    </form>
  </AuthenticationCard>
</template>
