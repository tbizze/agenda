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
  valor: "",
  data_pgto: "",
  local: "",
  historico: "",
  pagador: "",
  cpf_cnpj_pagad: "",
  recebedor: "",
  cpf_cnpj_receb: "",
});

/**
 * Função para submeter o formulário.
 * Persiste no BD.
 */
function submit() {
  form.post(route("recibos.store"));
}

/**
 * Função para cancelar o cadastro.
 * Volta para a listagem.
 */
function cancelSave() {
  router.get(route("recibos.index"));
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
          <!-- LINHA 1 -->
          <div class="md:flex gap-2 mb-4">
            <!-- Campo Valor -->
            <div class="md:w-1/5">
              <BizField id="valor" label="Valor" :error="form.errors.valor">
                <BizInput
                  v-model="form.valor"
                  placeholder="Digitar um valor"
                  type="text"
                  v-maska data-maska="0,99" data-maska-tokens="0:\d:multiple|9:\d:optional"
                  
                />
              </BizField>
            </div>
            <!-- Campo Histórico -->
            <div class="md:w-4/5">
              <BizField id="historico" label="Descrição" :error="form.errors.historico">
                <BizInput
                  v-model="form.historico"
                  placeholder="Digitar uma descrição"
                  type="text"
                />
              </BizField>
            </div>
          </div>
          <!-- LINHA 2 -->
          <div class="md:flex gap-2 mb-4">
            <!-- Campo Pagador -->
            <div class="md:w-2/3">
              <BizField id="pagador" label="Pagador" :error="form.errors.pagador">
                <BizInput
                  v-model="form.pagador"
                  placeholder="Digitar nome do pagador"
                  type="text"
                />
              </BizField>
            </div>
            <!-- Campo CPF/CNPJ Pagador -->
            <div class="md:w-1/3">
              <BizField id="cpf_cnpj_pagad" label="CPF/CNPJ Pagador" :error="form.errors.cpf_cnpj_pagad">
                <BizInput
                  v-model="form.cpf_cnpj_pagad"
                  placeholder="Digitar um CPF/CNPJ"
                  type="text"
                  v-maska data-maska="['###.###.###-##','##.###.###/####-##']"
                />
              </BizField>
            </div>
          </div>
          <!-- LINHA 3 -->
          <div class="md:flex gap-2 mb-4">
            <!-- Campo Recebedor -->
            <div class="md:w-2/3">
              <BizField id="recebedor" label="Recebedor" :error="form.errors.recebedor">
                <BizInput
                  v-model="form.recebedor"
                  placeholder="Digitar nome do recebedor"
                  type="text"
                />
              </BizField>
            </div>
            <!-- Campo CPF/CNPJ Recebedor -->
            <div class="md:w-1/3">
              <BizField id="cpf_cnpj_receb" label="CPF/CNPJ Recebedor" :error="form.errors.cpf_cnpj_receb">
                <BizInput
                  v-model="form.cpf_cnpj_receb"
                  placeholder="Digitar um CPF/CNPJ"
                  type="text"
                  v-maska data-maska="['###.###.###-##','##.###.###/####-##']"
                />
              </BizField>
            </div>
          </div>
          <!-- LINHA 4 -->
          <div class="md:flex gap-2 mb-4">
            <!-- Campo Local -->
            <div class="md:w-4/5">
              <BizField id="local" label="Cidade" :error="form.errors.local">
                <BizInput
                  v-model="form.local"
                  placeholder="Digitar uma cidade"
                  type="text"
                />
              </BizField>
            </div>
            <!-- Campo Data -->
            <div class="md:w-1/5">
              <BizField id="data_pgto" label="Data" :error="form.errors.data">
                <BizInput
                  v-model="form.data_pgto"
                  placeholder="Digitar uma data"
                  type="text"
                  v-maska data-maska="##/##/####"
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