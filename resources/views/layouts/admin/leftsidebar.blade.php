@php
use App\Models\Admin\Setting;
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link elevation-4">
        <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ Setting::get('app_name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user() ? auth()->user()->name : "" }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-stream"></i>
                        <p>
                            Категории
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('category.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Создать</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-folder-open"></i>
                        <p>
                            Группа
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('group.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Создать</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('group.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-pencil-alt"></i>
                        <p>
                            Авторы книги
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('author.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Создать</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('author.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-dumpster"></i>
                        <p>
                            Продукты
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('product.index') }}" class="nav-link">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p> Продукт</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.book.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Книги</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('goods.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-horse"></i>
                                <p>Товар</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-shopping-basket"></i>
                        <p>
                            Заказы
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.order.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список заказы</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.chat.order.index') }}" class="nav-link">
                                <i class="nav-icon fab fa-telegram-plane"></i>
                                <p>Чат заказов</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p> Цена
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.priceType.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Тип цены</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (auth()->user()->isAdmin())
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Пользователи
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Создать</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.chat.groups') }}" class="nav-link">
                        <i class="nav-icon fab fa-telegram"></i> Чат-группы
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Настройка
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}" class="nav-link">
                                <i class="fas fa-globe"></i>
                                <p> Общее</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('color.index') }}" class="nav-link">
                                <i class="fas fa-palette"></i>
                                <p> Цвета</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('coverType.index') }}" class="nav-link">
                                <i class="fas fa-paint-brush"></i>
                                <p> Типы Цвета </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
