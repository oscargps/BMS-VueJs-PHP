<template lang="html">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <router-link to="/" class="navbar-brand">
       Gestor de Pedidos
     </router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <b-dropdown id="navbarColor01" text="Pedidos" variant="primary" class="m-md-2">
    <b-dropdown-item><router-link to="/new" class="dropdown-item">Nuevo</router-link></b-dropdown-item>
    <b-dropdown-item><router-link to="/list" class="dropdown-item">Lista de Pedidos</router-link></b-dropdown-item>
    <b-dropdown-item>Cambiar estado</b-dropdown-item>
    <b-dropdown-divider></b-dropdown-divider>
  </b-dropdown>

          <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <router-link to="/clientes" class="nav-link">
                   Clientes
                 </router-link>
                </li>
            <li class="nav-item active">
              <router-link to="/users" class="nav-link">
                   Usuarios
                 </router-link>
            </li>
            <li class="nav-item active">
                <router-link to="/process" class="nav-link">
                   Procesos
                </router-link>
            </li>
          </ul>
        </div>
  </nav>
</template>

<script>
export default {
}
</script>

<style lang="css" scoped>
</style>
