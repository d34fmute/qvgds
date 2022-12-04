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
      'rounded-2.5xl border-4 border-primary/50 bg-dark-50',
      'shadow-frame'
    ]"
  >
    <slot />
  </div>
</template>
