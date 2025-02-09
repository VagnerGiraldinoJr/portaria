<script>
    function updateMemoryUsage() {
        fetch("{{ route('admin.memory-usage') }}")
            .then(response => response.json())
            .then(data => {
                let badge = document.getElementById('memory-badge');
                let menuItem = document.querySelector('#memory-badge-menu a span');

                if (badge) {
                    badge.innerText = data.percent + "%";
                }

                if (menuItem) {
                    menuItem.innerText = data.percent + "%";
                }

                // Define a cor do badge com base no uso
                let badgeClass = "badge badge-success float-right"; // Verde
                if (data.percent >= 50 && data.percent < 80) {
                    badgeClass = "badge badge-warning float-right"; // Amarelo
                } else if (data.percent >= 80) {
                    badgeClass = "badge badge-danger float-right"; // Vermelho
                }

                if (badge) {
                    badge.className = badgeClass;
                }
                if (menuItem) {
                    menuItem.className = badgeClass;
                }
            })
            .catch(error => console.error('Erro ao buscar uso de memória:', error));
    }

    // Atualiza a cada 5 segundos
    setInterval(updateMemoryUsage, 5000);
    updateMemoryUsage();
</script>
