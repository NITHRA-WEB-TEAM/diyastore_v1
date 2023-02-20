import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import { isUserLoggedIn } from './utils'
import routes from '~pages'
import { canNavigate } from '@layouts/plugins/casl'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // ℹ️ We are redirecting to different pages based on role.
    // NOTE: Role is just for UI purposes. ACL is based on abilities.
    {
      path: '/',
      redirect: to => {

        return { name: 'diya-home' }      },
    },
    {
      path: '/diya',
      redirect: to => {

        return { name: 'diya-home' }      },
    },
    ...setupLayouts(routes),
  ],
})
router.beforeEach(to => {
  const isLoggedIn = isUserLoggedIn()

  /*

    ℹ️ Commented code is legacy code

    if (!canNavigate(to)) {
      // Redirect to login if not logged in
      // ℹ️ Only add `to` query param if `to` route is not index route
      if (!isLoggedIn)
        return next({ name: 'login', query: { to: to.name !== 'index' ? to.fullPath : undefined } })

      // If logged in => not authorized
      return next({ name: 'not-authorized' })
    }

    // Redirect if logged in
    if (to.meta.redirectIfLoggedIn && isLoggedIn)
      next('/')

    return next()

    */

})

export default router
