<script setup lang="ts">
import PrimaryButton from "@/components/PrimaryButton.vue";
import LevelsMenu from "@/components/LevelsMenu.vue";
import WebcamFrame from "@/components/WebcamFrame.vue";
import Tag from "@/components/Tag.vue";
import JokerButton, { type JokerState } from "@/components/JokerButton.vue";
import ChoiceButton, {
  type ButtonVariant
} from "@/components/ChoiceButton.vue";
import { reactive, ref } from "vue";
import Frame from "@/components/Frame.vue";
import SwitchSceneIcon from "@/components/icons/SwitchSceneIcon.vue";
import { useRoute } from "vue-router";
import { getQuestionsBySessionId } from "@/airtable/questions";
import { useQuery } from "@tanstack/vue-query";
import { computed } from "@vue/reactivity";

const route = useRoute();

const sessionId = route.params.sessionId;

const {
  isLoading,
  isError,
  data: questions,
  error
} = useQuery({
  queryKey: ["sessions"],
  queryFn: () => getQuestionsBySessionId(sessionId as string)
});

const sceneTwoCams = ref(true);

const level = ref(1);

const gameOver = ref(false);

const currentQuestion = computed(() => {
  return questions.value?.find(
    (question) => question.fields.level === `${level.value}`
  );
});

interface Joker {
  state: JokerState;
}
const jokers = reactive<{ fifty: Joker; chat: Joker; friend: Joker }>({
  fifty: { state: "used" },
  chat: { state: "default" },
  friend: { state: "default" }
});

const handleJokerClick = (joker: "fifty" | "chat" | "friend") => {
  const currentJoker = jokers[joker];
  const state = currentJoker.state;
  if (state === "active") {
    currentJoker.state = "used";
  }
  if (state === "used") {
    currentJoker.state = "default";
  }
  if (state === "default") {
    currentJoker.state = "active";
  }
};

type Choice = "a" | "b" | "c" | "d";

const currentChoice = ref<Choice | undefined>();
const choiceValidated = ref<boolean>(false);

const getButtonVariant = (choice: Choice): ButtonVariant | undefined => {
  if (currentChoice.value === undefined) {
    return;
  }
  if (
    currentQuestion.value?.fields.answer === choice &&
    choiceValidated.value
  ) {
    return "valid";
  }
  if (
    currentQuestion.value?.fields.answer !== choice &&
    choiceValidated.value &&
    currentChoice.value === choice
  ) {
    return "invalid";
  }
  if (currentChoice.value === choice) {
    console.log("currentChoice.value", currentChoice.value);
    return "selected";
  }
};

const handleChoice = (choice: Choice) => {
  currentChoice.value = choice;
};

const handleResolution = () => {
  console.log(
    "currentQuestion.value?.fields.answer",
    currentQuestion.value?.fields.answer
  );
  console.log("currentChoice.value", currentChoice.value);
  if (currentQuestion.value?.fields.answer !== currentChoice.value) {
    gameOver.value = true;
  }
  choiceValidated.value = true;
};

const handleNextQuestion = () => {
  level.value++;
  choiceValidated.value = false;
  currentChoice.value = undefined;
};
</script>

<template>
  <main
    class="flex h-full min-h-screen w-full bg-emojis-half bg-auto bg-top bg-repeat-x text-white"
  >
    <button
      class="absolute top-6 right-6 aspect-square"
      @click="sceneTwoCams = !sceneTwoCams"
    >
      <SwitchSceneIcon class="h-5 w-5" />
    </button>
    <div class="flex w-[426px] flex-col" v-if="!sceneTwoCams">
      <div class="mt-24 flex flex-col justify-center text-center">
        <img
          src="/logo-with-shit.png"
          alt="Logo shitcoin"
          class="m-auto w-[350px]"
          v-if="!sceneTwoCams"
        />
        <div class="mt-52 mb-2"><span class="text-white/50">Joueur</span></div>
        <div>
          <strong class="text-3xl">{{ $route.params.username }}</strong>
        </div>
      </div>
      <div class="mt-40">
        <p class="mb-4 w-72 text-center">
          <strong class="text-2xl">JOKERS</strong>
        </p>
        <Frame class="w-72 rounded-l-none border-l-0 py-5 pl-6">
          <div class="mb-6 flex items-center gap-6">
            <JokerButton
              class="w-14"
              joker="50-50"
              :state="jokers.fifty.state"
              @click="handleJokerClick('fifty')"
            />
            <strong>50 : 50</strong>
          </div>
          <div class="mb-6 flex items-center gap-6">
            <JokerButton
              class="w-14"
              joker="public"
              :state="jokers.chat.state"
              @click="handleJokerClick('chat')"
            />
            <strong>Aide du chat</strong>
          </div>
          <div class="flex items-center gap-6">
            <JokerButton
              class="w-14"
              joker="phone"
              :state="jokers.friend.state"
              @click="handleJokerClick('friend')"
            />
            <strong>Appel à un ami</strong>
          </div>
        </Frame>
      </div>
    </div>
    <div
      class="flex flex-col justify-center"
      :class="`${!sceneTwoCams && 'order-2'}`"
    >
      <p class="mb-2 text-center">
        <strong class="text-xl">GAINS</strong>
      </p>
      <LevelsMenu class="" :right="!sceneTwoCams" :currentLevel="level" />
    </div>
    <div class="flex flex-auto flex-col items-center px-5 pt-8">
      <img
        src="/logo-with-shit.png"
        alt="Logo shitcoin"
        class="mx-auto -mb-12"
        v-if="sceneTwoCams"
      />
      <div class="flex justify-between">
        <div class="flex flex-col items-start gap-4" v-if="sceneTwoCams">
          <Tag label="JEAN-PIERRE DEAF'" class="ml-8" />
          <WebcamFrame />
        </div>
        <div
          v-if="sceneTwoCams"
          class="justify-centerpx-8 flex flex-col justify-center gap-4 px-5"
        >
          <strong>JOKER</strong>
          <JokerButton
            joker="50-50"
            :state="jokers.fifty.state"
            @click="handleJokerClick('fifty')"
          />
          <JokerButton
            joker="public"
            :state="jokers.chat.state"
            @click="handleJokerClick('chat')"
          />
          <JokerButton
            joker="phone"
            :state="jokers.friend.state"
            @click="handleJokerClick('friend')"
          />
        </div>
        <div class="flex flex-col items-end gap-4">
          <Tag
            :label="($route.params.username as string)"
            class="mr-8 uppercase"
            v-if="sceneTwoCams"
          />
          <WebcamFrame
            :class="`${!sceneTwoCams && 'mt-20 h-[466px] w-[836px]'}`"
          />
        </div>
      </div>
      <div class="pt-4">
        <div class="flex min-h-[160px] max-w-7xl flex-col justify-center">
          <p class="whitespace-pre-line text-4xl">
            {{ currentQuestion?.fields.title }}
          </p>
        </div>
        <div class="grid w-full grid-cols-2 gap-4" v-if="currentQuestion">
          <ChoiceButton
            option="A"
            :label="currentQuestion.fields.a"
            :variant="getButtonVariant('a')"
            @click="handleChoice('a')"
          />
          <ChoiceButton
            option="B"
            :label="currentQuestion.fields.b"
            :variant="getButtonVariant('b')"
            @click="handleChoice('b')"
          />
          <ChoiceButton
            option="C"
            :label="currentQuestion.fields.c"
            :variant="getButtonVariant('c')"
            @click="handleChoice('c')"
          />
          <ChoiceButton
            option="D"
            :label="currentQuestion.fields.d"
            :variant="getButtonVariant('d')"
            @click="handleChoice('d')"
          />
        </div>
        <div class="mt-8 flex justify-center">
          <div v-if="gameOver">
            <strong>PERDU !</strong>
          </div>
          <div v-else>
            <PrimaryButton
              v-if="!choiceValidated"
              :disabled="currentChoice === undefined"
              @click="handleResolution"
              >Valider</PrimaryButton
            >
            <PrimaryButton v-if="choiceValidated" @click="handleNextQuestion"
              >Question suivante</PrimaryButton
            >
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
