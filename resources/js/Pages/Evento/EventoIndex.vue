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

import { FwbModal } from 'flowbite-vue'
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

// Função para submeter o formulário de pesquisa.
function submit() {
  router.get(route("eventos.index"), form);
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

/**
 * Ação para formatar o 'grupo_id' recebido do controller.
 * Assim, se houver dados, através da função .map(number) transforma o
 * array que está chegando como string em number.
 */
onMounted(() => {
  if (props.filters.grupo_id) {
    let string = form.grupo_id;
    string = string.map(Number); // alternativa seria usar =>  string.replace(/["]/g, '');   dentro da chave coloco o que será modificado.
    form.grupo_id = string;
  }
  if (props.filters.local_id) {
    let string = form.local_id;
    string = string.map(Number); // alternativa seria usar =>  string.replace(/["]/g, '');   dentro da chave coloco o que será modificado.
    form.local_id = string;
  }
});
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
      <BizButtonCreate
        @click.prevent="actionAdd"
        label="Cadastrar"
        v-if="
          $page.props.auth.user.permissions.includes('eventos.create')
        "
      />
    </template>

    <!-- #### START: Conteúdo da Página #### -->
    <SectionPageTable>
      <!-- #### Header da Página -->
      <template #tabHeader>
        <div class="">
          <form @submit.prevent="submit()" class="flex gap-2">
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none"
              >
                <component :is="SearchIcon" class="h-5 w-5" />
              </div>
              <input
                type="search"
                v-model="form.search"
                class="py-1.5 text-sm rounded-md bg-gray-100 border-gray-300 hover:bg-gray-200 hover:border-gray-400 focus:border-blue-500 focus:ring-blue-500 pl-8"
                placeholder="Procurar"
              />
            </div>
            <BaseListbox
              v-model="form.grupo_id"
              :options="grupos"
              class="z-50 w-40"
              multiple
              placeholder="Filtrar grupo.."
            />
            <BaseListbox
              v-model="form.local_id"
              :options="locais"
              class="z-50 w-40"
              multiple
              placeholder="Filtrar local.."
            />
            <BaseListbox
              v-model="form.dia_mes"
              :options="meses"
              class="z-50 w-40"
              placeholder="Filtrar mês.."
            /> 
            <!-- Botão/Ícone para pesquisar -->
            <button class="btn rounded-md btn-sm">
              <component :is="ArrowRightIcon" class="h-4 w-4" />
            </button>
          </form>
        </div>
      </template>

      <!-- #### Header e Body da Tabela -->
      <template #tabBody>
        <table class="table table-compact">
          <thead class="text-sm uppercase text-gray-700 bg-stone-200">
            <tr>
              <th class="text-center w-10">#</th>
              <th
                class="hover:text-accent cursor-pointer"
                @click="sort('nome')"
              >
                <BizTheadOrder
                  :field="form.field"
                  coluna="nome"
                  :direction="form.direction"
                >
                  Nome
                </BizTheadOrder>
              </th>
              <th class="text-center">Dia</th>

              <th
                class="text-center hover:text-accent cursor-pointer"
                @click="sort('start_date')"
              >
                <BizTheadOrder
                  :field="form.field"
                  coluna="start_date"
                  :direction="form.direction"
                >
                  Data
                </BizTheadOrder>
              </th>

              <!-- <th class="text-center">Data</th> -->
              <th class="text-center">Hora</th>
              <th class="">Grupo</th>
              <th class="">Local</th>
              <th class="text-center">Áreas</th>
              <th class="text-center">Ação</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in dados.data"
              :key="item.id"
              class="hover:bg-gray-100"
            >
              <td class="border-b text-center w-10">{{ item.id }}</td>
              <td class="border-b ">{{ item.nome }}</td>
              <td class="border-b text-center">{{ item.dia_semana }}</td>
              <td class="border-b text-center">{{ item.start_date }}</td>
              <td class="border-b text-center">{{ item.start_time }}</td>
              <td class="border-b ">{{ item.to_grupo.nome }}</td>
              <td class="border-b ">{{ item.to_local.nome }}</td>
              <td class="border-b text-center space-x-1">
                <span v-for="area in item.areas"
                  :key="area.id"
                  class="badge badge-ghost">
                    {{ area.nome }}
                </span>
              </td>
              <td class="border-b space-x-1 w-24 text-center">
                <BizButtonEdit
                  @click.prevent="actionEdit(item.id)"
                  v-if="
                    $page.props.auth.user.permissions.includes(
                      'eventos.edit'
                    )
                  "
                />
                <BizButtonDelete
                  @click.prevent="showConfirmModal(item.id)"
                  v-if="
                    $page.props.auth.user.permissions.includes(
                      'eventos.destroy'
                    )
                  "
                />
              </td>
            </tr>
          </tbody>
        </table>
      </template>

      <!-- #### Footer da Tabela -->
      <template #tabFooter>
        <!-- Esquerda do Rodapé: Diversos -->
        <div class=""></div>
        <!-- Direita do Rodapé: Paginação -->
        <Pagination :pagination="dados" />
      </template>
    </SectionPageTable>

    <!-- #### END: Conteúdo da Página #### -->
  </AppLayout>

  <!-- #### MODAL: Caixa de confirmação -->
  <FwbModal size="md" v-if="isShowModal" @close="closeModal">
    <template #header>Confirma exclusão!</template>
    <template #body
      >Tem certeza que deseja excluir o registro nº '{{ registro_id }}'? Esta
      ação não poderá ser desfeita.</template
    >
    <template #footer>
      <div class="flex justify-center gap-5">
        <button
          @click="actionDelete(registro_id)"
          type="button"
          class="btn btn-sm btn-accent"
        >
          Sim
        </button>
        <button @click="closeModal" type="button" class="btn btn-sm">
          Não
        </button>
      </div>
    </template>
  </FwbModal>
</template>
