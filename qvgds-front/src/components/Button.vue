<script lang="ts" setup>
import { computed } from "vue";

interface Props {
  class?: string;
  variant?: "primary" | "secondary";
  type?: "button" | "submit";
  disabled?: boolean;
  isLoading?: boolean;
}

interface Events {
  (e: "click"): void;
}

const props = withDefaults(defineProps<Props>(), {
  class: "",
  variant: "primary",
  square: false,
  loading: false,
});

const emit = defineEmits<Events>();

const classes = computed(() => {
  return {
    "bg-primary": props.variant === "primary",
    "bg-secondary cursor-not-allowed":
      Boolean(props.disabled) || props.isLoading,
    "rounded-md flex gap-2 items-center py-2 px-4": true,
    [props.class]: true,
  };
});
</script>

<script>
// i don't know why but eslint yells at me, so there it is :
export default {
  name: "QButton",
};
</script>

<template>
  <button
    :class="classes"
    :type="props.type"
    @click="emit('click')"
    :disabled="props.disabled || props.isLoading"
  >
    <slot />
    <Loader v-if="props.isLoading" class="!mr-0 !ml-0" />
  </button>
</template>
