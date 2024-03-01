import{d as k,T as U,o as i,e as n,b as r,u as e,w as d,F as v,Z as D,a,t as V,j as c,h as g,i as b,v as $,O as j}from"./app-qWYcPTlk.js";import{_ as O,U as h}from"./AppLayout-bkEbNcv0.js";import{_ as S}from"./SectionPageForm-p4AfYsxk.js";import{_ as m,a as u}from"./BizField-leEjly3o.js";import{_ as C,a as B}from"./BizButtonCancel-V9YgcUiA.js";import{j as f}from"./maska-32C2qJWU.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const N={class:"font-semibold text-3xl"},E={class:"md:flex gap-2 mb-4"},F={class:"md:w-2/5"},H={class:"md:w-3/5"},L={class:"md:flex gap-2 mb-4"},M={class:"md:w-1/4"},A={class:"md:w-1/4"},G={class:"md:w-1/4"},T={class:"md:w-1/4"},Z=a("div",{class:"border-b mb-4"},null,-1),q={class:"md:flex gap-2 mb-6"},z=a("span",{class:"pr-1 text-right text-sm w-1/5"},"Selecionar Grupo:",-1),I={class:"md:w-4/5 flex flex-wrap gap-3 items-center bg-gray-100 p-2 rounded-md"},J=a("div",{class:"border-b mb-4"},null,-1),K={class:"md:flex gap-2 mb-6"},P=a("span",{class:"pr-1 text-right text-sm w-1/5"},"Selecionar Local:",-1),Q={class:"md:w-4/5 flex flex-wrap gap-3 items-center bg-gray-100 p-2 rounded-md"},R=a("div",{class:"border-b mb-4"},null,-1),W={class:"md:flex gap-2 mb-6"},X=a("span",{class:"pr-1 text-right text-sm w-1/5"},"Atribuir Áreas:",-1),Y={class:"md:w-4/5 flex flex-wrap gap-3 items-center bg-gray-100 p-2 rounded-md"},ee=["id","value"],te=["for"],oe={class:"md:flex gap-2"},me={__name:"EventoEdit",props:{titulo:"",registro:Object,areas:Object,grupos:Object,locais:Object,evento_areas:Object},setup(_){k();const s=_,t=U({nome:s.registro.nome,notas:s.registro.notas,start_date:s.registro.start_date,start_time:s.registro.start_time,end_date:s.registro.end_date,end_time:s.registro.end_time,evento_grupo_id:s.registro.evento_grupo_id,evento_local_id:s.registro.evento_local_id,id:s.registro.id,evento_areas:s.evento_areas});function x(){t.id?t.put(route("eventos.update",s.registro.id)):t.post(route("eventos.store"))}function w(){j.get(route("eventos.index"))}return(y,l)=>(i(),n(v,null,[r(e(D),{title:y.$props.titulo},null,8,["title"]),r(O,{title:s.titulo},{header:d(()=>[a("h2",N,V(_.titulo),1)]),default:d(()=>[r(S,null,{formBody:d(()=>[a("form",{onSubmit:l[9]||(l[9]=b(o=>x(),["prevent"]))},[a("div",E,[a("div",F,[r(m,{id:"nome",label:"Nome",error:e(t).errors.nome},{default:d(()=>[r(u,{modelValue:e(t).nome,"onUpdate:modelValue":l[0]||(l[0]=o=>e(t).nome=o),placeholder:"Digitar um nome",type:"text"},null,8,["modelValue"])]),_:1},8,["error"])]),a("div",H,[r(m,{id:"notas",label:"Notas",error:e(t).errors.notas},{default:d(()=>[r(u,{modelValue:e(t).notas,"onUpdate:modelValue":l[1]||(l[1]=o=>e(t).notas=o),placeholder:"Digitar uma observação",type:"text"},null,8,["modelValue"])]),_:1},8,["error"])])]),a("div",L,[a("div",M,[r(m,{id:"start_date",label:"Data início",error:e(t).errors.start_date},{default:d(()=>[c(r(u,{modelValue:e(t).start_date,"onUpdate:modelValue":l[2]||(l[2]=o=>e(t).start_date=o),placeholder:"Digitar uma data",type:"text","data-maska":"##/##/####"},null,8,["modelValue"]),[[e(f)]])]),_:1},8,["error"])]),a("div",A,[r(m,{id:"start_time",label:"Hora início",error:e(t).errors.start_time},{default:d(()=>[c(r(u,{modelValue:e(t).start_time,"onUpdate:modelValue":l[3]||(l[3]=o=>e(t).start_time=o),placeholder:"Digitar uma hora",type:"text","data-maska":"##:##"},null,8,["modelValue"]),[[e(f)]])]),_:1},8,["error"])]),a("div",G,[r(m,{id:"end_date",label:"Data fim",error:e(t).errors.end_date},{default:d(()=>[c(r(u,{modelValue:e(t).end_date,"onUpdate:modelValue":l[4]||(l[4]=o=>e(t).end_date=o),placeholder:"Digitar uma data",type:"text","data-maska":"##/##/####"},null,8,["modelValue"]),[[e(f)]])]),_:1},8,["error"])]),a("div",T,[r(m,{id:"end_time",label:"Hora fim",error:e(t).errors.end_time},{default:d(()=>[c(r(u,{modelValue:e(t).end_time,"onUpdate:modelValue":l[5]||(l[5]=o=>e(t).end_time=o),placeholder:"Digitar uma hora",type:"text","data-maska":"##:##"},null,8,["modelValue"]),[[e(f)]])]),_:1},8,["error"])])]),Z,a("div",q,[z,a("div",I,[(i(!0),n(v,null,g(_.grupos,o=>(i(),n("div",{key:o.id},[r(e(h),{modelValue:e(t).evento_grupo_id,"onUpdate:modelValue":l[6]||(l[6]=p=>e(t).evento_grupo_id=p),name:"grupo",label:o.nome,value:o.id},null,8,["modelValue","label","value"])]))),128))])]),J,a("div",K,[P,a("div",Q,[(i(!0),n(v,null,g(_.locais,o=>(i(),n("div",{key:o.id},[r(e(h),{modelValue:e(t).evento_local_id,"onUpdate:modelValue":l[7]||(l[7]=p=>e(t).evento_local_id=p),name:"local",label:o.nome,value:o.id},null,8,["modelValue","label","value"])]))),128))])]),R,a("div",W,[X,a("div",Y,[(i(!0),n(v,null,g(_.areas,o=>(i(),n("div",{key:o.id},[c(a("input",{id:"area_"+o.id,type:"checkbox","onUpdate:modelValue":l[8]||(l[8]=p=>e(t).evento_areas=p),value:o.id,class:"w-5 h-5 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300"},null,8,ee),[[$,e(t).evento_areas]]),a("label",{for:"area_"+o.id,class:"pl-1.5 text-sm"},V(o.nome),9,te)]))),128))])])],32)]),formFooter:d(()=>[a("div",oe,[r(C,{onClick:b(x,["prevent"]),label:"Salvar"}),r(B,{onClick:b(w,["prevent"]),label:"Cancelar"})])]),_:1})]),_:1},8,["title"])],64))}};export{me as default};