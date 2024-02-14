<script setup>
import { router, useForm, Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionPageForm from "@/Components/SectionPageForm.vue";

import BaseListbox from "@/Components/BizListBox.vue";
import BizInput from "@/Components/BizInput.vue";
import BizField from "@/Components/BizField.vue";
import BizButtonSave from "@/Components/BizButtonSave.vue";
import BizButtonCancel from "@/Components/BizButtonCancel.vue";


import { ref } from 'vue'
import { FwbRadio } from 'flowbite-vue'
const picked = ref()

import { vMaska } from "maska";

const props = defineProps({
  titulo: "",
  registro: Object,
  areas: Object,
  grupos: Object,
  locais: Object,
  evento_areas: Object,
});

const form = useForm({
  nome: props.registro.nome,
  notas: props.registro.notas,
  start_date: props.registro.start_date,
  start_time: props.registro.start_time,
  end_date: props.registro.end_date,
  end_time: props.registro.end_time,
  evento_grupo_id: props.registro.evento_grupo_id,
  evento_local_id: props.registro.evento_local_id,
  id: props.registro.id,
  evento_areas: props.evento_areas,
});

/**
 * Função para submeter o formulário.
 * Persiste no BD.
 */
function submit() {
  form.put(route("eventos.update", props.registro.id));
}

/**
 * Função para cancelar o cadastro.
 * Volta para a listagem.
 */
function cancelSave() {
  router.get(route("eventos.index"));
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

          <!-- LINHA 01 -->
          <div class="md:flex gap-2 mb-4">
            <!-- Campo Nome -->
            <div class="md:w-2/5">
              <BizField id="nome" label="Nome" :error="form.errors.nome">
                <BizInput
                  v-model="form.nome"
                  placeholder="Digitar um nome"
                  type="text"
                />
              </BizField>
            </div>
            <!-- Campo Notas -->
            <div class="md:w-3/5">
              <BizField id="notas" label="Notas" :error="form.errors.notas">
                <BizInput
                  v-model="form.notas"
                  placeholder="Digitar uma observação"
                  type="text"
                />
              </BizField>
            </div>
          </div>

          <!-- LINHA 02 -->
          <div class="md:flex gap-2 mb-4">
            <!-- Campo Data Início -->
            <div class="md:w-1/4">
              <BizField id="start_date" label="Data início" :error="form.errors.start_date">
                <BizInput
                  v-model="form.start_date"
                  placeholder="Digitar uma data"
                  type="text"
                  v-maska data-maska="##/##/####"
                />
              </BizField>
            </div>
            <!-- Campo Hora início -->
            <div class="md:w-1/4">
              <BizField id="start_time" label="Hora início" :error="form.errors.start_time">
                <BizInput
                  v-model="form.start_time"
                  placeholder="Digitar uma hora"
                  type="text"
                  v-maska data-maska="##:##"
                />
              </BizField>
            </div>
            <!-- Campo Data fim -->
            <div class="md:w-1/4">
              <BizField id="end_date" label="Data fim" :error="form.errors.end_date">
                <BizInput
                  v-model="form.end_date"
                  placeholder="Digitar uma data"
                  type="text"
                  v-maska data-maska="##/##/####"
                />
              </BizField>
            </div>
            <!-- Campo Hora fim -->
            <div class="md:w-1/4">
              <BizField id="end_time" label="Hora fim" :error="form.errors.end_time">
                <BizInput
                  v-model="form.end_time"
                  placeholder="Digitar uma hora"
                  type="text"
                  v-maska data-maska="##:##"
                />
              </BizField>
            </div>
            
          </div>

          <!-- Linha divisora -->
          <div class="border-b mb-4"></div>

          <!-- LINHA 03 -->
          <!-- Lista com as Áreas -->
          <div class="md:flex gap-2 mb-6">
            <!-- Label -->
            <span class="pr-1 text-right text-sm w-1/5">Atribuir Áreas:</span>
            <!-- Checkbox com as funções -->
            <div class="md:w-4/5 flex flex-wrap gap-3 items-center bg-gray-100 p-2 rounded-md">
              <div v-for="area in areas" :key="area.id">
                <input
                  :id="'area_' + area.id"
                  type="checkbox"
                  v-model="form.evento_areas"
                  :value="area.id"
                  class="w-5 h-5 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300"
                />
                <label :for="'area_' + area.id" class="pl-1.5 text-sm">{{
                  area.nome
                }}</label>
              </div>
            </div>
          </div>

          <!-- Linha divisora -->
          <div class="border-b mb-4"></div>

          <!-- LINHA 04 -->
          <!-- Lista com os Grupos -->
          <div class="md:flex gap-2 mb-6">
            <!-- Label -->
            <span class="pr-1 text-right text-sm w-1/5">Selecionar Grupo:</span>
            <!-- Checkbox com os grupos -->
            <div class="md:w-4/5 flex flex-wrap gap-3 items-center bg-gray-100 p-2 rounded-md">
               
              <div v-for="grupo in grupos" :key="grupo.id">
                <fwb-radio v-model="form.evento_grupo_id" name="grupo" :label="grupo.nome" :value="grupo.id" />
              </div>
            </div>
          </div>

          <!-- Linha divisora -->
          <div class="border-b mb-4"></div>

          <!-- LINHA 05 -->
          <!-- Lista com os Locais -->
          <div class="md:flex gap-2 mb-6">
            <!-- Label -->
            <span class="pr-1 text-right text-sm w-1/5">Selecionar Local:</span>
            <!-- Checkbox com os locais -->
            <div class="md:w-4/5 flex flex-wrap gap-3 items-center bg-gray-100 p-2 rounded-md">
               
              <div v-for="local in locais" :key="local.id">
                <fwb-radio v-model="form.evento_local_id" name="local" :label="local.nome" :value="local.id" />
              </div>
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