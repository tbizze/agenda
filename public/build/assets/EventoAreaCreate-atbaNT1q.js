import{T as c,o as v,e as b,b as e,u as t,w as l,F as x,Z as g,a,t as V,i as n,O as $}from"./app-u767hGP_.js";import{_ as h}from"./AppLayout-DMg8vL_4.js";import{_ as w}from"./SectionPageForm-HscQ3mUT.js";import{_ as d,a as u}from"./BizField-I8ZmPO9u.js";import{_ as C,a as k}from"./BizButtonCancel-rlNJxv8d.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const y={class:"font-semibold text-3xl"},B={class:"md:flex gap-2 mb-4"},N={class:"md:w-2/5"},S={class:"md:flex gap-2 mb-4"},F={class:"md:w-full"},E={class:"md:flex gap-2"},T={__name:"EventoAreaCreate",props:{titulo:""},setup(i){const f=i,o=c({nome:"",notas:""});function m(){o.post(route("evento-areas.store"))}function _(){$.get(route("evento-areas.index"))}return(p,s)=>(v(),b(x,null,[e(t(g),{title:p.$props.titulo},null,8,["title"]),e(h,{title:f.titulo},{header:l(()=>[a("h2",y,V(i.titulo),1)]),default:l(()=>[e(w,null,{formBody:l(()=>[a("form",{onSubmit:s[2]||(s[2]=n(r=>m(),["prevent"]))},[a("div",B,[a("div",N,[e(d,{id:"nome",label:"Nome",error:t(o).errors.nome},{default:l(()=>[e(u,{modelValue:t(o).nome,"onUpdate:modelValue":s[0]||(s[0]=r=>t(o).nome=r),placeholder:"Registre um nome",type:"text"},null,8,["modelValue"])]),_:1},8,["error"])])]),a("div",S,[a("div",F,[e(d,{id:"notas",label:"Notas",error:t(o).errors.notas},{default:l(()=>[e(u,{modelValue:t(o).notas,"onUpdate:modelValue":s[1]||(s[1]=r=>t(o).notas=r),placeholder:"Registre uma observação",type:"text"},null,8,["modelValue"])]),_:1},8,["error"])])])],32)]),formFooter:l(()=>[a("div",E,[e(C,{onClick:n(m,["prevent"]),label:"Salvar"}),e(k,{onClick:n(_,["prevent"]),label:"Cancelar"})])]),_:1})]),_:1},8,["title"])],64))}};export{T as default};
