<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 to-slate-800">
    <div class="w-full max-w-md bg-slate-900 border border-slate-700 rounded-2xl shadow-xl p-8">

      <h1 class="text-2xl font-bold text-white text-center mb-2">
        Login
      </h1>
      <p class="text-center text-slate-400 mb-6">
        Masuk dengan akun
      </p>

      <!-- ERROR -->
      <div v-if="error" class="mb-4 text-sm text-red-400 bg-red-900/30 p-3 rounded">
        {{ error }}
      </div>

      <form @submit.prevent="login" class="space-y-4">

        <div>
          <label class="block text-slate-300 text-sm mb-1">Username</label>
          <input
            v-model="form.username"
            type="text"
            placeholder="Masukkan username"
            class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none"
          />
        </div>

        <div>
          <label class="block text-slate-300 text-sm mb-1">Password</label>
          <input
            v-model="form.password"
            type="password"
            placeholder="Masukkan password"
            class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:ring-2 focus:ring-blue-500 outline-none"
          />
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="w-full py-2 rounded-lg bg-blue-600 hover:bg-blue-700 transition text-white font-semibold disabled:opacity-60"
        >
          {{ loading ? 'Login...' : 'Login' }}
        </button>

      </form>

      <p class="text-center text-slate-500 text-xs mt-6">
        © 2026 API Auth System
      </p>

    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',

  data() {
    return {
      form: {
        username: '',
        password: ''
      },
      loading: false,
      error: null
    }
  },

  methods: {
    async login() {
      this.error = null
      this.loading = true

      try {
        const response = await fetch('/api/v1/auth/signin', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.form)
        })

        const result = await response.json()

        if (!response.ok) {
          this.error = result.message || 'Login gagal'
          this.loading = false
          return
        }

        // SIMPAN TOKEN
        localStorage.setItem('token', result.token)

        // redirect (contoh)
        window.location.href = '/dashboard'

      } catch (err) {
        this.error = 'Server error'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>