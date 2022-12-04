<script setup lang="ts">
import { computed } from "vue";

interface Props {
  class?: string;
  type?: string;
  placeholder?: string;
  modelValue?: string;
  error?: string | null;
  autoFocus?: boolean;
}

interface Events {
  (e: "update:modelValue", value: string): void;
}

const props = withDefaults(defineProps<Props>(), {
  class: "",
  type: "text",
  modelValue: "",
  autoFocus: false
});

const emit = defineEmits<Events>();

const value = computed<string>({
  get() {
    return props.modelValue;
  },
  set(value) {
    emit("update:modelValue", value);
  }
});
</script>

<template>
  <input
    :autofocus="autoFocus"
    v-model.trim="value"
    :placeholder="placeholder"
    :type="type"
    :class="[
      'rounded-2xl border-white bg-white/10 py-3 px-3',
      'border-2 border-white/10 bg-transparent',
      'ring-primary focus:outline-none focus:ring-4',
      'placeholder:text-white/10'
    ]"
  />

  <small class="max-w-[205px] font-semibold italic text-danger" v-if="!!error">
    {{ error }}
  </small>
</template>
