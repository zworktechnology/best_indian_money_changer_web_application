<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="javascript::void(o);">
                <img src="{{ asset('assets/backend/img/logo.png') }}" class="img-fluid logo" alt="">
            </a>
            <a href="javascript::void(o);">
                <img src="{{ asset('assets/backend/img/logo-small.png') }}" class="img-fluid logo-small" alt="">
            </a>
        </div>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul>
                <li class="menu-title" style="text-transform:uppercase"><span>Main</span></li>
                <li class="{{ Route::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><i class="fe fe-home"></i><span style="text-transform:uppercase">Dashboard</span></a>
                </li>
            </ul>

            <ul>
                <li class="menu-title" style="text-transform:uppercase"><span>Inventory</span></li>
                <li
                    class="{{ Route::is('currency.index', 'currency.store', 'currency.edit', 'currency.delete') ? 'active' : '' }}">
                    <a href="{{ route('currency.index') }}"><i class="fe fe-dollar-sign"></i><span style="text-transform:uppercase">Currency</span></a>
                </li>
                <li
                    class="{{ Route::is('currency_optimal.index', 'currency_optimal.store', 'currency_optimal.edit', 'currency_optimal.delete') ? 'active' : '' }}">
                    <a href="{{ route('currency_optimal.index') }}"><i class="fe fe-download"></i><span style="text-transform:uppercase">Currency Optimal</span></a>
                </li>
            </ul>

            <ul>
                <li class="menu-title" style="text-transform:uppercase"><span>Accounts</span></li>
                <li class="{{ Route::is('sale.index', 'sale.create', 'sale.store', 'sale.edit', 'sale.datefilter', 'sale.delete') ? 'active' : '' }}">
                    <a href="{{ route('sale.index') }}"><i class="fe fe-upload"></i><span style="text-transform:uppercase">Sale</span></a>
                </li>
                <li
                    class="{{ Route::is('purchase.index', 'purchase.store', 'purchase.edit', 'purchase.datefilter', 'purchase.delete') ? 'active' : '' }}">
                    <a href="{{ route('purchase.index') }}"><i class="fe fe-download"></i><span style="text-transform:uppercase">Purchase</span></a>
                </li>
            </ul>

            
            <ul>
                <li class="menu-title"><span style="text-transform:uppercase">Customer</span></li>
                <li
                    class="{{ Route::is('customer.index', 'customer.store', 'customer.edit', 'customer.delete') ? 'active' : '' }}">
                    <a href="{{ route('customer.index') }}"><i class="fe fe-user"></i><span style="text-transform:uppercase">Customer</span></a>
                </li>
            </ul>

            <ul>
                <li class="menu-title" style="text-transform:uppercase"><span>Finance & Accounts</span></li>
                <li
                    class="{{ Route::is('expense.index', 'expense.store', 'expense.edit', 'expense.delete') ? 'active' : '' }}">
                    <a href="{{ route('expense.index') }}"><i class="fe fe-book"></i><span style="text-transform:uppercase">Debit Note</span></a>
                </li>
                <li
                    class="{{ Route::is('income.index', 'income.store', 'income.edit', 'income.delete') ? 'active' : '' }}">
                    <a href="{{ route('income.index') }}"><i class="fe fe-book-open"></i><span style="text-transform:uppercase">Credit Note</span></a>
                </li>
            </ul>

            <ul>
                <li class="menu-title" style="text-transform:uppercase"><span>Settings</span></li>
                <li class="">
                    <a href="#"><i class="fe fe-settings"></i><span style="text-transform:uppercase">Settings</span></a>
                </li>
                <li class="">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fe fe-power"></i><span style="text-transform:uppercase">Log Out</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>

        </div>
    </div>
</div>
