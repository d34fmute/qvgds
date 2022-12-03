<script setup lang="ts">
import PrimaryButton from "@/components/PrimaryButton.vue";
import ChoiceButton from "@/components/ChoiceButton.vue";
</script>

<template>
  <main class="h-screen w-full bg-dark px-10 text-white">
    <h1 class="text-3xl font-bold">QUI VEUT GAGNER DES SHITCOINS ?</h1>
    <section class="flex flex-col items-center gap-4">
      <h2 class="text-lg">Réponse</h2>
      <img src="/emojis/poop_emoji.svg" class="h-20 w-20" />
      <PrimaryButton>D&eacute;MARRER</PrimaryButton>
      <PrimaryButton isLoading>DÉMARRER</PrimaryButton>
      <PrimaryButton disabled>DÉMARRER</PrimaryButton>
      <div class="grid w-full grid-cols-2 gap-4">
        <ChoiceButton option="A" label="1994" />
        <ChoiceButton option="B" label="1994" variant="selected" />
        <ChoiceButton option="D" label="1994" variant="valid" />
        <ChoiceButton option="C" label="1994" variant="invalid" />
        <ChoiceButton option="C" label="1994" variant="disabled" />
      </div>
    </section>
  </main>
</template>
