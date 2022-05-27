@props(['content' => 'Please add content to this widget'])

<div class="widget-wrapper secondary">
    @if (isset($header))
    <div class="widget-header">
        <div class="widget-title">
            {{ $header }}
        </div>
    </div>
    @endif

    <div class="widget-content">
        {{ $content }}
    </div>
</div>
