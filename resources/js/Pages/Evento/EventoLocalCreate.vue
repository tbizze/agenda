<script setup>
import { router, useForm, Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionPageForm from "@/Components/SectionPageForm.vue";

import BaseListbox from "@/Components/BizListBox.vue";
import BizInput from "@/Components/BizInput.vue";
import BizField from "@/Components/BizField.vue";
import BizButtonSave from "@/Components/BizButtonSave.vue";
import BizButtonCancel from "@/Components/BizButtonCancel.vue";

import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";

import { vMaska } from "maska";

const props = defineProps({
  titulo: "",
});

const form = useForm({
  nome: "",
  notas: "",
});

/**
 * Função para submeter o formulário.
 * Persiste no BD.
 */
function submit() {
  form.post(route("evento-locals.store"));
}

/**
 * Função para cancelar o cadastro.
 * Volta para a listagem.
 */
function cancelSave() {
  router.get(route("evento-locals.index"));
}
</script>
<template>
  <!-- Carrega o Layout da Aplicação com "Logo e TopMenu, com botões Login/Logout..." -->
  <Head :title="$props.titulo" />
  <AppLayout :title="props.titulo">
    <!-- #### SEÇÃO: Título da Página -->
    <template #header>
      <h2 class="font-semibold text-3xl">
        {{ titulo }}
      </h2>
    </template>

    <!-- SESSÃO: Corpo do Formulário -->
    <SectionPageForm>
      <template #formBody>
        <form @submit.prevent="submit()">
          <div class="md:flex gap-2 mb-4">
            <!-- Campo Nome -->
            <div class="md:w-2/5">
              <BizField id="nome" label="Nome" :error="form.errors.nome">
                <BizInput
                  v-model="form.nome"
                  placeholder="Registre um nome"
                  type="text"
                />
              </BizField>
            </div>
            
          </div>
          <div class="md:flex gap-2 mb-4">
            <!-- Campo Notas -->
            <div class="md:w-full">
              <BizField id="notas" label="Notas" :error="form.errors.notas">
                <BizInput
                  v-model="form.notas"
                  placeholder="Registre uma observação"
                  type="text"
                />
              </BizField>
            </div>
          </div>
        </form>
      </template>

      <!-- SESSÃO: Rodapé do Formulário -->
      <template #formFooter>
        <!-- BOTÕES -->
        <div class="md:flex gap-2">
          <BizButtonSave @click.prevent="submit" label="Salvar" />
          <BizButtonCancel @click.prevent="cancelSave" label="Cancelar" />
        </div>
      </template>
    </SectionPageForm>
  </AppLayout>
</template>