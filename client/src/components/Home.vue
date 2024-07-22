<template>
  <input v-model="search" type="text" placeholder="buscar usuario" />
  <div class="error" v-if="search && !search_users().length"><h1>Usuario no encontrado</h1></div>
  <div class="sucess" v-else>
    <div>
      <table>
        <thead>
          <th>username</th>
          <th>email</th>
          <th>rol</th>
        </thead>
        <tbody>
          <tr v-for="(user, index) in search_users()" :key="index">
            <td>
              {{ user.username }}
            </td>
            <td>
              {{ user.email }}
            </td>
            <td>
              {{ user.rol }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { Ref } from 'vue'

interface User {
  username: string
  email: string
  rol: string
}

const users = [
  {
    username: 'eguerra',
    email: 'eguerra@gmail.com',
    rol: 'admin'
  },
  {
    username: 'mcarrasco',
    email: 'mcarrasco@gmail.com',
    rol: 'user'
  },
  {
    username: 'jruiz',
    email: 'jruiz@gmail.com',
    rol: 'user'
  }
]
let search = ref('')
let search_users = () => {
  console.log(search.value)
  return users.filter(
    (user) =>
      user.username.toLowerCase().includes(search.value.toLowerCase()) ||
      user.email.toLowerCase().includes(search.value.toLowerCase()) ||
      user.rol.toLowerCase().includes(search.value.toLowerCase())
  )
}
const list_user: Ref<Array<User>> = ref(users)
</script>

<style scoped>
.sucess,
.error {
  width: 90%;
  height: 50%;
  padding: 1.5em;
  margin: 0 auto;
}
thead {
  text-transform: uppercase;
  text-align: center;
  background-color: beige;
  color: grey;
}
tbody > tr > td {
  padding: 1em 2em;
}
tbody > tr > td:nth-child(3) {
  text-align: center;
}
</style>
