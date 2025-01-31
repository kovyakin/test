<x-app-layout>
    <div class="">
        <ul class="nav nav-tabs">
            <li class="nav-item">

                <a
                        @class([
                            'nav-link',
                            'active'=>isset($active_tasks)  ?? true
                                ])
                        aria-current="page"
                        href="{{route('tasks.index')}}">
                    {{__("Task")}}
                </a>

            </li>
            <li class="nav-item">
                <a
                        @class([
                  'nav-link',
                  'active'=>isset($active_tags) ?? true
                      ])

                   href="{{route('tags.index')}}">{{__("Tags")}}</a>
            </li>

        </ul>
    </div>
    @yield('content')

</x-app-layout>
