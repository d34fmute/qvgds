<script lang="ts" setup>
import Frame from "@/components/Frame.vue";
interface Props {
  class?: string;
  currentLevel: number;
}

const props = withDefaults(defineProps<Props>(), {
  currentLevel: 0,
  class: ""
});

const levelsAmount = [
  100, 200, 300, 500, 1_000, 2_000, 4_000, 8_000, 12_000, 24_000, 36_000,
  72_000, 150_000, 300_000, 1_000_000
];
const currentLevelInverse = 15 - props.currentLevel;
</script>

<template>
  <Frame
    :class="`flex items-center justify-center py-5 pl-6 ${
      props.class ?? ''
    } rounded-r-none border-r-0`"
  >
    <ul class="flex flex-col">
      <li
        v-for="(amount, level) in levelsAmount.sort((a, b) => b - a)"
        :class="[
          'flex items-center justify-end gap-6 rounded-l-xl px-8 text-end text-lg',
          currentLevelInverse === level && 'bg-primary/20',
          level < currentLevelInverse && 'opacity-30'
        ]"
      >
        <span
          :class="[
            'p-2',
            currentLevelInverse === level && 'font-bold text-primary'
          ]"
          >{{ amount }}</span
        >

        <span v-if="level % 5 !== 0" class="h-6 w-6">
          {{ 15 - level }}
        </span>

        <span v-else class="flex h-6 w-6 items-center justify-end">
          <img
            src="/emojis/shitcoin.png"
            alt="Shit coin level"
            class="h-6 w-6 -rotate-12"
          />
        </span>
      </li>
    </ul>
  </Frame>
</template>
