<script lang="ts" setup>
import { computed } from "vue";
import Loader from "@/components/Loader.vue";

interface Props {
  class?: string;
  type?: "button" | "submit";
  disabled?: boolean;
  isLoading?: boolean;
}

interface Events {
  (e: "click"): void;
}

const props = withDefaults(defineProps<Props>(), {
  class: "",
  type: "button",
  disabled: false,
  isLoading: false
});

const emit = defineEmits<Events>();
const buttonDisabled = computed(() => props.isLoading || props.disabled);
</script>

<template>
  <button
    :class="[
      props.class,
      'rounded-[20px]', // border radius de 20px = border-radius de l'enfant + padding = 18px + 2px
      'bg-gradient-to-b from-[#6949cd] via-[#563ba7] to-[#3E2B78] p-0.5',
      'font-bold uppercase text-white',
      buttonDisabled
        ? 'bg-secondary cursor-not-allowed grayscale'
        : 'cursor-pointer'
    ]"
    :type="props.type"
    @click="emit('click')"
    :disabled="buttonDisabled"
  >
    <div
      :class="[
        'flex h-full w-full items-center gap-2 rounded-2.5xl py-4 px-6',
        'bg-gradient-to-b from-primary to-primary/30',
        'justify-center'
      ]"
    >
      <slot />
      <Loader v-if="isLoading" class="!mr-0 !ml-0" />
    </div>
  </button>
</template>
