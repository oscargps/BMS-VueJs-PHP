import Vue from 'vue'
import Router from 'vue-router'
import hola from '@/components/hola'
import new_pedido from '@/components/new_pedido'
import clientes from '@/components/clientes'
import list from '@/components/list_pedidos'
import tableTemplate from '@/components/tableTemplate'
import users from '@/components/users'
import process from '@/components/process'
import detailsPedido from '@/components/detailsPedido'
import facturacion from '@/components/facturacion'
import productos from '@/components/productos'
import index from '@/components/facturacion/index'
import graficas from '@/components/facturacion/graficas'
Vue.use(Router)

export default new Router({
  mode:"history",
  routes: [
    {
      path: '/',
      name: 'hola',
      component: hola
    },
    {
      path: '/new',
      name: 'new_pedido',
      component: new_pedido
    },
    {
      path: '/clientes',
      name: 'clientes',
      component: clientes
    },
    {
      path: '/list',
      name: 'list',
      component: list
    },
    {
      path: '/users',
      name: 'users',
      component: users
    },
    {
      path: '/process',
      name: 'process',
      component: process
    },
    {
      path: '/detailsPedido',
      name: 'detailsPedido',
      component: detailsPedido
    },
    {
      path: '/facturacion',
      name: 'facturacion',
      component: facturacion,
      children:[
        { path: ':title', component: index, props: true  },
      ]
    },
    {
      path: '/productos',
      name: 'productos',
      component: productos

    }
  ]
})
