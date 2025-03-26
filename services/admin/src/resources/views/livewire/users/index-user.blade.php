@use('App\Enums\PageAction')
@use('App\Enums\CategoryType')
<div wire:init="init">
    @section('title', __('pages.pages.index',['item' => __('general.sidebar.users')]) )
    <x-admin.form-control link="{{ route('user.store',[PageAction::CREATE] ) }}" title="{{__('general.sidebar.users')}}"/>
    <div class="card card-custom">
        <div class="card-body">
            @include('livewire.includes.advance-table')
            <div class="row">
                <div class="col-12  table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.id') }}</th>
                            <th>{{ __('general.name') }}</th>
                            <th>{{ __('general.email') }}</th>
                            <th>{{ __('general.phone') }}</th>
                            <th>{{ __('general.roles') }}</th>
                            <th>{{ __('general.actions.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody >
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>
                                    @foreach($item->roles as $role)
                                        <span class="badge badge-primary">
                                                {{ $role->name }}
                                            </span>
                                    @endforeach
                                </td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('user.store',[PageAction::UPDATE , $item->id]) }}"/>
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="18">
                                {{ __('general.messages.no_data') }}
                            </td>
                        @endforelse
                        </tbody>
                        <tbody wire:loading >
                        <x-admin.big-loader :table="true" width="20" height="20" />
                        </tbody>
                    </table>
                </div>
            </div>
            @if(sizeof($items) > 0)
                {{$items->links('layouts.paginate')}}
            @endif
        </div>
    </div>
</div>
