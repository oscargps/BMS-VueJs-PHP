import Vue from 'vue'
import Router from 'vue-router'
import hola from '@/components/hola'
import new_pedido from '@/components/new_pedido'
import clientes from '@/components/clientes'
import list from '@/components/list_pedidos'
import tableTemplate from '@/components/tableTemplate'
import users from '@/components/users'

Vue.use(Router)

export default new Router({
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
    }
  ]
})
