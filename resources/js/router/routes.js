import Permissions from "../mixins/Permissions"

function page(path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  {
    path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ]
  },

  {
    path: "/iam", component: page("iam/index.vue"), name: "iam.index",
    children: [
      { path: "/iam/users", component: page("iam/users.vue"), name: "iam.users" },
      { path: "/iam/users/new", component: page("iam/users-edit.vue"), name: "iam.users-new" },
      { path: "/iam/users/edit/:id", component: page("iam/users-edit.vue"), name: "iam.users-edit" },
      { path: "/iam/roles", component: page("iam/roles.vue"), name: "iam.roles" },
      { path: "/iam/roles/new", component: page("iam/roles-edit.vue"), name: "iam.roles-new" },
      { path: "/iam/roles/edit/:id", component: page("iam/roles-edit.vue"), name: "iam.roles-edit" },
    ]
  },

  {
    path: "/backend", component: page("backend/index.vue"), name: "backend", redirect: { name: "backend.circles" },
    children: [
      {
        path: "/backend/circles", component: page("backend/circles.vue"), name: "backend.circles",
        beforeEnter: checkPerm, meta: { permission: "display circles" }
      },
      {
        path: "/backend/circles/edit/:id", component: page("backend/circles-edit.vue"), name: "backend.circles-edit",
        beforeEnter: checkPerm, meta: { permission: ["display circles", "edit circles"] }
      },
      { path: "/backend/circles/new", component: page("backend/circles-edit.vue"), name: "backend.circles-new", beforeEnter: checkPerm, meta: { permission: "create circles" } },
      { path: "/backend/super-circles", component: page("backend/super-circles.vue"), name: "backend.super-circles" },
      { path: "/backend/super-circles/edit/:id", component: page("backend/super-circles-edit.vue"), name: "backend.super-circles-edit" },
      { path: "/backend/super-circles/new", component: page("backend/super-circles-edit.vue"), name: "backend.super-circles-new" },
      { path: "/backend/justifications", component: page("backend/justifications.vue"), name: "backend.justifications" },
      { path: "/backend/justifications/edit/:id", component: page("backend/justifications-edit.vue"), name: "backend.justifications-edit" },
      { path: "/backend/justifications/new", component: page("backend/justifications-edit.vue"), name: "backend.justifications-new" },
    ]
  },

  { path: '*', component: page('errors/404.vue') },
  { path: '/unauthorized', component: page('errors/401.vue'), name: "unauthorized" },
]

function checkPerm(to, from, next) {
  if (Permissions.methods.$can(to.meta.permission)) return next();
  else return next({ name: "unauthorized" });
}