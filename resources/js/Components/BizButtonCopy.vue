<script setup>
import { DocumentDuplicateIcon } from "@heroicons/vue/solid";
const props = defineProps({
  label: {
    type: [String],
    default: "",
  },
});

</script>

<template>
  <!-- Botão/Ícone para Editar -->
  <button class="btn btn-success btn-square rounded-md btn-xs">
    <component :is="DocumentDuplicateIcon" class="h-4 w-4" />
  </button>
</template>