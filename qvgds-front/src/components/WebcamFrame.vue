<script lang="ts" setup>
interface Props {
  class?: string;
}

const props = withDefaults(defineProps<Props>(), {
  class: ""
});
</script>

<template>
  <div
    :class="[
      props.class,
      'rounded-2.5xl border-4 border-dark/25 bg-clip-padding',
      'flex h-[350px] w-[600px] items-center justify-center',
      'bg-dark shadow-frame'
    ]"
  >
    <span class="font-bold text-white">CAM</span>
  </div>
</template>
