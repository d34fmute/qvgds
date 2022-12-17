<script lang="ts" setup>
import { reactive, ref, type Events } from "vue";
import Frame from "./Frame.vue";
import { ChatClient, PrivateMessage } from "@twurple/chat";
import type { TQuestion } from "@/types/TQuestion";

interface Props {
  class?: string;
  currentQuestion: Record<TQuestion>;
}
const props = withDefaults(defineProps<Props>(), {
  class: "",
  question: ""
});

const voteOpen = ref(true);

const timer = ref(20);

const displayReslut = ref(false);

type VoteCmd = "!A" | "!B" | "!C" | "!D";

const voters = ref<string[]>([]);
const votes = ref({
  "!A": 0,
  "!B": 0,
  "!C": 0,
  "!D": 0
});

const voteState = reactive<{
  voters: string[];
  votes: {
    "!A": number;
    "!B": number;
    "!C": number;
    "!D": number;
  };
}>({
  voters: [],
  votes: {
    "!A": 0,
    "!B": 0,
    "!C": 0,
    "!D": 0
  }
});

const client = new ChatClient({ channels: ["wyllen"] });

client.connect();

client?.onMessage(
  (channel: string, user: string, text: string, msg: PrivateMessage) => {
    const vote = text.toUpperCase() as VoteCmd;
    if (["!A", "!B", "!C", "!D"].includes(vote) && voteOpen) {
      console.log("voteState", voteState);
      if (!voteState.voters.includes(user)) {
        voteState.voters.push(user);
        //voters.value.push(user);
        voteState.votes[vote]++;
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
  const totalVotes = voteState.voters.length;
  if (totalVotes === 0) {
    return 0;
  }
  return Math.round((voteState.votes[vote] / totalVotes) * 100);
};

const emit = defineEmits(["close"]);
</script>

<template>
  <div
    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"
    @click="emit('close')"
  ></div>
  <div
    class="absolute top-2/4 left-2/4 flex -translate-x-2/4 -translate-y-2/4 flex-col items-center gap-4"
  >
    <p class="rounded-xl bg-primary p-4 text-2xl">
      {{ currentQuestion.fields.title }}
    </p>
    <Frame class="flex h-96 w-96 flex-col gap-4 p-4">
      <h1 class="text-center text-2xl">A votre tour de voter :</h1>
      <ul class="flex gap-8">
        <li
          :class="[
            'relative',
            'flex w-full items-center justify-center rounded-2xl ',
            'disabled:cursor-not-allowed',
            'text-2xl font-bold text-white',
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
            'text-2xl font-bold text-white',
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
            'text-2xl font-bold text-white',
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
            'text-2xl font-bold text-white',
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
    <div class="grid w-full grid-cols-2 gap-4">
      <p class="flex items-center gap-4 rounded-xl bg-primary p-4 text-2xl">
        <span
          class="flex items-center justify-center rounded-lg bg-white px-3.5 py-2 text-dark"
          >A</span
        >
        {{ currentQuestion.fields.a }}
      </p>
      <p class="flex items-center gap-4 rounded-xl bg-primary p-4 text-2xl">
        <span
          class="flex items-center justify-center rounded-lg bg-white px-3.5 py-2 text-dark"
          >B</span
        >
        {{ currentQuestion.fields.b }}
      </p>
      <p class="flex items-center gap-4 rounded-xl bg-primary p-4 text-2xl">
        <span
          class="flex items-center justify-center rounded-lg bg-white px-3.5 py-2 text-dark"
          >C</span
        >
        {{ currentQuestion.fields.c }}
      </p>
      <p class="flex items-center gap-4 rounded-xl bg-primary p-4 text-2xl">
        <span
          class="flex items-center justify-center rounded-lg bg-white px-3.5 py-2 text-dark"
          >D</span
        >
        {{ currentQuestion.fields.d }}
      </p>
    </div>
  </div>
</template>
