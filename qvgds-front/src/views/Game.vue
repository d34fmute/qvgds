<script setup lang="ts">
import PrimaryButton from "@/components/PrimaryButton.vue";
import LevelsMenu from "@/components/LevelsMenu.vue";
import WebcamFrame from "@/components/WebcamFrame.vue";
import Tag from "@/components/Tag.vue";
import JokerButton, { type JokerState } from "@/components/JokerButton.vue";
import ChoiceButton, {
  type ButtonVariant
} from "@/components/ChoiceButton.vue";
import type { ComputedRef } from "vue";
import { reactive, ref, watch } from "vue";
import Frame from "@/components/Frame.vue";
import SwitchSceneIcon from "@/components/icons/SwitchSceneIcon.vue";
import { useRoute } from "vue-router";
import { getQuestionsBySessionId } from "@/airtable/questions";
import { useQuery } from "@tanstack/vue-query";
import { computed } from "@vue/reactivity";
import type { TQuestion } from "@/types/TQuestion";
import ChatJoker from "@/components/ChatJoker.vue";
import router from "@/router";
import confetti from "canvas-confetti";

const launchConfetti = () => {
  var duration = 15 * 1000;
  var animationEnd = Date.now() + duration;
  var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

  function randomInRange(min: number, max: number) {
    return Math.random() * (max - min) + min;
  }

  var interval: any = setInterval(function () {
    var timeLeft = animationEnd - Date.now();

    if (timeLeft <= 0) {
      return clearInterval(interval);
    }

    var particleCount = 50 * (timeLeft / duration);
    // since particles fall down, start a bit higher than random
    confetti(
      Object.assign({}, defaults, {
        particleCount,
        origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
      })
    );
    confetti(
      Object.assign({}, defaults, {
        particleCount,
        origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
      })
    );
  }, 250);
};

type Choice = "a" | "b" | "c" | "d";

interface ChoiceButton {
  variant?: ButtonVariant;
  label: string;
  option: string;
}

interface ChoiceButtons {
  a: ChoiceButton;
  b: ChoiceButton;
  c: ChoiceButton;
  d: ChoiceButton;
}

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
const level = ref(14);
const gameOver = ref(false);
const currentChoice = ref<Choice | undefined>();
const choiceValidated = ref<boolean>(false);
const isFiftyEnable = ref<boolean>(false);
const isBadChoiceSkiped = ref<boolean>(false);
const answersRemoved = ref<string[]>([]);
const isChatJokerEnable = ref<boolean>(false);

const choiceButtons = reactive<ChoiceButtons>({
  a: { label: "", option: "A" },
  b: { label: "", option: "B" },
  c: { label: "", option: "C" },
  d: { label: "", option: "D" }
});

const currentQuestion = computed(() => {
  return questions.value?.find(
    (question) => question.fields.level === `${level.value + 1}`
  );
});

watch(currentQuestion, (newValue, oldValue) => {
  const question = newValue;
  for (const l in choiceButtons) {
    const c = l as Choice;
    choiceButtons[c].label = question?.fields[c] || "";
  }
});

interface Joker {
  state: JokerState;
}
const jokers = reactive<{ fifty: Joker; chat: Joker; friend: Joker }>({
  fifty: { state: "default" },
  chat: { state: "default" },
  friend: { state: "default" }
});

const handleJokerClick = (joker: "fifty" | "chat" | "friend") => {
  const currentJoker = jokers[joker];
  if (joker === "fifty") {
    isFiftyEnable.value = true;
  }
  if (joker === "chat") {
    isChatJokerEnable.value = true;
  }
  currentJoker.state = "used";
};

const getButtonVariant = (choice: Choice): ButtonVariant | undefined => {
  if (isFiftyEnable.value) {
    if (currentQuestion.value?.fields.answer !== choice) {
      if (
        ((isBadChoiceSkiped.value || Math.random() < 0.5) &&
          answersRemoved.value.length < 2) ||
        answersRemoved.value.includes(choice)
      ) {
        answersRemoved.value.push(choice);
        return "disabled";
      } else {
        isBadChoiceSkiped.value = true;
      }
    }
  }
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
    return "selected";
  }
};

const handleChoice = (choice: Choice) => {
  currentChoice.value = choice;
};

const getResolvedLevel = (level: number) => {
  if (level < 5) {
    return 0;
  }
  if (level < 10) {
    return 5;
  }
  if (level < 15) {
    return 10;
  }
  return 15;
};

const handleResolution = () => {
  if (currentQuestion.value?.fields.answer !== currentChoice.value) {
    gameOver.value = true;
  } else if (level.value === 14) {
    launchConfetti();
    level.value++;
    gameOver.value = true;
  }
  choiceValidated.value = true;
};

const handleNextQuestion = () => {
  level.value++;
  choiceValidated.value = false;
  currentChoice.value = undefined;
  isFiftyEnable.value = false;
  isBadChoiceSkiped.value = false;
  answersRemoved.value = [];
};

const handleCloseChatJoker = () => {
  isChatJokerEnable.value = false;
};

const handleLeaveGame = () => {
  router.push({
    name: "gameover",
    params: {
      level: getResolvedLevel(level.value),
      username: route.params.username
    }
  });
};

const handleLeaveGameWithMoney = () => {
  router.push({
    name: "gameover",
    params: {
      level: level.value,
      username: route.params.username
    }
  });
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
            :label="choiceButtons.a.label"
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
            <PrimaryButton v-if="choiceValidated" @click="handleLeaveGame"
              >Récupérer ses gains</PrimaryButton
            >
          </div>
          <div v-else class="flex flex-col items-center gap-10">
            <PrimaryButton
              v-if="!choiceValidated"
              :disabled="currentChoice === undefined"
              @click="handleResolution"
              >Valider</PrimaryButton
            >
            <PrimaryButton v-if="choiceValidated" @click="handleNextQuestion"
              >Question suivante</PrimaryButton
            >
            <div>
              <PrimaryButton @click="handleLeaveGameWithMoney"
                >Prendre l'argent !</PrimaryButton
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    <ChatJoker
      v-if="isChatJokerEnable"
      @close="handleCloseChatJoker"
      :question="currentQuestion?.fields.title"
    />
  </main>
</template>
