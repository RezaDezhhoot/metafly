@use('App\Enums\PageAction')
<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.comment')]).(' '.$header ?? '') )
    <x-admin.form-control cancel="{{ route('comment.index') }}" :deleteAble="true" title="{{__('general.sidebar.comment')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <x-admin.forms.validation-errors/>
        <div class="card-body ">
            <x-admin.form-section>
                <x-admin.forms.dropdown  :data="$data['status']" :required="true" id="status" label="{{__('general.status')}}" wire:model.defer="status"/>

                <div wire:ignore.self class="card p-3 w-100 card-custom">
                    <h3 class="shadow-sm p-2 m-4 rounded">
                        {{ $comment->commentable_type }}: {{ $comment->commentable->title }}#{{ $comment->commentable_id }}
                    </h3 >
                    <div class="shadow-sm p-2 m-4 rounded">
                        <ul>
                            <li>{{ $comment->user->email ?? '-' }}</li>
                            <li>{{ $comment->user->phone ?? '-' }}</li>
                        </ul>
                    </div>
                    <div wire:ignore.self class="card-body">
                        <div wire:ignore.self id="scroll-pull" class="scroll scroll-pull" data-height="375" data-mobile-height="300">
                            <div class="messages infinite-scroll">
                                <div class="d-flex flex-column mb-5 align-items-start">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <a class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">
                                                {{ $comment->user->name . ($comment->user_id == auth()->id() ? " (".__('general.you').")" :'') }}
                                                ({{ number_format($comment->likes) }} <i class="flaticon-like text-primary"></i>)
                                            </a>
                                            <span class="text-muted font-size-sm">
                                                     {{ $comment->created_at?->diffForHumans() }}
                                                </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-35 mr-3">
                                            <img alt="avatar" src="/admin/media/bg/bg-1.jpg" />
                                        </div>
                                        <div>
                                            <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-left max-w-100%">
                                                {!! $comment->body !!}
                                            </div>
                                            <div class="shadow-sm p-2 m-4 rounded">
                                                <ul>
                                                    <li>{{__('general.status')}}: {{ $comment->status->label() }}</li>
                                                    <li>{{__('general.phone')}}:{{ $comment->user->phone ?? '-' }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @forelse($comment->replies as $reply)
                                    <div class="d-flex flex-column mb-5 align-items-start">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <a class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">
                                                    {{ $reply->user->name  }}
                                                    ({{ number_format($reply->likes) }} <i class="flaticon-like text-primary"></i>)
                                                </a>
                                                <span class="text-muted font-size-sm">
                                                     {{ $reply->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-35 mr-3">
                                                <img alt="avatar" src="/admin/media/bg/bg-1.jpg" />
                                            </div>
                                            <div>
                                                <div class="mt-2 rounded p-5 bg-light-warning text-dark-50 font-weight-bold font-size-lg text-left max-w-100%">
                                                    {!! $reply->body !!}
                                                </div>
                                                <div class="shadow-sm p-2 m-4 rounded">
                                                    <ul>
                                                        <li>{{__('general.status')}}: {{ $reply->status->label() }}</li>
                                                        <li>{{__('general.phone')}}: {{ $reply->user->phone ?? '-' }}</li>
                                                    </ul>
                                                    <div>
                                                        @if($reply->status === \App\Enums\CommentStatus::DRAFT)
                                                            <x-admin.ok-btn wire:click="confirm('{{$reply->id}}')"/>
                                                        @else
                                                            <button wire:click="toDraft('{{$reply->id}}')" type="button" class="btn btn-sm btn-outline-danger  btn-icon mr-2">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center">
                                        {{ __('general.messages.no_data') }}
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <x-admin.forms.validation-errors/>

                    <div wire:ignore.self class="card-footer align-items-center" id="comment-form">
                        <!--begin::Compose-->
                        <textarea wire:model.defer="replyText" class="form-control border-0 p-0" rows="4" placeholder="{{ __('general.actions.new_message') }}"></textarea>
                        <div class="d-flex align-items-center justify-content-between mt-5">
                            <div>
                                <button wire:click="submitReply()" type="button" class="btn d-flex btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">
                                    {{ __('general.actions.send') }}
                                    <x-admin.loader  />
                                </button>
                            </div>
                        </div>
                        <!--begin::Compose-->
                    </div>
                </div>
            </x-admin.form-section>
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
