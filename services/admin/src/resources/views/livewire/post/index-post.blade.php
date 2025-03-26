@use('App\Enums\PageAction')
@use('App\Enums\CategoryType')
<div wire:init="init">
    @section('title', __('pages.pages.index',['item' => __('general.sidebar.posts')]) )
    <x-admin.form-control link="{{ route('post.store',[PageAction::CREATE] ) }}" title="{{__('general.sidebar.posts')}}"/>
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <x-admin.forms.dropdown width="4" id="status" :data="$data['status']" label="{{__('general.status')}}" wire:model.live="status"/>
                <x-admin.forms.select2 :multiple="true" width="4" id="category" label="{{__('general.category')}}" ajaxUrl="{{route('category.feed',['type'=> CategoryType::POST])}}" wire:model.defer="category"/>
                <x-admin.forms.dropdown width="4" id="sort_by" :data="$data['sort_by']" label="{{__('general.sort_by')}}" wire:model.live="sort"/>
                <x-admin.forms.checkbox id="slider" label="{{__('general.slider')}}"  wire:model.live="slider"/>
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
                            <th>{{ __('general.status') }}</th>
                            <th>{{ __('general.date') }}</th>
                            <th>{{ __('general.views') }}</th>
                            <th>{{ __('general.study_time') }}</th>
                            <th>{{ __('general.author') }}</th>
                            <th>{{ __('general.slider') }}</th>
                            <th>{{ __('general.categories') }}</th>
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
                                <td>{{ $item->status->label() }}</td>
                                <td class="jdate">{{ persian_date($item->created_at) }}</td>
                                <td>{{ number_format($item->views) }}</td>
                                <td>{{ $item->study_time }}</td>
                                <td>{{ $item->author->name }}</td>
                                <td><i class="fa {{ $item->slider ? 'fa-check text-success' : 'fa-times text-danger' }} "></i></td>
                                <td>
                                    @foreach($item->categories as $category)
                                        <span class="badge badge-primary">
                                                {{ $category->title }}
                                            </span>
                                    @endforeach
                                </td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('post.store',[PageAction::UPDATE , $item->id]) }}"/>
                                    <x-admin.delete-btn onclick="deleteItem('{{$item->id}}')"  />
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
