/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('bootstrap');
document.addEventListener('DOMContentLoaded', function () {
    function updateMemoryBadge() {
        fetch("/admin/memory-usage")
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('#memory-badge-menu .badge');

                if (badge) {
                    badge.innerText = `${data.percent}%`;

                    if (data.percent < 50) {
                        badge.className = "badge badge-success";
                    } else if (data.percent < 80) {
                        badge.className = "badge badge-warning";
                    } else {
                        badge.className = "badge badge-danger";
                    }
                }
            })
            .catch(error => console.error('Erro ao buscar uso de memória:', error));
    }

    updateMemoryBadge();
    setInterval(updateMemoryBadge, 5000);
});


// window.Vue = require('vue');

// import Toasted from 'vue-toasted';

// Vue.use(Toasted);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('entrada-caixa', require('./components/EntradaCaixa.vue').default);
//Vue.component('tabela-lista', require('./components/TabelaLista.vue').default);


// for more details about using component please check vue.js documentation out.

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// const app = new Vue({
//     el: '#app'
// });
