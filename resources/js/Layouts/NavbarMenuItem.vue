<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { ChevronDownIcon } from "@heroicons/vue/outline";

import MenuItem from "@/Layouts/NavbarMenuItem.vue";

const props = defineProps({
  label: {
    type: String,
    require: true,
  },
  icon: "",
  href: {
    type: String,
  },
  urlActive: "",
  depth: {
    type: Number,
    require: true,
  },
  data: {
    type: Array,
  },
});

const showChildren = ref(false);

/* const toggleMenu = () => {
  showChildren = !showChildren
} */
</script>

<template>
  <!-- #### MENU: Item -->
  <div :class="showChildren ? '' : ''">
    <div
      @click="showChildren = !showChildren"
      class="flex items-center justify-between text-base rounded-lg transition duration-75 hover:cursor-pointer hover:text-gray-50 hover:bg-gray-700 focus:text-gray-400 active:scale-95 group"
      :class="showChildren ? 'text-gray-200 font-bold' : 'text-gray-300/80'"
    >
      <!-- Se houver href -->
      <Link
        v-if="href"
        :href="route(href)"
        :class="[
          'flex items-center gap-1 p-2 w-full',
          $page.url.startsWith(urlActive) ? 'bg-gray-700 rounded-lg' : '',
        ]"
      >
        <component v-if="icon" :is="icon" class="h-4 w-4" />
        <span>{{ label }}</span>
      </Link>

      <!-- Se href não foi definido-->
      <div v-else class="flex items-center gap-1 p-2">
        <div v-if="icon"><component :is="icon" class="h-4 w-4" /></div>
        <span>{{ label }}</span>
      </div>

      <!-- Se existir children, carrega ícone seta -->
      <div
        v-if="data"
        :class="showChildren ? 'transform rotate-180' : ''"
        class="transition duration-300 text-gray-400"
      >
        <component :is="ChevronDownIcon" class="h-4 w-4" />
      </div>
    </div>

    <!-- Somente exibe o componente, se showChildren == true -->
    <div v-show="showChildren" class=" has-[:md]:text-indigo-900 bg-gray-700 rounded-md">
      <MenuItem
        v-for="(item, index) in data"
        :key="index"
        :label="item.label"
        :icon="item.icon"
        :href="item.href"
        :urlActive="item.urlActive"
        :depth="depth + 1"
        :data="item.children"
        class="pl-5"
      />
    </div>
  </div>
</template>

<style></style>