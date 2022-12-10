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
      'rounded-2.5xl border-4 border-[#2e2156] bg-clip-padding',
      'flex h-[350px] w-[600px] items-center justify-center',
      'bg-[#231c38] shadow-frame'
    ]"
  >
    <span class="text-2xl font-bold text-white">CAM</span>
  </div>
</template>
