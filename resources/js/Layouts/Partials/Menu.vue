<template>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index3.html" class="brand-link">
            <img src="~admin-lte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <div class="sidebar">

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="~admin-lte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Alexander Pierce</a>
                </div>
            </div>                 

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    
                    <li class="nav-item">
                        <Link :href="route('home')" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Accueil  
                            </p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('contact')" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Contact  
                            </p>
                        </Link>
                    </li>
                </ul>
            </nav>

        </div>
    </aside>
    
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
</script>