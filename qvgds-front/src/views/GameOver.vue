<script setup lang="ts">
import PrimaryButton from "@/components/PrimaryButton.vue";
import Tag from "@/components/Tag.vue";
import { useRoute } from "vue-router";
import router from "@/router";

const route = useRoute();

const level = route.params.level;
const username = route.params.username;

const getGainsByLevel = (level: string) => {
  switch (level) {
    case "0":
      return "0";
    case "1":
      return "100";
    case "2":
      return "200";
    case "3":
      return "300";
    case "4":
      return "500";
    case "5":
      return "1 000";
    case "6":
      return "2 000";
    case "7":
      return "4 000";
    case "8":
      return "8 000";
    case "9":
      return "12 000";
    case "10":
      return "24 000";
    case "11":
      return "36 000";
    case "12":
      return "72 000";
    case "13":
      return "150 000";
    case "14":
      return "300 000";
    case "15":
      return "1 000 000";
  }
};
</script>

<template>
  <main
    class="flex h-full min-h-screen w-full flex-col items-center justify-center bg-confettis bg-auto bg-top px-10 text-white"
  >
    <img src="/moneybag.png" class="relative z-10 -mb-5" alt="Money bag" />
    <Tag
      :label="(username as string)"
      class="min-w-[150px] -rotate-2 text-2xl"
    />

    <p class="line mt-40 text-[160px] font-bold leading-none">
      {{ getGainsByLevel(level as string) }}
    </p>

    <img src="/text-shitcoins.png" alt="Shitcoins" class="mb-40" />

    <PrimaryButton @click="() => router.push({ name: 'home' })"
      >Nouvelle Partie</PrimaryButton
    >
  </main>
</template>
