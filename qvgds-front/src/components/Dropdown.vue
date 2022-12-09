<script setup lang="ts">
import "vue-select/dist/vue-select.css";

export interface DropdownOption {
  value: string;
  label: string;
}
interface Props {
  class?: string;
  type?: "button" | "submit";
  disabled?: boolean;
  isLoading?: boolean;
  options?: DropdownOption[];
}
interface Events {
  (e: "change"): void;
}

const props = withDefaults(defineProps<Props>(), {
  class: "",
  type: "button",
  disabled: false,
  isLoading: false,
  options: () => []
});

const emit = defineEmits<Events>();
</script>

<style>
.dropdown {
  --vs-controls-color: #fff;
  --vs-border-color: transparent;
  /* --vs-border-width: 0; */

  --vs-dropdown-bg: #3e2a78;
  --vs-dropdown-color: #fff;
  --vs-dropdown-option-color: #fff;

  --vs-selected-bg: #664cc3;
  --vs-selected-color: #eeeeee;

  --vs-search-input-color: #eeeeee;

  --vs-dropdown-option--active-bg: #664cc3;
  --vs-dropdown-option--active-color: #eeeeee;
}
.dropdown .vs__dropdown-toggle {
  width: 100%;
}
</style>

<template>
  <v-select
    :class="[
      props.class,
      'dropdown flex min-h-[60px] min-w-[300px] rounded-[20px]',
      'bg-gradient-to-b from-[#6949cd] via-[#563ba7] to-[#3E2B78] p-0.5',
      'font-bold uppercase text-white'
    ]"
    :options="options"
  ></v-select>
</template>
