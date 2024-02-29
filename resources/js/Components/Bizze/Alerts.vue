<!-- CRÉDITOS:
     https://www.youtube.com/watch?v=amGhwZPgemY
     Canal => cdruc
-->
<script setup>
import { ref  } from "vue";
import { router,usePage } from "@inertiajs/vue3";
import Alert from "@/Components/Bizze/Alert.vue";

const showAlert = ref(true);

const page = usePage();
const info = ref([
    /* {message: 'Registro salvo com sucesso.'}, */
])
const success = ref([
    /* {message: 'Registro salvo com sucesso.'}, */
])
const warning = ref([
    /* {message: 'Registro salvo com sucesso.'}, */
])
const danger = ref([
    /* {message: 'Registro salvo com sucesso.'}, */
])


// Ao terminar a renderização, verifica se há mensagens de alerta.
router.on('finish', ()=>{
    // Se há mensagem de sucesso, coloca a mensagem na variável 'success'.
    if (page.props.flash.info){
        info.value.unshift({
            message: page.props.flash.success
        });
    }
    // Se há mensagem de sucesso, coloca a mensagem na variável 'success'.
    if (page.props.flash.success){
        success.value.unshift({
            message: page.props.flash.success
        });
    }
    // Se há mensagem de alerta, coloca a mensagem na variável 'warning'.
    if (page.props.flash.warning){
        warning.value.unshift({
            message: page.props.flash.warning
        });
    }
    // Se há mensagem de erro, coloca a mensagem na variável 'danger'.
    if (page.props.flash.danger){
        danger.value.unshift({
            message: page.props.flash.danger
        });
    }
})

</script>
<template>
  <div class="fixed top-8 right-8 z-50 space-y-4 max-w-sm">
    <Alert 
      v-for="(item, index) in info"
      :key="index"
      title="Caixa de alerta!"
      :show="showAlert" 
      :on-dismiss="() => showAlert = false" >
      {{ item.message }}
    </Alert>

    <Alert 
      v-for="(item, index) in success"
      :key="index"
      intent="success" 
      title="Caixa de alerta!" 
      :show="showAlert" 
      :on-dismiss="() => showAlert = false" >
      {{ item.message }}
    </Alert>

    <Alert 
      v-for="(item, index) in warning"
      :key="index"
      intent="warning" 
      title="Caixa de alerta!" 
      :show="showAlert" 
      :on-dismiss="() => showAlert = false" >
      {{ item.message }}
    </Alert>

    <Alert 
      v-for="(item, index) in danger"
      :key="index"
      intent="danger" 
      title="Caixa de alerta!" 
      :show="showAlert" 
      :on-dismiss="() => showAlert = false" >
      {{ item.message }}
    </Alert>

    
  </div>
</template>