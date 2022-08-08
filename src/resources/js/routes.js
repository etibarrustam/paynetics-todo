export const routes = [
    {
        path: '/',
        component: ()=>import('./components/Auth/Auth'),
        redirect: '/login',
        children:[
            {
                path: '/login',
                name:'Login',
                meta:{
                    title: 'Login | VueDashboard'
                },
                component:()=>import('./components/Auth/Login')
            },
        ]
    },
    {
        path: '/',
        redirect: '/login',
        component:()=>import('./components/Layout/Layout'),
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                meta: {
                    title: 'My Dashboard | Paynetics'
                },
                component:()=>import('./components/Dashboard/Dashboard'),
            },
            {
                path: '/project',
                name: 'project',
                meta: {
                    title: 'Project | Paynetics'
                },
                component:()=>import('./components/Project/Project'),
            },
            {
                path: '/task',
                name: 'task',
                meta: {
                    title: 'Task | Paynetics'
                },
                component:()=>import('./components/Task/Task'),
            },
            {
                path: '/user',
                name: 'User',
                meta: {
                    title: 'User | Paynetics'
                },
                component:()=>import('./components/User/User'),
            },
            {
                path: '/logout',
                name: 'logout',
                meta: {
                    title: 'Logout | Paynetics'
                },
                component:()=>import('./components/Logout'),
            },

        ]
    },
    {
        path: '/admin',
        component: ()=>import('./components/Auth/Auth'),
        redirect: '/admin/login',
        children:[
            {
                path: '/admin/login',
                name:'Admin',
                meta:{
                    title: 'Admin Login | VueDashboard'
                },
                component:()=>import('./components/Auth/AdminLogin')
            },
        ]
    },
    {
        path:'*',
        component: () => import('./components/Errors/NotFound')
    }
];
