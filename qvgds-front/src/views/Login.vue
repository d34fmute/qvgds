<script setup lang="ts">
import { reactive } from "vue";
import { useQueryClient, useQuery } from "@tanstack/vue-query";
import PrimaryButton from "@/components/PrimaryButton.vue";
import Input from "@/components/Input.vue";
import Dropdown from "@/components/Dropdown.vue";
import type { DropdownOption } from "@/components/Dropdown.vue";
import { getSessions } from "@/airtable/sessions";
import { computed } from "@vue/reactivity";
import router from "@/router";

const {
  isLoading,
  isError,
  data: sessions,
  error
} = useQuery({
  queryKey: ["sessions"],
  queryFn: getSessions
});

const options = computed(() =>
  sessions.value?.map((session) => {
    if (session.fields.status === "Done") {
      return {
        value: session.fields.id,
        label: session.fields.name
      } as DropdownOption;
    }
  })
);

const form = reactive({
  session: "",
  username: ""
});

const handleSubmit = (e) => {
  e.preventDefault();
  console.log("SESSION", form);
  router.push({
    name: "game",
    params: { sessionId: form.session, username: form.username }
  });
};

const isStartDisabled = computed(() => {
  return form.session === "" || form.username === "";
});
</script>

<template>
  <main
    class="flex h-full min-h-screen w-full flex-col justify-center bg-emojis bg-auto bg-top px-10 text-white"
  >
    <img src="/logo-with-shit.png" alt="Logo shitcoin" class="mx-auto" />
    <form class="mt-10 mt-20 flex flex-col items-center" @submit="handleSubmit">
      <label for="section" class="mb-6 text-2xl font-bold opacity-70"
        >SESSION</label
      >
      <Dropdown
        id="section"
        class="mb-12"
        :options="options"
        v-model="form.session"
        :isLoading="isLoading"
      />
      <label for="username" class="mb-6 text-2xl font-bold opacity-70"
        >TON BLAZE</label
      >
      <Input
        id="username"
        class="mb-20 h-[88px] w-[600px] rounded-[30px] px-10 text-[28px] uppercase"
        placeholder="ex: silvere ze dev"
        v-model="form.username"
      />

      <PrimaryButton
        class="text-2xl"
        type="submit"
        :isLoading="isLoading"
        :disabled="isStartDisabled"
        >DÉMARRER</PrimaryButton
      >
    </form>
  </main>
</template>
