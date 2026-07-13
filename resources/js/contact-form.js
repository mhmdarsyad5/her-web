document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('contactForm')
  if (!form) return

  const submitBtn = form.querySelector('button[type="submit"]')

  // =====================================================
  // BAHASA INDONESIA ONLY
  // =====================================================
  const msg = {
    formIncomplete: 'Form belum lengkap',
    requiredField: 'Field ini wajib diisi.',
    validationFailed: 'Validasi gagal',
    checkInputs: 'Periksa kembali input Anda.',
    messageSent: 'Pesan terkirim',
    willContactSoon: 'Kami akan menghubungi Anda segera.',
    errorOccurred: 'Terjadi kesalahan',
    tryAgain: 'Silakan coba lagi.',
    tooManyRequests: 'Terlalu banyak percobaan',
    waitBeforeRetry: 'Silakan tunggu beberapa menit sebelum mengirim lagi.',
    sending: 'Mengirim...',
    sendMessage: 'Kirim Pesan'
  }

  // =====================================================
  // TOAST CONTAINER
  // =====================================================
  let toastContainer = document.getElementById('toast-container')

  if (!toastContainer) {
    toastContainer = document.createElement('div')
    toastContainer.id = 'toast-container'
    toastContainer.className = 'fixed bottom-6 right-6 z-[9999] space-y-3'
    document.body.appendChild(toastContainer)
  }

  const showToast = (title, message = '', type = 'success') => {
    const toast = document.createElement('div')

    const color =
      type === 'success'
        ? 'border-green-200 bg-green-50 text-green-900'
        : 'border-red-200 bg-red-50 text-red-900'

    toast.className = `
      pointer-events-auto w-[320px] max-w-full rounded-xl border p-4 shadow-lg
      transition-all duration-300 ${color}
    `

    toast.innerHTML = `
      <div class="flex items-start gap-3">
        <div class="mt-0.5">
          ${type === 'success' ? successIcon() : errorIcon()}
        </div>

        <div class="flex-1">
          <p class="text-sm font-semibold">${title}</p>
          ${message ? `<p class="mt-1 text-sm opacity-80">${message}</p>` : ''}
        </div>

        <button class="text-neutral-400 hover:text-neutral-700">
          ${closeIcon()}
        </button>
      </div>
    `

    toast.querySelector('button').onclick = () => toast.remove()
    toastContainer.appendChild(toast)

    setTimeout(() => {
      toast.classList.add('opacity-0', 'translate-y-2')
      setTimeout(() => toast.remove(), 300)
    }, 4000)
  }

  // =====================================================
  // CLIENT VALIDATION
  // =====================================================
  const clearErrors = () => {
    form.querySelectorAll('.form-error').forEach(e => e.remove())
  }

  const showFieldError = (input, message) => {
    const p = document.createElement('p')
    p.className = 'form-error mt-1 text-sm text-red-600'
    p.textContent = message
    input.after(p)
  }

  const validate = () => {
    clearErrors()
    let valid = true

    form.querySelectorAll('[required]').forEach(input => {
      if (!input.value.trim()) {
        valid = false
        showFieldError(input, msg.requiredField)
      }
    })

    return valid
  }

  // =====================================================
  // SUBMIT
  // =====================================================
  form.addEventListener('submit', async e => {
    e.preventDefault()

    if (!validate()) {
      showToast(msg.formIncomplete, msg.requiredField, 'error')
      return
    }

    submitBtn.disabled = true
    submitBtn.innerHTML = `
      <span class="flex items-center gap-2">
        ${spinnerIcon()}
        ${msg.sending}
      </span>
    `

    try {
      const res = await fetch(form.action, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: new FormData(form)
      })

      const data = await res.json()

      if (res.status === 422) {
        // Validation error — tampilkan error per field
        Object.entries(data.errors).forEach(([field, messages]) => {
          const input = form.querySelector(`[name="${field}"]`)
          if (input) showFieldError(input, messages[0])
        })
        showToast(msg.validationFailed, msg.checkInputs, 'error')
      } else if (res.status === 429) {
        // Rate limit terkena — tampilkan pesan tunggu
        showToast(msg.tooManyRequests, msg.waitBeforeRetry, 'error')
      } else if (res.ok && data.success) {
        // Sukses — reset form dan tampilkan toast hijau
        form.reset()
        showToast(msg.messageSent, msg.willContactSoon)
      } else {
        showToast(msg.errorOccurred, msg.tryAgain, 'error')
      }
    } catch {
      showToast(msg.errorOccurred, msg.tryAgain, 'error')
    } finally {
      submitBtn.disabled = false
      submitBtn.innerHTML = `
        <span class="flex items-center gap-2">
          ${sendIcon()}
          ${msg.sendMessage}
        </span>
      `
    }
  })

  // =====================================================
  // ICONS (Heroicons Inline)
  // =====================================================
  function spinnerIcon() {
    return `
      <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
      </svg>
    `
  }

  function sendIcon() {
    return `
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M5 12h14M12 5l7 7-7 7" />
      </svg>
    `
  }

  function successIcon() {
    return `
      <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M5 13l4 4L19 7" />
      </svg>
    `
  }

  function errorIcon() {
    return `
      <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M6 18L18 6M6 6l12 12" />
      </svg>
    `
  }

  function closeIcon() {
    return `
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M6 18L18 6M6 6l12 12" />
      </svg>
    `
  }
})
