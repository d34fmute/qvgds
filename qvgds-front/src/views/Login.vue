<script setup lang="ts">
import PrimaryButton from "@/components/PrimaryButton.vue";
import Input from "@/components/Input.vue";
import Dropdown from "@/components/Dropdown.vue";
import type { DropdownOption } from "@/components/Dropdown.vue";

const options: DropdownOption[] = [
  { value: "session1", label: "Session 1" },
  { value: "session2", label: "Session 2" },
  { value: "session3", label: "Session 3" }
];
</script>

<template>
  <main
    class="flex h-full min-h-screen w-full flex-col justify-center bg-emojis bg-auto bg-top px-10 text-white"
  >
    <img src="/logo-with-shit.png" alt="Logo shitcoin" class="mx-auto" />
    <form class="mt-10 mt-20 flex flex-col items-center" action="">
      <label for="section" class="mb-6 text-2xl font-bold opacity-70"
        >SESSION</label
      >
      <Dropdown id="section" class="mb-12" :options="options" />
      <label for="username" class="mb-6 text-2xl font-bold opacity-70"
        >TON BLAZE</label
      >
      <Input
        id="username"
        class="mb-20 h-[88px] w-[600px] rounded-[30px] px-10 text-[28px]"
        placeholder="ex: silvere ze dev"
      />

      <PrimaryButton class="text-2xl">DÉMARRER</PrimaryButton>
    </form>
  </main>
</template>
