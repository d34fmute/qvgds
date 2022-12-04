<script setup lang="ts">
import PrimaryButton from "@/components/PrimaryButton.vue";
import ChoiceButton from "@/components/ChoiceButton.vue";
import JokerButton from "@/components/JokerButton.vue";
import Tag from "@/components/Tag.vue";
import WebcamFrame from "@/components/WebcamFrame.vue";
</script>

<template>
  <main
    class="h-full min-h-screen w-full bg-gradient-to-b from-[#140C2E] to-[#261D45] py-48 px-10 text-white"
  >
    <img src="/logo.png" alt="Logo shitcoin" class="mx-auto" />
    <section class="flex flex-col items-center gap-4">
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

      <div class="flex items-center gap-4">
        <JokerButton joker="public" />
        <JokerButton joker="phone" />
        <JokerButton joker="switch" state="active" />
        <JokerButton joker="50-50" state="used" />
      </div>

      <div class="flex flex-col items-start gap-4">
        <Tag label="JEAN-PIERRE DEAF'" />
        <WebcamFrame />
      </div>
    </section>
  </main>
</template>
