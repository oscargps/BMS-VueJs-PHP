<template lang="html">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <router-link to="/" class="navbar-brand">
      BMS 
    </router-link>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarColor01" style="">
      <b-dropdown text="Pedidos" variant="primary" class="m-md-2">
        <b-dropdown-item>
          <router-link to="/new" class="dropdown-item">Nuevo</router-link>
        </b-dropdown-item>
        <b-dropdown-item>
          <router-link to="/list" class="dropdown-item">Lista de Pedidos</router-link>
        </b-dropdown-item>
      </b-dropdown>

      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <router-link to="/productos" class="nav-link">
            Productos
          </router-link>
        </li>
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
        <li class="nav-item active">
          <router-link to="/facturacion" class="nav-link">
            Facturacion
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
