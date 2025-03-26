@use('App\Enums\PageAction')
@use('App\Enums\CategoryType')
<div wire:init="init">
    <x-admin.big-loader :loading="$loading" />
    @section('title', __('pages.pages.index',['item' => CategoryType::from($type)->label().' '.__('general.sidebar.categories')]) )
    <x-admin.form-control link="{{ route('category.store',[$type,PageAction::CREATE] ) }}" title="{{CategoryType::from($type)->label().' '.__('general.sidebar.categories')}}"/>
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <x-admin.forms.dropdown width="6" id="sort_by" :data="$data['sort_by']" label="{{__('general.sort_by')}}" wire:model.live="sort"/>
            </div>
            @include('livewire.includes.advance-table')
            <div class="row">
                <div class="col-12  table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('general.id') }}</th>
                                <th>{{ __('general.slug') }}</th>
                                <th>{{ __('general.title') }}</th>
                                <th>{{ __('general.parent') }}</th>
                                <th>{{ __('general.points') }}</th>
                                <th>{{ __('general.actions.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody >
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->parent?->title }}</td>
                                    <td>
                                        @foreach($item->points as $point)
                                            <span class="badge badge-warning">
                                                {{ $point->city }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <x-admin.edit-btn href="{{ route('category.store',[$type,PageAction::UPDATE , $item->id]) }}"/>
                                        <x-admin.delete-btn onclick="deleteItem('{{$item->id}}')"  />
                                    </td>
                                </tr>
                            @empty
                                <td class="text-center" colspan="16">
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
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: '{{ __('general.actions.delete_item') }}',
                text: '{{ __('general.messages.delete_item') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ __('general.actions.no') }}',
                confirmButtonText: '{{ __('general.actions.yes') }}',
            }).then((result) => {
                if (result.value) {
                @this.call('deleteItem', id)
                }
            })
        }
    </script>
@endpush
