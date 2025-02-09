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
                <span id="memory-badge" class="badge badge-info float-right">Carregando...</span>
            </p>
        </a>
    </li>
    

    <!-- Adicione mais itens aqui conforme necessário -->
</ul>
