<script setup>
import { router, useForm, Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionPageForm from "@/Components/SectionPageForm.vue";

import BaseListbox from "@/Components/BizListBox.vue";
import BizInput from "@/Components/BizInput.vue";
import BizField from "@/Components/BizField.vue";
import BizButtonSave from "@/Components/BizButtonSave.vue";
import BizButtonCancel from "@/Components/BizButtonCancel.vue";

import Checkbox from "@/Components/Checkbox.vue";

import { vMaska } from "maska";

const props = defineProps({
  titulo: "",
  registro: Object,
  /*   list_est_civil: Object,
  list_sexos: Object,
  camp_gpos: Object,
  camp_sits: Object, */
});

const form = useForm({
  nome: props.registro.nome,
  notas: props.registro.notas,
  /*   valor: props.registro.valor,
  notif_email: Boolean(props.registro.notif_email),
  notif_whatsapp: Boolean(props.registro.notif_whatsapp),
  camp_sit_id: props.registro.camp_sit_id,
  camp_gpo_id: props.registro.camp_gpo_id,
  id: props.registro.id, */
});

/**
 * Função para submeter o formulário.
 * Persiste no BD.
 */
function submit() {
  form.put(route("evento-locals.update", props.registro.id));
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
            <div class="md:w-1/5">
              <BizField id="nome" label="Nome" :error="form.errors.nome">
                <BizInput
                  v-model="form.nome"
                  placeholder="Digitar um nome"
                  type="text"
                />
              </BizField>
            </div>
          </div>

          <div class="md:flex gap-2 mb-4">
            <!-- Campo Notas -->
            <div class="md:w-full">
              <BizField
                id="notas"
                label="Notas"
                :error="form.errors.notas"
              >
                <BizInput
                  v-model="form.notas"
                  placeholder="Digitar uma observação"
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