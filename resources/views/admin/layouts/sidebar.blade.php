<!-- resources/views/admin/layouts/sidebar.blade.php -->

<ul class="sidebar-menu">
    <li class="header">Menu Principal</li>
    <li><a href="{{ route('admin') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
    <li><a href="{{ route('admin.lote.index') }}"><i class="fas fa-layer-group"></i> <span>Lotes</span></a></li>

    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-memory"></i>
            <p>
                Uso de Memória
                <span id="memory-badge" class="badge badge-info float-right">Carregando.1.2.3..</span>
            </p>
        </a>
    </li>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateMemoryBadge() {
                fetch("{{ url('/admin/memory-usage') }}")
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
    </script>



    <!-- Adicione mais itens aqui conforme necessário -->
</ul>
