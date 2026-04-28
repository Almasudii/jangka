import '../css/app.css'
import './bootstrap'

import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, h, watch } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)

    // 🌙 Atur dark mode berdasarkan data dari backend
    const setDarkMode = (enabled) => {
      if (enabled) {
        document.documentElement.classList.add('dark')
      } else {
        document.documentElement.classList.remove('dark')
      }
    }

    // Aktifkan dark mode awal sesuai setting user
    const initialDark = props.initialPage.props.settings?.dark_mode ?? false
    setDarkMode(initialDark)

    // Awasi perubahan props (misal setelah update pengaturan)
    watch(
      () => props.initialPage.props.settings?.dark_mode,
      (newVal) => setDarkMode(newVal)
    )

    app.mount(el)
    return app
  },
  progress: {
    color: '#4B5563',
  },
})
