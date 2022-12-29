<template>
    <div>
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                </ul> 
            </nav>


           <Menu />

            <div class="content-wrapper">
                <slot />
            </div>

            <Footer />
        </div>
    </div>
</template>

<script setup>
    import Menu from "./Partials/Menu.vue"
    import Footer from "./Partials/Footer.vue"
</script>