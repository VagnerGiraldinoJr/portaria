<script>
    document.addEventListener('DOMContentLoaded', () => {
        function updateMemoryUsage() {
            fetch("{{ url('/admin/memory-usage') }}")
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('memory-badge');

                    if (badge) {
                        badge.innerText = `${data.percent}%`;

                        // Atualizar a cor do badge com base no uso de memória
                        if (data.percent < 50) {
                            badge.className = "badge badge-success float-right"; // Verde
                        } else if (data.percent < 80) {
                            badge.className = "badge badge-warning float-right"; // Amarelo
                        } else {
                            badge.className = "badge badge-danger float-right"; // Vermelho
                        }
                    }
                })
                .catch(error => {
                    console.error("Erro ao buscar uso de memória:", error);

                    // Mostra "Erro" no badge em caso de falha
                    const badge = document.getElementById('memory-badge');
                    if (badge) {
                        badge.innerText = "Erro";
                        badge.className = "badge badge-danger float-right";
                    }
                });
        }

        // Chama a função ao carregar a página e a cada 5 segundos
        updateMemoryUsage();
        setInterval(updateMemoryUsage, 5000);
    });
</script>
