@use('App\Enums\PageAction')
<div wire:init="init">
    @section('title', __('pages.pages.index',['item' => __('general.sidebar.comments')]) )
    <x-admin.form-control :store="false" title="{{__('general.sidebar.comments')}}"/>
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <x-admin.forms.dropdown  id="status" :data="$data['status']" label="{{__('general.status')}}" wire:model.live="status"/>
            </div>
            @include('livewire.includes.advance-table')
            <div class="row">
                <div class="col-12  table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.user') }}</th>
                            <th>{{ __('general.status') }}</th>
                            <th>{{ __('general.body') }}</th>
                            <th>{{ __('general.commentable') }}</th>
                            <th>{{ __('general.date') }}</th>
                            <th>{{ __('general.likes') }}</th>
                            <th>{{ __('general.replies') }}</th>
                            <th>{{ __('general.actions.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody >
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <ul>
                                        <li>{{ $item->user->name ?? '-' }}</li>
                                        <li>{{ $item->user->email ?? '-' }}</li>
                                        <li>{{ $item->user->phone ?? '-' }}</li>
                                    </ul>
                                </td>
                                <td>{{ $item->status->label() }}</td>
                                <td>{!! str($item->body)->limit(120) !!}</td>
                                <td>{{ $item->commentable_type }}: {{ $item->commentable->title }}#{{ $item->commentable_id }}</td>
                                <td class="jdate">{{ persian_date($item->created_at) }}</td>
                                <td>{{ number_format($item->likes) }} <i class="flaticon-like text-primary"></i></td>
                                <td><span class="text-danger">({{ number_format($item->new_replies_count) }})</span> {{ number_format($item->replies_count) }} <i class="flaticon-reply text-primary"></i> </td>
                                <td>
                                    <x-admin.ok-btn wire:click="confirm('{{$item->id}}')"/>
                                    <x-admin.edit-btn href="{{ route('comment.store',[PageAction::UPDATE , $item->id]) }}"/>
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
