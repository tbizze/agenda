<script setup>
import { router, useForm, Head, Link } from "@inertiajs/vue3";
import { watch, onMounted, onUpdated, onUnmounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionPageTable from "@/Components/SectionPageTable.vue";
import Pagination from "@/Components/Pagination.vue";

import BizPageTitle from "../../Components/BizPageTitle.vue";
import BizButtonCreate from "../../Components/BizButtonCreate.vue";
import BizButtonEdit from "../../Components/BizButtonEdit.vue";
import BizButtonDelete from "../../Components/BizButtonDelete.vue";
import BizTheadOrder from "../../Components/BizTheadOrder.vue";
import BaseListbox from "@/Components/BizListBox.vue";

import { SearchIcon, ArrowRightIcon } from "@heroicons/vue/solid";

import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

import { ref } from "vue";

const props = defineProps({
  titulo: "",
  dados: Object,
  filters: Object,
  grupos: Object,
  locais: Object,
  meses: Object,
});

const form = useForm({
  // grupo_id: [],
  //camp_valor: props.filters.camp_valor, */
  local_id: props.filters.local_id,
  grupo_id: props.filters.grupo_id,
  dia_mes: props.filters.dia_mes,
  search: props.filters.search,
  field: props.filters.field,
  direction: props.filters.direction,
});

const calendarOptions = {
  plugins: [
    dayGridPlugin,
    timeGridPlugin,
    interactionPlugin, // needed for dateClick
  ],
  initialView: "dayGridMonth",
  events: props.dados,
  /* events: [
    {
      title: 'Evento 1', // a property!
      start: '2024-02-01', // a property!
      end: '2024-02-05' // a property! ** see important note below about 'end' **
    },
    {
      title: 'Evento 2', // a property!
      start: '2024-02-15 00:00:00', // a property!
      allDay: true,
      //end: '2024-02-05' // a property! ** see important note below about 'end' **
    }
  ], */

  headerToolbar: {
    left: "prev,next today",
    center: "title",
    right: "dayGridMonth,timeGridWeek,timeGridDay",
  },
  locale: "pt-br",
  timeZone: 'America/Sao_Paulo', //'America/New_York'
  //editable: true, // permite arrastar eventos
};

// Função para submeter o formulário de pesquisa.
function submit() {
  router.get(route("eventos.view"), form);
}
/**
 * Função para abrir formulário de cadastro.
 */
function actionAdd() {
  router.get(route("eventos.create"));
}
/**
 * Função para editar um registro.
 * Como parâmetro recebe o ID.
 */
function actionEdit(id) {
  router.get(route("eventos.edit", id));
}
/**
 * Função para deletar um registro.
 * Como parâmetro recebe o ID.
 * Após requisitar ao controller, fecha modal.
 */
function actionDelete(id) {
  router.delete(route("eventos.destroy", id)); // Requisita ao controller a exclusão.
  isShowModal.value = false; // Fecha a modal.
}

// Função para realizar o OrderBy.
function sort(field) {
  form.field = field;
  form.direction = form.direction === "asc" ? "desc" : "asc";
  submit();
}

/**
 * MODAL: para confirmar exclusão de registro
 * Variáveis para usar Modal de confirmação.
 */
const isShowModal = ref(false);
const registro_id = ref(0);

// Função para fechar o modal.
function closeModal() {
  isShowModal.value = false;
}
/**
 * Função para abrir o modal.
 * Coloca o ID do registro na variável, para que seja possível ao confirmar, a exclusão.
 */
function showConfirmModal(vl) {
  isShowModal.value = true; // Exibe o modal.
  registro_id.value = vl; // Coloca o ID na variável.
}
</script>

<template>
  <!-- Carrega o Layout da Aplicação com "Logo e TopMenu, com botões Login/Logout..." -->
  <Head :title="$props.titulo" />
  <AppLayout :title="$props.titulo">
    <!-- #### SEÇÃO: Título da Página -->
    <template #header>
      <!-- Título -->
      <BizPageTitle>{{ $props.titulo }}</BizPageTitle>

      <!-- Botão Novo -->
      <!-- <BizButtonCreate
        @click.prevent="actionAdd"
        label="Cadastrar"
        v-if="$page.props.auth.user.permissions.includes('eventos.create')"
      /> -->
    </template>

    <!-- #### START: Conteúdo da Página #### -->
    <SectionPageTable>
      <!-- #### Header da Página -->
      

      <!-- #### Header e Body da Tabela -->
      <template #tabBody>
        <div class="p-4">
          <FullCalendar :options="calendarOptions" />
          <!-- <FullCalendar defaultView="dayGridMonth" :plugins="calendarPlugins" /> -->
        </div>
      </template>
    </SectionPageTable>

    <!-- #### END: Conteúdo da Página #### -->
  </AppLayout>
</template>
