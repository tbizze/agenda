<script setup>
import MenuItem from "@/Layouts/NavbarMenuItem.vue";

import {
  HomeIcon,
  CalendarIcon,
  AdjustmentsIcon,
  ArrowNarrowRightIcon,
  MinusSmIcon,
} from "@heroicons/vue/outline";

const menuTree = [
  {
    label: "Home",
    icon: HomeIcon,
    href: "dashboard",
    urlActive: "/dashboard",
  },
  {
    label: "Eventos",
    icon: CalendarIcon,
    children: [
      {
        label: "Grupos",
        icon: MinusSmIcon,
        href: "evento-grupos.index",
        urlActive: "/evento-grupos",
      },
      {
        label: "Locais",
        icon: MinusSmIcon,
        href: "evento-locals.index",
        urlActive: "/evento-locals",
      },
      {
        label: "Eventos",
        icon: MinusSmIcon,
        children: [
          {
            label: "Calendário",
            href: "eventos.calendar",
            urlActive: "/eventos/c",
          },
          {
            label: "Lista",
            href: "eventos.view",
            urlActive: "/eventos/v",
          },
        ],
      },
    ],
  },
  {
    label: "Configurações",
    icon: AdjustmentsIcon,
    children: [
      {
        label: "Funções",
      },
      {
        label: "Permissões",
      },
      {
        label: "Usuários",
      },
    ],
  },
];
</script>


<template>
  <!-- #### MENU: GERAL -->
  <div class="text-white">
    <MenuItem
      v-for="(item, index) in menuTree"
      :key="index"
      :label="item.label"
      :icon="item.icon"
      :href="item.href"
      :urlActive="item.urlActive"
      :depth="0"
      :data="item.children"
    />
  </div>
</template>

<style></style>