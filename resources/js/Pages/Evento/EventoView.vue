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

import { FwbModal } from "flowbite-vue";
import { ref } from "vue";

const props = defineProps({
  titulo: "",
  dados: Object,
  filters: Object,
  grupos: Object,
  locais: Object,
  areas: Object,
  meses: Object,
});

const form = useForm({
  // grupo_id: [],
  //camp_valor: props.filters.camp_valor, */
  local_id: props.filters.local_id,
  grupo_id: props.filters.grupo_id,
  area_id: props.filters.area_id,
  dia_mes: props.filters.dia_mes,
  search: props.filters.search,
  field: props.filters.field,
  direction: props.filters.direction,
});

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
const link_pdf = ref("pdf/1");
function actionPdf() {
  if (!form.dia_mes) {
    //router.get(route("eventos.pdf",form.dia_mes));
    link_pdf.value = "pdf/1";
  } else {
    link_pdf.value = "pdf/" + form.dia_mes;
    //console.log('ID:',link_pdf.value);
  }
}
//const var_link = ref(var_mes + var_area);
const var_mes = ref(null);
const var_area = ref(null);
function openLinkNewTab() {
  if (form.dia_mes) {
    var_mes.value = form.dia_mes;
  }
  if (form.area_id) {
    var_area.value = form.area_id;
  }

  if (!form.dia_mes) {
    const var_link = "pdf/";
    window.open(var_link, '_blank');
  }else if(form.dia_mes && !form.area_id){
    const var_link = "pdf/" + var_mes.value;
    window.open(var_link, '_blank');
  }else if(form.dia_mes && form.area_id) {
    const var_link = "pdf/" + var_mes.value +'/'+ var_area.value;
    window.open(var_link, '_blank');
  }
}
/* import { VueRouter  } from "vue-router";
//const router = useRouter();
let route = router.resolve({ name:'/link/to/page' , query: { param: 'param1' } });
window.open(route.fullPath, "_blank"); */
/* const link = document.createElement('a')
  link.href = url
  link.target = newTab ? '_blank' : ''
  if (newTab) link.rel = 'noopener noreferrer' // IMPORTANT to add this
  link.click() */
/* import { useRouter } from '@inertiajs/vue3'
const routers = useRouter();
const routeData = routers.resolve({name: 'routeName', query: {data: "someData"}});
window.open(routeData.href, '_blank'); */

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
  if (props.filters.area_id) {
    let string = form.area_id;
    string = string.map(Number); // alternativa seria usar =>  string.replace(/["]/g, '');   dentro da chave coloco o que será modificado.
    form.area_id = string;
  }
});

/* const parentItem = ref();

const items = props.dados.data;

items.forEach((item, index) => {
   
  if (parentItem.value == item.numero_dia ) {
    item.var_dia = false;
    props.dados.data.test = '';
    //console.log(index +'=> ','é igual',parentItem.value,item.numero_dia)
    //console.log(index +'=> ','é igual', item.var_dia ,item.numero_dia)
  } else {
    item.var_dia = item.numero_dia;
    props.dados.data.test = item.numero_dia;
    //console.log(index +'=> ','não é igual',parentItem.value,item.numero_dia)
    //console.log(index +'=> ','não é igual',item.var_dia,item.numero_dia)
  }
  
  //console.log(index +'=> ', '|| DATA_ACIMA: ' + parentItem.value, '|| DATA: ' + item.numero_dia )
  //console.log(index +'=> ', item.var_dia, item.numero_dia )
  //console.log(item.nome)
  parentItem.value = item.numero_dia;
}) */
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
        v-if="$page.props.auth.user.permissions.includes('eventos.create')"
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
              v-model="form.area_id"
              :options="areas"
              class="z-50 w-40"
              multiple
              placeholder="Filtrar área.."
            />
            <BaseListbox
              v-model="form.dia_mes"
              :options="meses"
              class="z-50 w-40"
              placeholder="Filtrar mês.."
              @click="actionPdf()"
            />
            <!-- Botão/Ícone para pesquisar -->
            <button class="btn rounded-md btn-sm">
              <component :is="ArrowRightIcon" class="h-4 w-4" />
            </button>
            <!-- <button class="btn rounded-md btn-sm" @click.prevent="actionPdf()">
              PDF
            </button> -->
            <!-- <a class="btn rounded-md btn-sm" :href="link_pdf" target="_blank">PDF</a> -->
            <a class="btn rounded-md btn-sm" href="javascript:void(0)" @click="openLinkNewTab()">PDF</a>
            
          </form>
        </div>
      </template>

      <!-- #### Header e Body da Tabela -->
      <template #tabBody>
        <table class="table">
          <thead class="text-sm uppercase text-gray-700 bg-stone-200">
            <tr>
              <th class="p-2">Dia</th>
              <th class="p-2"></th>
              <th class="p-2">Hora</th>
              <th class="p-2">Evento</th>
              <th class="p-2">Grupo</th>
              <th class="p-2">Local</th>
              <th class="p-2">Áreas</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in dados.data"
              :key="item.id"
              class="hover:bg-gray-100"
            >
              <td class="border-b w-7 p-2">{{ item.numero_dia }}</td>
              <!-- <td class="border-b w-7 p-2" v-if="item.var_dia" >{{ item.numero_dia }} </td>
              <td class="border-b w-7 p-2" v-else >  </td> -->

              <td class="border-b w-7 p-2">{{ item.dia_semana }}</td>
              <!-- <td class="border-b w-7 p-2 border-r" v-if="item.var_dia" >{{ item.dia_semana }}</td>
              <td class="border-b w-7 p-2 border-r" v-else ></td> -->

              <td class="border-b w-7 p-2 border-r">{{ item.start_time }}</td>
              <td class="border-b p-2 border-r">{{ item.nome }}</td>
              <td class="border-b p-2 border-r">{{ item.to_grupo.nome }}</td>
              <td class="border-b p-2 border-r">{{ item.to_local.nome }}</td>
              <td class="border-b p-2 space-x-1">
                <span
                  v-for="area in item.areas"
                  :key="area.id"
                  class="badge badge-ghost"
                >
                  {{ area.nome }}
                </span>
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
