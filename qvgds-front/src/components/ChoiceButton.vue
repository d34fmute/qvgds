<script lang="ts" setup>
import { computed } from "vue";

interface Props {
  class?: string;
  type?: "button" | "submit";
  variant?: "valid" | "invalid" | "selected" | "hollow" | "disabled";
  option: "A" | "B" | "C" | "D";
  label: string;
}

interface Events {
  (e: "click"): void;
}

const props = withDefaults(defineProps<Props>(), {
  class: "",
  type: "button",
  disabled: false
});

const emit = defineEmits<Events>();
const colorClasses = computed<{
  tagClasses: string;
  buttonClasses: string;
}>(() => {
  switch (props.variant) {
    case "selected":
      return {
        tagClasses: "bg-warning-50 text-white",
        buttonClasses: "bg-warning border-warning-50 border-4 cursor-pointer"
      };
    case "valid":
      return {
        tagClasses: "bg-success-50 text-white",
        buttonClasses: "bg-success border-success-50 border-4 cursor-default"
      };
    case "invalid":
      return {
        tagClasses: "bg-danger-50 text-white",
        buttonClasses: "bg-danger border-danger-50 border-4 cursor-default"
      };
    case "disabled":
      return {
        tagClasses: "bg-white text-dark",
        buttonClasses:
          "bg-transparent border-white/10 border-2 opacity-50 bg-white/10"
      };
    default:
      return {
        tagClasses: "bg-white text-dark",
        buttonClasses:
          "bg-transparent border-white/10 hover:border-white border-2 cursor-pointer"
      };
  }
});
</script>

<template>
  <button
    :class="[
      props.class,
      colorClasses.buttonClasses,
      'flex w-full items-center justify-center gap-2 rounded-2xl py-3 px-3',
      'disabled:cursor-not-allowed',
      'font-bold text-white'
    ]"
    :type="props.type"
    @click="emit('click')"
    :disabled="props.variant === 'disabled'"
  >
    <span
      :class="[
        'flex items-center justify-center rounded-lg px-3.5 py-2',
        colorClasses.tagClasses
      ]"
      >{{ option }}</span
    >
    <span class="flex-grow">{{ label }}</span>
  </button>
</template>
