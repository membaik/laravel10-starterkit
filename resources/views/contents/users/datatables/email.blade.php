@if ($query->email)
    {{ $query->email }}
@else
    <span class="text-muted fst-italic">{{ ucwords(__('None')) }}</span>
@endif
