<!-- CRÉDITOS:
     https://www.youtube.com/watch?v=amGhwZPgemY
     Canal => cdruc
-->
<script setup>
import { ref, computed, onMounted } from "vue";
import {cva} from "class-variance-authority";
import {
  InformationCircleIcon,
  ExclamationIcon,
  CheckCircleIcon,
  XCircleIcon,
  XIcon,
} from "@heroicons/vue/solid";

const props = defineProps({
  intent: {
    type: String,
    validator(value){
      return ["info","success","danger","warning"].includes(value)
    },
    default: "info"
  },
  title: String,
  show: {
    type: Boolean,
    default: true,
  },
  onDismiss: Function,
});

const containerClass = computed(() =>{
  return cva("flex p-4 rounded-md space-x-3 shadow-md",{
    variants: {
      intent: {
        info: "bg-blue-100",
        success: "bg-green-100",
        warning: "bg-orange-100",
        danger: "bg-red-100",
      }
    }
  })({
    intent: props.intent,
  })
})
const iconClass = computed(() =>{
  return cva("w-6 h-6",{
    variants: {
      intent: {
        info: "text-blue-700",
        success: "text-green-700",
        warning: "text-orange-700",
        danger: "text-red-700",
      }
    }
  })({
    intent: props.intent,
  })
})
const titleClass = computed(() =>{
  return cva("font-medium ",{
    variants: {
      intent: {
        info: "text-blue-900",
        success: "text-green-900",
        warning: "text-orange-900",
        danger: "text-red-900",
      }
    }
  })({
    intent: props.intent,
  })
})
const contentClass = computed(() =>{
  return cva("text-sm",{
    variants: {
      intent: {
        info: "text-blue-800",
        success: "text-green-800",
        warning: "text-orange-800",
        danger: "text-red-800",
      }
    }
  })({
    intent: props.intent,
  })
})
const closeButtonClass = computed(() =>{
  return cva("p-0.5 rounded-md -m-1",{
    variants: {
      intent: {
        info: "text-blue-900/70 hover:text-blue-900 hover:bg-blue-200",
        success: "text-green-900/70 hover:text-green-900 hover:bg-green-200",
        warning: "text-orange-900/70 hover:text-orange-900 hover:bg-orange-200",
        danger: "text-red-900/70 hover:text-red-900 hover:bg-red-200",
      }
    }
  })({
    intent: props.intent,
  })
});
const progressiveBarClass = computed(() =>{
  return cva("absolute bottom-0 rounded-b-md -left-3 h-1 w-full",{
    variants: {
      intent: {
        info: "bg-blue-600",
        success: "bg-green-600",
        warning: "bg-orange-600",
        danger: "bg-red-600",
      }
    }
  })({
    intent: props.intent,
  })
});

const iconComponent = computed(() => {
  const icons = {
    info: InformationCircleIcon,
    success: CheckCircleIcon,
    warning: ExclamationIcon,
    danger: XCircleIcon,
  };
  return icons[props.intent];
});

function dismiss() {
  if(props.onDismiss){
    props.onDismiss();
  }
}

const showNotification = ref(false);
onMounted(() => {
    showNotification.value = true;
    setTimeout(() => showNotification.value = false, 3500);
})
</script>
<template>
  <!-- <transition name="" 
    enter-active-class="transition-all transition-fastest ease-out-quad" 
    leave-active-class="transition-all transition-faster ease-in-quad"
    enter-class="opacity-0 scale-70"
    enter-to-class="opacity-100 scale-100"
    leave-class="opacity-100 scale-100"
    leave-to-class="opacity-0 scale-70"
    > -->
  <transition name="slide">
    <div v-if="showNotification" :class="containerClass">
      <div class="shrink-0">
        <component :is="iconComponent" :class="iconClass" />
      </div>
      <div class="flex-1">
        <h2 :class="titleClass">{{ props.title }}</h2>
        <div :class="contentClass"><slot /></div>
      </div>
      <div class="shrink-0">
        <button @click="showNotification = !showNotification" :class="closeButtonClass">
          <XIcon class="w-4 h-4"/>
        </button>
      </div>
      <transition name="bar">
        <div :class="progressiveBarClass"></div>
      </transition>
    </div>
    
    <!-- <div v-if="props.show" :class="containerClass">
      <div class="shrink-0">
        <component :is="iconComponent" :class="iconClass" />
      </div>
      <div class="flex-1">
        <h2 :class="titleClass">{{ props.title }}</h2>
        <div :class="contentClass"><slot /></div>
      </div>
      <div class="shrink-0">
        <button @click="dismiss" :class="closeButtonClass">
          <XIcon class="w-5 h-5"/>
        </button>
      </div>
    </div> -->
  </transition>
</template>
<style>
/* Animações de entrada/saída podem usar diferentes */
/* durações e funções de tempo */
.slide-enter-active {
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.35);  
  transform: translateX(-12px);
}

.slide-leave-active {
  /* transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.35); */
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.35);
  
}
.slide-enter-from,
.slide-leave-to {
  transform: translateX(50px);
  opacity: 0;
}
</style>