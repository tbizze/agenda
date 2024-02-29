import{T as V,d as k,x as D,o as n,e as h,b as l,u as i,w as a,c as d,f,F as x,Z as E,g as m,t as u,i as _,a as t,k as C,j as O,l as P,h as S,O as b}from"./app-u767hGP_.js";import{_ as z,p as F}from"./AppLayout-DMg8vL_4.js";import{B as A,_ as q}from"./BizPageTitle-MZ51WRPc.js";import{_ as G,r as H,a as I,P as L}from"./BizButtonCreate-dqJY3JQZ.js";import{_ as U,a as Z}from"./BizTheadOrder-B6xZx7wZ.js";import{_ as J}from"./BizButtonDelete-lpGnC-RO.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const K={class:""},Q={class:"relative"},R={class:"absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none"},W={class:"btn rounded-md btn-sm"},X={class:"table table-compact"},Y={class:"text-sm uppercase text-gray-700 bg-stone-200"},ee=t("th",{class:"text-center w-10"},"#",-1),te=t("th",{class:""},"Notas",-1),se=t("th",{class:"text-center"},"Ação",-1),oe={class:"border-b text-center w-10"},ae={class:"border-b"},ne={class:"border-b"},re={class:"border-b space-x-1 w-24 text-center"},ie=t("div",{class:""},null,-1),le={class:"flex justify-center gap-5"},be={__name:"EventoGrupoIndex",props:{titulo:"",dados:Object,filters:Object},setup(g){const c=g,s=V({search:c.filters.search,field:c.filters.field,direction:c.filters.direction});function y(){b.get(route("evento-grupos.index"),s)}function w(){b.get(route("evento-grupos.create"))}function N(e){b.get(route("evento-grupos.edit",e))}function B(e){b.delete(route("evento-grupos.destroy",e)),p.value=!1}function M(e){s.field=e,s.direction=s.direction==="asc"?"desc":"asc",y()}const p=k(!1),v=k(0);function $(){p.value=!1}function j(e){p.value=!0,v.value=e}return D(()=>{if(c.filters.camp_gpo_id){let e=s.camp_gpo_id;e=e.map(Number),s.camp_gpo_id=e}if(c.filters.camp_sit_id){let e=s.camp_sit_id;e=e.map(Number),s.camp_sit_id=e}}),(e,r)=>(n(),h(x,null,[l(i(E),{title:e.$props.titulo},null,8,["title"]),l(z,{title:e.$props.titulo},{header:a(()=>[l(A,null,{default:a(()=>[m(u(e.$props.titulo),1)]),_:1}),e.$page.props.auth.user.permissions.includes("evento-grupos.create")?(n(),d(G,{key:0,onClick:_(w,["prevent"]),label:"Cadastrar"})):f("",!0)]),default:a(()=>[l(q,null,{tabHeader:a(()=>[t("div",K,[t("form",{onSubmit:r[1]||(r[1]=_(o=>y(),["prevent"])),class:"flex gap-2"},[t("div",Q,[t("div",R,[(n(),d(C(i(H)),{class:"h-5 w-5"}))]),O(t("input",{type:"search","onUpdate:modelValue":r[0]||(r[0]=o=>i(s).search=o),class:"py-1.5 text-sm rounded-md bg-gray-100 border-gray-300 hover:bg-gray-200 hover:border-gray-400 focus:border-blue-500 focus:ring-blue-500 pl-8",placeholder:"Procurar"},null,512),[[P,i(s).search]])]),t("button",W,[(n(),d(C(i(I)),{class:"h-4 w-4"}))])],32)])]),tabBody:a(()=>[t("table",X,[t("thead",Y,[t("tr",null,[ee,t("th",{class:"hover:text-accent cursor-pointer",onClick:r[2]||(r[2]=o=>M("nome"))},[l(U,{field:i(s).field,coluna:"nome",direction:i(s).direction},{default:a(()=>[m(" Nome ")]),_:1},8,["field","direction"])]),te,se])]),t("tbody",null,[(n(!0),h(x,null,S(g.dados.data,o=>(n(),h("tr",{key:o.id,class:"hover:bg-gray-100"},[t("td",oe,u(o.id),1),t("td",ae,u(o.nome),1),t("td",ne,u(o.notas),1),t("td",re,[e.$page.props.auth.user.permissions.includes("evento-grupos.edit")?(n(),d(Z,{key:0,onClick:_(T=>N(o.id),["prevent"])},null,8,["onClick"])):f("",!0),e.$page.props.auth.user.permissions.includes("evento-grupos.destroy")?(n(),d(J,{key:1,onClick:_(T=>j(o.id),["prevent"])},null,8,["onClick"])):f("",!0)])]))),128))])])]),tabFooter:a(()=>[ie,l(L,{pagination:g.dados},null,8,["pagination"])]),_:1})]),_:1},8,["title"]),p.value?(n(),d(i(F),{key:0,size:"md",onClose:$},{header:a(()=>[m("Confirma exclusão!")]),body:a(()=>[m("Tem certeza que deseja excluir o registro nº '"+u(v.value)+"'? Esta ação não poderá ser desfeita.",1)]),footer:a(()=>[t("div",le,[t("button",{onClick:r[3]||(r[3]=o=>B(v.value)),type:"button",class:"btn btn-sm btn-accent"}," Sim "),t("button",{onClick:$,type:"button",class:"btn btn-sm"}," Não ")])]),_:1})):f("",!0)],64))}};export{be as default};
