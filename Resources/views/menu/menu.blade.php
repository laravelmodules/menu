<?php
/**
 * @var \Illuminate\Support\Collection $links
 */
?>
@forelse($links as $key => $link)
    @if(access()->hasPermission($link['permissions']))
        @if(isset($link['heading']) && $link['heading'] && !$isChildren)
            <li class="header">{{ $link['heading'] or '' }}</li>
        @endif
        @php
        $hasChildren = ($link['children']->count()) ? true : false;
        @endphp
        <li class="treeview {{ $hasChildren ? 'menu-item-has-children' : '' }} {{ (in_array($link['id'], $active)) ? 'active open' : '' }}"
            data-id="{{ $link['id'] or '' }}" data-priority="{{ $link['priority'] or '' }}">
            <a href="{{ $link['link'] or '' }}" class="nav-link {{ $hasChildren ? 'nav-toggle' : '' }}">
                {{-- <i class="{{ isset($link['font_icon']) && $link['font_icon'] ? $link['font_icon'] . ' ion' : '' }}"></i> --}}
                <i class="fa {{ isset($link['font_icon']) ? $link['font_icon'] : 'fa-dashboard' }}"></i>
                <span class="title">{{ $link['title'] or '' }}</span>
                @if($hasChildren)
                    {{-- <span class="pull-right-container">
                </span> --}}
                <i class="fa fa-angle-left pull-right"></i>
                @endif
            </a>
            @if($hasChildren)
                <ul class="sub-menu treeview-menu">
                    @include('menu::menu.menu', [
                        'links' => $link['children'],
                        'isChildren' => true,
                        'level' => ($level + 1),
                        'active' => $active,
                    ])
                </ul>
            @endif
        </li>
    @endif
@empty

@endforelse
