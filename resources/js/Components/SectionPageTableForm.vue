<script setup>
import { Link } from "@inertiajs/vue3";
import { computed, useSlots } from "vue";

defineEmits(["submitted"]);

// Checa quais slots foram definidos, retornando true para eles. Assim posso usar condições para carregar.
const slots = useSlots();

const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
  <!-- #### SEÇÃO: Corpo da Página -->
  <div class="pb-12">
    <div class="max-w-7xl mx-auto py-1 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
        <div class="col-span-2">
          <!-- Abre uma quadro, c/ sobras... p/ o a tabela: rótulos, conteúdo, e rodapé da tabela -->
          <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
            <div class="flex flex-col itens-center pt-6 sm:pt-0">
              <!-- INSERT: 
                Cabeçalho e Corpo da Tabela -->
              <slot name="tabBody" />

              <!-- INSERT: 
                Rodapé [Totais, Paginação... -->
              <div
                v-if="slots.tabFooter"
                class="flex items-center justify-between space-x-3 px-2 py-2"
              >
                <slot name="tabFooter" />
              </div>
              <!-- #### END #### -->
              <!-- Conteúdo da Página -->
            </div>
          </div>
        </div>
        <div class="">
          <!-- Abre uma quadro, c/ sobras... p/ o a tabela: rótulos, conteúdo, e rodapé da tabela -->
          <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
            <div class="flex flex-col itens-center pt-6 sm:pt-0">
              <!-- INSERT: 
                Cabeçalho e Corpo da Tabela -->
              <slot name="formHeader" />

              <!-- INSERT: 
                Rodapé [Totais, Paginação... -->
              <div
                v-if="slots.formContent"
                class="flex items-center justify-between space-x-3 px-2 py-2"
              >
                <slot name="formContent" />
              </div>
              <!-- #### END #### -->
              <!-- Conteúdo da Página -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
