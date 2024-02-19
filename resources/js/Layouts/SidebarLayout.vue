<script setup>
import {
  CubeIcon,
  CalendarIcon,
  ChatIcon,
  ClipboardListIcon,
  ClockIcon,
  HeartIcon,
  HomeIcon,
  SearchIcon,
  ChartBarIcon,
} from "@heroicons/vue/outline";

import { router } from '@inertiajs/vue3';

import { FwbSidebar, FwbSidebarItem, FwbSidebarDropdownItem, FwbSidebarLogo   } from "flowbite-vue";

/* Criando uma Matriz de valores para montar os menus */
// MENU: Permissões
const menu_configs = [
  { href: "/admin/roles", label: "Funções", icon: ChatIcon, can: "Admin" },
  {
    href: "/admin/permissions",
    label: "Permissões",
    icon: CubeIcon,
    can: "Admin",
  },
  {
    href: "/admin/users",
    label: "Funções a usuários",
    icon: HeartIcon,
    can: "Admin",
  },
];

// MENU: Permissões
const menu_geral = [
  { href: "/dashboard", label: "Home", icon: HomeIcon, can: "Medio" },
];

// MENU: EVENTOS
const menu_pessoas = [
  {
    href: "/evento-areas",
    label: "Áreas Eventos",
    icon: CalendarIcon,
    can: "Admin",
  },
  {
    href: "/evento-grupos",
    label: "Grupos Eventos",
    icon: CubeIcon,
    can: "Admin",
  },
  {
    href: "/evento-locals",
    label: "Locais Eventos",
    icon: ChartBarIcon,
    can: "Medio",
  },
  { href: "/eventos", label: "Eventos", icon: CalendarIcon, can: "Medio" },
  {
    href: "/eventos/view",
    label: "Eventos lista",
    icon: HeartIcon,
    can: "Medio",
  },
];

// MENU: Perfil do usuário
const menu_perfil = [
  {
    href: "/user/profile",
    label: "Tiago Bizze",
    icon: CalendarIcon,
    imageUrl:
      "https://pbs.twimg.com/profile_images/1333896976602193922/MtWztkxt_400x400.jpg",
    can: "Medio",
  },
];
</script>


<template>
  <fwb-sidebar>
<!--     <fwb-sidebar-logo name="Flowbite" logo="https://flowbite.com/docs/images/logo.svg" tag="router-link" />
 -->
    <fwb-sidebar-item>
      <template #icon>
        <svg
          class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 22 21"
        >
          <path
            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
          />
          <path
            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
          />
        </svg>
      </template>
      <template #default>Dashboard</template>
    </fwb-sidebar-item>

    <fwb-sidebar-dropdown-item>
      <template #icon>
        <svg
          class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 22 21"
        >
          <path
            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
          />
          <path
            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
          />
        </svg>
      </template>
      <template #trigger> E-commerce </template>
      <template #default>
        <fwb-sidebar-item class="pl-11"> Products </fwb-sidebar-item>
        <fwb-sidebar-item class="pl-11"> Sign In </fwb-sidebar-item>
        <fwb-sidebar-item class="pl-11"> Sign Up </fwb-sidebar-item>
      </template>
    </fwb-sidebar-dropdown-item>
  </fwb-sidebar>

  <!-- #### MENU: GERAL -->
  <div class="mb-10">
    <!-- Label do Grupo -->
    <h3 class="mx-2 mb-2 text-xs text-gray-400 uppercase tracking-widest">
      Geral
    </h3>

    <!-- Loop dos Links -->
    <div v-for="(item, index) in menu_geral" :key="index">
      <a
        :href="item.href"
        v-if="$page.props.auth.user.roles.includes(item.can)"
        class="flex items-center p-2 text-base text-gray-300 rounded-lg transition duration-75 hover:text-gray-50 hover:bg-gray-700 group"
      >
        <component
          :is="item.icon"
          class="h-5 w-5 text-gray-300 mr-2 group-hover:text-gray-50"
        />
        {{ item.label }}
      </a>
    </div>
  </div>

  <!-- #### MENU: PESSOAS -->
  <div class="mb-10">
    <!-- Label do Grupo -->
    <h3 class="mx-2 mb-2 text-xs text-gray-400 uppercase tracking-widest">
      Eventos
    </h3>

    <!-- Loop dos Links -->
    <div v-for="(item, index) in menu_pessoas" :key="index">
      <a
        :href="item.href"
        v-if="$page.props.auth.user.roles.includes(item.can)"
        class="flex items-center p-2 text-base text-gray-300 rounded-lg transition duration-75 hover:text-gray-50 hover:bg-gray-700 group"
      >
        <component
          :is="item.icon"
          class="h-5 w-5 text-gray-300 mr-2 group-hover:text-gray-50"
        />
        {{ item.label }}
      </a>
    </div>
  </div>

  <!-- #### MENU CONFIGURAÇÕES -->
  <div class="mb-10">
    <!-- Label do Grupo -->
    <h3 class="mx-2 mb-2 text-xs text-gray-400 uppercase tracking-widest">
      Sistema
    </h3>

    <!-- Loop dos Links -->
    <div v-for="(item, index) in menu_configs" :key="index">
      <a
        :href="item.href"
        v-if="$page.props.auth.user.roles.includes(item.can)"
        class="flex items-center p-2 text-base text-gray-300 rounded-lg transition duration-75 hover:text-gray-50 hover:bg-gray-700 group"
      >
        <component
          :is="item.icon"
          class="h-5 w-5 text-gray-300 mr-2 group-hover:text-gray-50"
        />
        {{ item.label }}
      </a>
    </div>
  </div>

  <!-- #### MENU PERFIL -->
  <div class="mb-10">
    <h3 class="mx-2 mb-2 text-xs text-gray-400 uppercase tracking-widest">
      Perfil
    </h3>
    <!-- Loop dos Links -->
    <div v-for="(item, index) in menu_perfil" :key="index">
      <a
        :href="item.href"
        v-if="$page.props.auth.user.roles.includes(item.can)"
        class="flex items-center p-2 text-base text-gray-300 rounded-lg transition duration-75 hover:text-gray-50 hover:bg-gray-700 group"
      >
        <img :src="item.imageUrl" alt="" class="w-7 h-7 rounded-full mr-2" />
        <!-- {{ item.label }} -->
        {{ $page.props.auth.user.name }}
      </a>
    </div>
  </div>
</template>

<style></style>