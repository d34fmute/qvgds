<script lang="ts" setup>
import { ref, type Events } from "vue";
import Frame from "./Frame.vue";
import { ChatClient, PrivateMessage } from "@twurple/chat";

interface Props {
  class?: string;
}
const props = withDefaults(defineProps<Props>(), {
  class: ""
});

const voteOpen = ref(true);
const voters = ref<string[]>([]);
const timer = ref(10);
const displayReslut = ref(false);

type VoteCmd = "!A" | "!B" | "!C" | "!D";

const votes = ref({
  "!A": 0,
  "!B": 0,
  "!C": 0,
  "!D": 0
});

const client = new ChatClient({ channels: ["wyllen"] });

client.connect();

client?.onMessage(
  (channel: string, user: string, text: string, msg: PrivateMessage) => {
    const vote = text.toUpperCase() as VoteCmd;
    if (["!A", "!B", "!C", "!D"].includes(vote) && voteOpen) {
      if (!voters.value.includes(user)) {
        voters.value.push(user);
        votes.value[vote]++;
      }
    }
  }
);

const interval = setInterval(() => {
  timer.value--;
  if (timer.value === 0) {
    voteOpen.value = false;
    clearInterval(interval);
    setTimeout(() => {
      displayReslut.value = true;
    }, 500);
  }
}, 1000);

const getPercent = (vote: VoteCmd) => {
  if (!displayReslut.value) {
    return 0;
  }
  const totalVotes = voters.value.length;
  if (totalVotes === 0) {
    return 0;
  }
  return Math.round((votes.value[vote] / totalVotes) * 100);
};

const emit = defineEmits(["close"]);
</script>

<template>
  <div
    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"
    @click="emit('close')"
  ></div>
  <Frame
    class="absolute top-2/4 left-2/4 flex h-96 w-96 -translate-x-2/4 -translate-y-2/4 flex-col gap-4 p-4"
  >
    <h1 class="text-center text-2xl">A votre tour de voter :</h1>
    <ul class="flex gap-8">
      <li
        :class="[
          'relative',
          'flex w-full items-center justify-center rounded-2xl ',
          'disabled:cursor-not-allowed',
          'font-bold text-white',
          'border-2',
          'aspect-square'
        ]"
      >
        !A
      </li>
      <li
        :class="[
          'relative',
          'flex w-full items-center justify-center rounded-2xl ',
          'disabled:cursor-not-allowed',
          'font-bold text-white',
          'border-2',
          'aspect-square'
        ]"
      >
        !B
      </li>
      <li
        :class="[
          'relative',
          'flex w-full items-center justify-center rounded-2xl ',
          'disabled:cursor-not-allowed',
          'font-bold text-white',
          'border-2',
          'aspect-square'
        ]"
      >
        !C
      </li>
      <li
        :class="[
          'relative',
          'flex w-full items-center justify-center rounded-2xl ',
          'disabled:cursor-not-allowed',
          'font-bold text-white',
          'border-2',
          'aspect-square'
        ]"
      >
        !D
      </li>
    </ul>
    <div class="mt-4 flex h-full items-center justify-center" v-if="voteOpen">
      <strong class="text-8xl">{{ timer }}</strong>
    </div>
    <div v-else class="flex h-full items-end gap-8">
      <p
        class="flex min-h-[1rem] w-full flex-auto items-center justify-center rounded-lg rounded-b-none bg-primary transition-all duration-1000"
        :style="`height: ${getPercent('!A')}%`"
      >
        <span>{{ getPercent("!A") }}%</span>
      </p>
      <p
        class="flex min-h-[1rem] w-full flex-auto items-center justify-center rounded-lg rounded-b-none bg-primary transition-all duration-1000"
        :style="`height: ${getPercent('!B')}%`"
      >
        <span>{{ getPercent("!B") }}%</span>
      </p>
      <p
        class="flex min-h-[1rem] w-full flex-auto items-center justify-center rounded-lg rounded-b-none bg-primary transition-all duration-1000"
        :style="`height: ${getPercent('!C')}%`"
      >
        <span>{{ getPercent("!C") }}%</span>
      </p>
      <p
        class="flex min-h-[1rem] w-full flex-auto items-center justify-center rounded-lg rounded-b-none bg-primary transition-all duration-1000"
        :style="`height: ${getPercent('!D')}%`"
      >
        <span>{{ getPercent("!D") }}%</span>
      </p>
    </div>
  </Frame>
</template>
