<script lang="ts" setup>
interface Props {
  class?: string;
  label: string;
}

const props = withDefaults(defineProps<Props>(), {
  class: ""
});
</script>

<template>
  <span
    :class="[
      props.class,
      'rounded-xl bg-primary py-3 px-6 font-bold',
      'flex items-center justify-center'
    ]"
    >{{ props.label }}</span
  >
</template>
