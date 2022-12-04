<script lang="ts" setup>
import { computed } from "vue";
import PublicIcon from "@/components/icons/PublicIcon.vue";
import SwitchIcon from "@/components/icons/SwitchIcon.vue";
import PhoneIcon from "@/components/icons/PhoneIcon.vue";
import FiftyFiftyIcon from "@/components/icons/FiftyFiftyIcon.vue";
import XIcon from "@/components/icons/XIcon.vue";

interface Props {
  class?: string;
  state?: "default" | "active" | "used";
  joker: "50-50" | "public" | "phone" | "switch";
}

interface Events {
  (e: "click"): void;
}

const props = withDefaults(defineProps<Props>(), {
  class: "",
  state: "default"
});

const emit = defineEmits<Events>();
const colorClasses = computed<string>(() => {
  switch (props.state) {
    case "active":
      return "bg-primary border-primary text-white border-2 cursor-pointer";
    case "used":
      return "bg-transparent border-white/10 text-white/30 border-2";
    default:
      return "bg-dark/20 border-primary text-white border-2 cursor-pointer";
  }
});
</script>

<template>
  <button
    :class="[
      props.class,
      colorClasses,
      'relative',
      'flex w-full items-center justify-center gap-2 rounded-2xl py-3 px-3',
      'disabled:cursor-not-allowed',
      'font-bold text-white'
    ]"
    type="button"
    @click="emit('click')"
    :disabled="props.state === 'used'"
  >
    <XIcon
      class="absolute top-1/2 left-1/2 h-5 w-5 -translate-x-1/2 -translate-y-1/2 text-danger"
      v-if="props.state === 'used'"
    />
    <PublicIcon class="h-4 w-4" v-if="joker === 'public'" />
    <SwitchIcon class="h-4 w-4" v-if="joker === 'switch'" />
    <PhoneIcon class="h-4 w-4" v-if="joker === 'phone'" />
    <FiftyFiftyIcon class="h-4 w-4" v-if="joker === '50-50'" />
  </button>
</template>
