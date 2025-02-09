<script>
    // Função para buscar uso de memória e atualizar o menu lateral
    function updateMemoryUsage() {
        fetch("{{ url('/admin/memory-usage') }}")
            .then(response => response.json())
            .then(data => {
                let badge = document.getElementById('memory-badge');

                if (badge) {
                    // Atualiza o texto do badge
                    badge.innerText = `${data.percent}%`;

                    // Adiciona a cor correspondente ao uso da memória
                    if (data.percent < 50) {
                        badge.className = "badge badge-success float-right"; // Verde para uso abaixo de 50%
                    } else if (data.percent < 80) {
                        badge.className = "badge badge-warning float-right"; // Amarelo para 50%-80%
                    } else {
                        badge.className = "badge badge-danger float-right"; // Vermelho para acima de 80%
                    }
                }
            })
            .catch(error => {
                console.error("Erro ao buscar uso de memória:", error);
                // Exibe "Erro" no badge em caso de falha
                let badge = document.getElementById('memory-badge');
                if (badge) {
                    badge.innerText = "Erro";
                    badge.className = "badge badge-danger float-right"; // Vermelho
                }
            });
    }

    // Atualiza o uso da memória ao carregar a página e a cada 5 segundos
    document.addEventListener('DOMContentLoaded', () => {
        updateMemoryUsage();
        setInterval(updateMemoryUsage, 5000);
    });
</script>
