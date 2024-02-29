import{T as b,o as i,e as d,b as t,u as s,w as l,F as x,Z as h,t as w,f as c,a,c as k,g as u,m as y,n as v,i as V}from"./app-u767hGP_.js";import{A as $}from"./AuthenticationCard-QteFvtSr.js";import{_ as B}from"./AuthenticationCardLogo-5bmHpYXI.js";import{_ as q}from"./Checkbox-gUx4iL91.js";import{_ as f,a as p}from"./TextInput-7X8twFRU.js";import{_ as g}from"./InputLabel-GQgIHaFd.js";import{_ as C}from"./PrimaryButton-0YwmTsHe.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const F={key:0,class:"mb-4 font-medium text-sm text-green-600 dark:text-green-400"},N=a("h1",{class:"pb-5 pt-2 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"}," Faça login em sua conta ",-1),S={class:"mt-5"},L={class:"flex items-center justify-between mt-5"},P={class:"flex items-center"},R=a("span",{class:"ms-2 text-sm text-gray-600 dark:text-gray-400"},"Remember me",-1),U={class:"block mb-3 mt-5"},G={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(m){const e=b({email:"",password:"",remember:!1}),_=()=>{e.transform(n=>({...n,remember:e.remember?"on":""})).post(route("login"),{onFinish:()=>e.reset("password")})};return(n,o)=>(i(),d(x,null,[t(s(h),{title:"Log in"}),t($,null,{logo:l(()=>[t(B)]),default:l(()=>[m.status?(i(),d("div",F,w(m.status),1)):c("",!0),N,a("form",{onSubmit:V(_,["prevent"])},[a("div",null,[t(g,{for:"email",value:"Seu email"}),t(f,{id:"email",modelValue:s(e).email,"onUpdate:modelValue":o[0]||(o[0]=r=>s(e).email=r),type:"email",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"username",placeholder:"test@test.com"},null,8,["modelValue"]),t(p,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),a("div",S,[t(g,{for:"password",value:"Password"}),t(f,{id:"password",modelValue:s(e).password,"onUpdate:modelValue":o[1]||(o[1]=r=>s(e).password=r),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"current-password",placeholder:"*********"},null,8,["modelValue"]),t(p,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),a("div",L,[a("label",P,[t(q,{checked:s(e).remember,"onUpdate:checked":o[2]||(o[2]=r=>s(e).remember=r),name:"remember"},null,8,["checked"]),R]),m.canResetPassword?(i(),k(s(y),{key:0,href:n.route("password.request"),class:"hover:underline font-medium text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"},{default:l(()=>[u(" Esqueceu sua senha? ")]),_:1},8,["href"])):c("",!0)]),a("div",U,[t(C,{class:v(["w-full pb-4 justify-center",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:l(()=>[u(" Log in ")]),_:1},8,["class","disabled"])])],32)]),_:1})],64))}};export{G as default};
