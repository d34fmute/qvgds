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
  <span :class="[props.class, 'rounded-xl bg-primary p-4 font-bold']">{{
    props.label
  }}</span>
</template>
