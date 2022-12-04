<script setup lang="ts">
interface Props {
  class?: string;
}

const props = defineProps<Props>();
</script>

<template>
  <svg
    :class="props.class"
    viewBox="0 0 32 32"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <rect
      x="0.0443115"
      y="29.859"
      width="42.1644"
      height="2.96522"
      rx="1"
      transform="rotate(-45 0.0443115 29.859)"
      fill="currentColor"
    />
    <rect
      x="2.0968"
      width="42.2895"
      height="2.96522"
      rx="1"
      transform="rotate(45 2.0968 0)"
      fill="currentColor"
    />
  </svg>
</template>
