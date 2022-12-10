<script setup lang="ts">
interface Props {
  class?: string;
}

const props = defineProps<Props>();
</script>

<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    :class="props.class"
    width="24"
    height="24"
    viewBox="0 0 24 24"
    fill="none"
  >
    <path
      d="M24 14.535V6.85903H20.9031V10.8274L11.9998 2L9.80887 4.17223L18.7122 12.9996H14.7094V16.0701H22.4514C22.8621 16.0701 23.2561 15.9084 23.5464 15.6203C23.8366 15.3325 24 14.9419 24 14.535L24 14.535Z"
      fill="currentColor"
    />
    <path
      d="M14.1911 20.292L5.28782 11.4646H9.29058V8.39417H1.54857C1.13787 8.39417 0.743889 8.55587 0.453633 8.84393C0.163363 9.13172 0 9.52232 0 9.92926V17.6052H3.09687V13.6369L12.0002 22.4643L14.1911 20.292Z"
      fill="currentColor"
    />
  </svg>
</template>
